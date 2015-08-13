<?php

namespace DLCompare\LoLApiBundle\Api;

use DLCompare\LoLApiBundle\Api\Service\ServiceInterface;
use DLCompare\LoLApiBundle\Api\Cache\CacheInterface;
use DLCompare\LoLApiBundle\Api\Exception\BadRequestException;
use DLCompare\LoLApiBundle\Api\Exception\UnauthorizedException;
use DLCompare\LoLApiBundle\Api\Exception\UnfoundObjectException;
use DLCompare\LoLApiBundle\Api\Exception\RateLimitExceededException;
use DLCompare\LoLApiBundle\Api\Exception\InternalServerErrorException;
use DLCompare\LoLApiBundle\Api\Exception\ServiceUnavailableException;

/**
 * Main Api service for the bundle.
 * It will be your entry point to access any webservice of the League Of Legends Api
 */
class Api
{    
    /**
     * @var string
     */
    static protected $api_key;

    /**
     * @var DLCompare\LoLApiBundle\Api\Cache\CacheInterface
     */
    static protected $cache;

    /**
     * @var string
     */
    protected $region = "euw";
    
    /**
     * Main class constructor. Sets api key
     *
     * @param string $api_key
     * @return Api
     */
    public function __construct($api_key, CacheInterface $cache)
    {
        self::$api_key   = $api_key;
        self::$cache     = $cache;
    } 

    /**
     * Set region of api
     *
     * @param string $region
     * @return Api
     */
    public function setRegion($region)
    {
        $this->region = $region;
        return $this;
    }
        
    /**
     * Calls a webservice and it's method :
     * 1/ looking for the proper service
     * 2/ looking for a method for this given service
     * 3/ building url given arguments
     * 4/ looks for cached data
     * 5/ retrieve content from url if needed and sets cache
     *
     * @param string $service_code
     * @param string $method_code
     * @param array $arguments
     * @param array $querystring
     * @return string
     *
     * @throws \LogicException
     */
    public function call($service_code, $method_code, array $arguments = array(), array $querystring = array())
    {
        $service = $this->getServiceFromCode($service_code);
        $method  = $service->getMethod($method_code);

        if(!self::$cache->has($method, array_merge($arguments, $querystring)))
        {
            $url     = $this->buildUrl($service, $method, $arguments, $querystring);

            try
            {
                $content = $this->getContent($url);
            } 
            catch(RateLimitExceededException $e)
            {
                sleep(200);
                $content = $this->getContent($url);
            }
            self::$cache->set($method, array_merge($arguments, $querystring), $content);
        }
        else
        {
            $content = self::$cache->get($method, array_merge($arguments, $querystring));
        }
        
        return  json_decode($content);
    }
    
    /**
     * Retrieve a webservice class given it's a code
     *
     * @param string $service_code
     * @return DLCompare\LoLApiBundle\Api\Service\ServiceInterface
     *
     * @throws \RunTimeException
     * @throws \InvalidArgumentException
     */
    protected function getServiceFromCode($service_code)
    {
        if(!class_exists($service_code))
        {
            $camel = explode('_', $service_code);
            if(count($camel) > 0)
            {
                $service_code = '';
                foreach($camel as $case)
                {
                    $service_code.= ucfirst(strtolower($case));
                }
            }

            $class = '\\DLCompare\\LoLApiBundle\\Api\\Service\\' . $service_code;     

            $service_code = $class;
        }
        
        if(class_exists($service_code))
        {
            $service = new $service_code();
            if(!$service instanceof ServiceInterface)
            {
                throw new \RunTimeException('The service "' . $service_code . '" must implement a proper ServiceInterface');
            }
            
            return $service;
        }
        
        throw new \InvalidArgumentException('Unreachable service "' . $service_code . '"');
    }

    /**
     * Builds the url for the given webservice call
     *
     * @param DLCompare\LoLApiBundle\Api\Service\ServiceInterface $service
     * @param array $arguments
     * @param array $querystring
     * @return string
     *
     * @throws \LogicException
     */
    protected function buildUrl(ServiceInterface $service, Method $method, array $arguments = array(), array $querystring = array())
    {
        $url = "https://{region}.api.pvp.net/"
            . $service->getPrefix()
            . '/'
            . $method->getSuffix()
            . '?api_key='
            . self::$api_key;
        
        $url = str_replace('{region}', $this->region, $url); 
        $url = str_replace('{version}', $service->getVersion(), $url);

        foreach($arguments as $key => $value)
        {
            $url = str_replace('{' . $key . '}', $value, $url);
        }

        $nok = preg_match_all("|{([\w]+)}|U", $url, $missing, PREG_SET_ORDER);
        if($nok > 0)
        {
            $params = [];
            foreach($missing as $param)
            {
                $params[] = $param[0];
            }
            throw new \LogicException('Missing parameters for this webservice : ' . implode(',', $params));
        }

        foreach($querystring as $key => $value)
        {
            $url .= '&' . $key . '=' . $value;
        }
        
        return $url;
    }

    /**
     * Get content of the given url
     *
     * @param string url
     * @return string
     *
     * @throws DLCompare\LoLApiBundle\Api\Exception\BadRequestException
     * @throws DLCompare\LoLApiBundle\Api\Exception\UnauthorizedException
     * @throws DLCompare\LoLApiBundle\Api\Exception\UnfoundObjectException
     * @throws DLCompare\LoLApiBundle\Api\Exception\RateLimitExceededException
     * @throws DLCompare\LoLApiBundle\Api\Exception\InternalServerErrorException
     * @throws DLCompare\LoLApiBundle\Api\Exception\ServiceUnavailableException
     * @throws \Exception
     */
    protected function getContent($url)
    {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $content  = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $message = $httpcode . ' : ' . $url;
        switch($httpcode)
        {
            case 200: return $content;
            case 400: throw new BadRequestException($message); break;
            case 401: throw new UnauthorizedException($message); break;
            case 403: throw new BadRequestException($message); break;
            case 404: throw new UnfoundObjectException($message); break;
            case 429: throw new RateLimitExceededException($message); break;
            case 500: throw new InternalServerErrorException($message); break;
            case 503: throw new ServiceUnavailableException($message); break;
            default: throw new \Exception('Error returned from webservice with status code : '. $httpcode); break;

        }
    }
}
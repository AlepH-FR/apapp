<?php

namespace DLCompare\CacheBundle\EventListener;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ParameterBag;

class ActionCacheListener implements EventSubscriberInterface
{
    public function onKernelController(FilterControllerEvent $event)
    {        
        if (!is_array($controller = $event->getController())) {
            return;
        }

        $request = $event->getRequest();

        if (!$configuration = $request->attributes->get('_action_cache')) {
            return;
        }
        
        $cache_path = $this->getCachePath($controller, $request->attributes, $request->getSession()->get('site', 1), $request->getSession()->get('currency', 1));
        
        $time = time();
        if(!file_exists($cache_path) 
        || $time - filemtime($cache_path) > $configuration->getMaxAge())
        {
            $request->attributes->set('_cache_add', true);
            $request->attributes->set('_cache_path', $cache_path);
        } else {
            $cache = file_get_contents($cache_path);
            $event->setController(function() use ($cache) {
                $response = new Response();
                $response->setContent($cache);
                return $response;
            });
        }
    }
    
    public function onKernelTerminate(FilterResponseEvent $event)
    {   
        $request = $event->getRequest();
        $to_add  = $request->attributes->get('_cache_add');
        
        if($to_add === true)
        {
            $content    = $event->getResponse()->getContent();
            $cache_path = $request->attributes->get('_cache_path');
            file_put_contents($cache_path, $content);
        }
    }
    
    protected function getCachePath(array $controller_data, ParameterBag $attributes, $site, $currency)
    {
        $controller = str_replace('\\', '_', get_class($controller_data[0]));
        $controller = substr($controller, 0, strlen($controller)-10);
        $action     = substr($controller_data[1], 0, strlen($controller_data[1])-6);
        
        $path = '/home/goat/apapp/app/cache/' . strtolower($controller.'_'.$action) . '_site-' . $site . '_currency-' . $currency;
        
        $attributes = $attributes->all();
        $attributes = array_filter($attributes, function($value) use (&$attributes, &$path) {
            $key = key($attributes);
            if(!is_string($key)) { next($attributes); return false; }
            if(substr($key, 0, 1) === "_") { next($attributes); return false; }
            next($attributes);

            $path.= '_'.$key.'-'.$value;
        });

        return $path;
    }

    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::CONTROLLER => 'onKernelController',
            KernelEvents::RESPONSE   => 'onKernelTerminate',
        );
    }
}

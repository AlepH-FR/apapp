<?php

namespace DLCompare\ApAppBundle\Stats;

abstract class AbstractStats
{
	protected $container; 

    public function __call($name, array $arguments)
    {
        $method = '_' . $name;
        $file   = $this->getCacheFilename($method, $arguments);

        if(!file_exists($file) || (time() > filemtime($file) + 86400))
        {
            if(!method_exists($this, $method))
            {
                $method = '_get' . ucfirst($name);
            }
            $result = call_user_func_array([$this, $method], $arguments);
            file_put_contents($file, $result);
            return $result;
        }
        else
        {
            return file_get_contents($file);
        }
    }

    abstract public function getCacheId();

    protected function getCacheKey($method, $arguments)
    {
        $key = 'apapp_';
        $key.= $this->getCacheId();
        $key.= $method;

        foreach($arguments as $k => $v)
        {
            if(is_object($v)) { $v = $v->getId(); }
            $key.= "." . $k . "-" . $v;
        }

        $key = str_replace(['/', '{', '}'], ['_','',''], $key);

        return $key;
    }

    protected function getCacheFilename($method, $arguments)
    {
        $key = $this->getCacheKey($method, $arguments);

        $path = __DIR__ . '/../../../..' . '/app/cache/' . $key;
        return $path;
    }
}
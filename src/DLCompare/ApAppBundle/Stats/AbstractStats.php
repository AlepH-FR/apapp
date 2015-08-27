<?php

namespace DLCompare\ApAppBundle\Stats;

abstract class AbstractStats
{
	protected $container; 

    protected $refresh = false;

    public function __call($name, array $arguments)
    {
        $method = '_' . $name;
        if(!method_exists($this, $method))
        {
            $method = '_get' . ucfirst($name);
        }
        $file   = $this->getCacheFilename($method, $arguments);

        if($this->refresh || !file_exists($file))
        {
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

    public function setRefresh($refresh)
    {
        $this->refresh = $refresh;
    }

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
<?php

namespace DLCompare\CacheBundle\Configuration;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ConfigurationAnnotation;

/**
 * @Annotation
 */
class ActionCache extends ConfigurationAnnotation
{
    /**
     * The number of seconds that the response is considered fresh by a private
     * cache like a web browser.
     *
     * @var integer
     */
    protected $maxage;

    /**
     * Sets the number of seconds for the max-age cache-control header field.
     *
     * @param integer $maxage A number of seconds
     */
    public function setMaxAge($maxage)
    {
        $this->maxage = $maxage;
    }

    /**
     * Returns the number of seconds the response is considered fresh by a
     * private cache.
     *
     * @return integer
     */
    public function getMaxAge()
    {
        return $this->maxage;
    }

    /**
     * Returns the annotation alias name.
     *
     * @return string
     * @see ConfigurationInterface
     */
    public function getAliasName()
    {
        return 'action_cache';
    }

    /**
     * Only one cache directive is allowed
     *
     * @return Boolean
     * @see ConfigurationInterface
     */
    public function allowArray()
    {
        return false;
    }
}
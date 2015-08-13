<?php

namespace DLCompare\ApAppBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use DLCompare\ApAppBundle\DependencyInjection\DLCompareApAppExtension as Extension;

class DLCompareApAppBundle extends Bundle
{	
	/**
	 * Yeahhhh. We know this is ugly.
	 * But even symfony2 have some uglyness inside right ?
     *
	 * @return DLCompare\ApAppBundle\DependencyInjection\DLCompareApAppExtension
	 */
	public function getContainerExtension()
	{
        if (null === $this->extension) {
            $this->extension = new Extension();
        }

        return $this->extension;
	}
}
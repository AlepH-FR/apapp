<?php

namespace DLCompare\LoLApiBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use DLCompare\LoLApiBundle\DependencyInjection\DLCompareLoLApiExtension as Extension;

class DLCompareLoLApiBundle extends Bundle
{
	/**
	 * Yeahhhh. We know this is ugly.
	 * But even symfony2 have some uglyness inside right ?
     *
	 * @return DLCompare\ApAppBundle\DependencyInjection\DLCompareLoLApiExtension
	 */
	public function getContainerExtension()
	{
        if (null === $this->extension) {
            $this->extension = new Extension();
        }

        return $this->extension;
	}
}

<?php

namespace DLCompare\LoLApiBundle\Api\Service;

use DLCompare\LoLApiBundle\Api\Method;

class StaticData extends AbstractService implements ServiceInterface
{
    /**
     * {@inheritdoc}
     */
	public function getCode()
	{
		return "static_data";
	}

    /**
     * {@inheritdoc}
     */
    public function getPrefix()
    {
    	return "api/lol/static-data/{region}/v{version}";
    }

    /**
     * {@inheritdoc}
     */
    public function getVersion()
    {
    	return "1.2";
    }

    /**
     * {@inheritdoc}
     */
    public function getAvailableMethods() 
    { 
        return [
    		"item_list" 		=> new Method($this, "item"),
    		"item_details"		=> new Method($this, "item/{id}"),
    		"champion_list" 	=> new Method($this, "champion"),
    		"champion_details"	=> new Method($this, "champion/{id}"),
            "language_list"     => new Method($this, "languages"),
            "language_strings"  => new Method($this, "language-strings"),
            "map"               => new Method($this, "map"),
            "mastery_list"      => new Method($this, "mastery"),
            "mastery_details"   => new Method($this, "mastery/{id}"),
            "realm"             => new Method($this, "realm"),
            "rune_list"         => new Method($this, "rune"),
            "rune_details"      => new Method($this, "rune/{id}"),
            "spell_list"        => new Method($this, "summoner-spell"),
            "spell_details"     => new Method($this, "summoner-spell/{id}"),
            "version_list"      => new Method($this, "versions"),
    	];
    }
}
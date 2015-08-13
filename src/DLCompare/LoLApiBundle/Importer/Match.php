<?php

namespace DLCompare\LoLApiBundle\Importer;

use DLCompare\LoLApiBundle\Api\Api;
use DLCompare\LoLApiBundle\Entity\Champion;
use DLCompare\LoLApiBundle\Entity\Game;
use DLCompare\LoLApiBundle\Entity\Item;
use DLCompare\LoLApiBundle\Entity\Participant;
use DLCompare\LoLApiBundle\Entity\Summoner;

class Match
{    
    public function __construct(Api $api)
    {
    	$this->api = $api;
    }

    public function import($region, $matchId)
    {
    	$em = $this->get('doctrine.orm.entity_manager');

    	// look if game was already parsed
    	$game = $this->get('dlcompare_lolapi.manager.game')->findOneByDistantId($matchId);
    	if($game) { return; }

    	// api call
    	$this->api->setRegion($region);
    	$data = $this->api->call('match', 'details', ['matchId' => $matchId]);

    	// retrieving game data
    	$game = new Game();
    	$game
    		->setDistantId($matchId)
    		->setRegion($region)
    		->setMatchMode($data->matchMode)
    		->setMatchType($data->matchType)
    		->setQueueType($data->queueType)
    		->setSeason($data->season)
    		->setPlatformId($data->platformId)
    		->setVersion($data->version)
    		->setData($data);
    	$em->persist($game);

    	// retrieving summoner data
    	$summoners = [];
    	foreach($data->participantIdentities as $k => $pi)
    	{
    		$summoner = $this->get('dlcompare_lolapi.manager.summoner')->findOneByDistantId($pi->summonerId);

    		if(!$summoner)
    		{
	    		$summoner = new Summoner();
	    		$summoner
	    			->setDistantId($pi->summonerId)
	    			->setName($pi->summonerName)
	    		;
	    		$em->persist($summoner);
	    	}

	    	$summoners[$k] = $summoner;
    	}

    	// retriever participant data
    	foreach($data->participants as $p)
    	{
    		$champion = $this->get('dlcompare_lolapi.manager.champion')->findOneByDistantId($p->championId);
    		if(!$champion)
    		{
    			$champion = $this->get('lolapi.importer.champion')->import($p->championId);
    		}
    		$participant = new Participant();
    		$participant
    			->setGame($game)
    			->setSummoner($summoners[$p->participantId])
    			->setChampion($champion)
    			->setWinner($p->stats->winner)
    			->setKills($p->stats->kills)
    			->setDeath($p->stats->death)
    			->setAssists($p->stats->assists)
    			->setGold($p->stats->goldEarned)
    			->setDamageTaken($p->stats->totalDamageTaken)
    			->setDamageDealt($p->stats->totalDamageDealtToChampions)
    		;
    		$em->persist($participant);
    	}

    	$em->flush();

    	var_dump($data->matchCreation); die;
    }
}
<?php

namespace DLCompare\LoLApiBundle\Importer;

use Doctrine\ORM\EntityManager;
use DLCompare\LoLApiBundle\Api\Api;

class MatchImporter implements ImporterInterface
{    
	/**
	 * @var DLCompare\LoLApiBundle\Api\Api
	 */
	protected $api;

	/**
	 * @var Doctrine\ORM\EntityManager
	 */
	protected $em;

	/**
	 * @var ImporterFactory
	 */
	protected $factory;

    /**
     * {@inheritDoc}
     */
    public function __construct(Api $api, EntityManager $em, ImporterFactory $factory)
    {
    	$this->api 		= $api;
    	$this->em  		= $em;
    	$this->factory  = $factory;
    }

    /**
     * Calls the api for information about this game and create proper entites
     *
     * @param array $variables
     * @return is_object(var)
     */
    public function import(array $variables)
    {
    	$region  = $variables['region'];
    	$matchId = $variables['matchId'];

    	// -- Game
    	$game_class 	= $this->factory->getEntityClass('game');
    	$champion_class = $this->factory->getEntityClass('champion');
    	$item_class 	= $this->factory->getEntityClass('item');
    	$game = $this->em->getRepository($game_class)->findOneByDistantId($matchId);
    	if($game) { return; }

    	$this->api->setRegion($variables['region']);
    	$data = $this->api->call('match', 'details', ['matchId' => $matchId]);

    	$createdAt = new \DateTime();
    	$createdAt->setTimestamp($data->matchCreation);
    	$game = new $game_class();
    	$game
    		->setDistantId($matchId)
    		->setRegion($region)
    		->setCreatedAt($createdAt)
    		->setDuration($data->matchDuration)
    		->setMatchMode($data->matchMode)
    		->setMatchType($data->matchType)
    		->setQueueType($data->queueType)
    		->setVersion($data->matchVersion)
    		->setSeason($data->season)
    		->setPlatformId($data->platformId)
    		->setData(serialize($data));

    	// -- Bans
    	foreach($data->teams as $team)
    	{
    		if(!isset($team->bans)) { break; }
    		
    		foreach($team->bans as $ban)
    		{
    			$champion = $this->em->getRepository($champion_class)->findOneByDistantId($ban->championId);
	    		if(!$champion)
	    		{
	    			$champion = $this->factory->getImporter('champion')->import(['region' => 'na', 'championId' => (int) $ban->championId]);
	    		}
	    		$game->addBans($champion);
    		}
    	}
    	$this->em->persist($game);

    	// -- Summoners
    	$summoner_class = $this->factory->getEntityClass('summoner');
    	$summoners = [];
    	foreach($data->participantIdentities as $k => $pi)
    	{
    		if(true || !isset($pi->player)) 
    		{ 
    			$summoners[$pi->participantId] = null;
    			continue;
    		}
    		$summoner = $this->em->getRepository($summoner_class)->findOneByDistantId($pi->player->summonerId);

    		if(!$summoner)
    		{
	    		$summoner = new $summoner_class();
	    		$summoner
	    			->setDistantId($pi->player->summonerId)
	    			->setName($pi->player->summonerName)
	    		;
	    		$this->em->persist($summoner);
	    	}

	    	$summoners[$pi->participantId] = $summoner;
    	}

    	$participant_class = $this->factory->getEntityClass('participant');
    	foreach($data->participants as $p)
    	{
    		// -- Champion
    		$champion = $this->em->getRepository($champion_class)->findOneByDistantId($p->championId);
    		if(!$champion)
    		{
    			$champion = $this->factory->getImporter('champion')->import(['region' => 'na', 'championId' => (int) $p->championId]);
    		}

    		// -- Participant
    		$participant = new $participant_class();
    		$participant
    			->setGame($game)
    			->setChampion($champion)
    			->setWinner($p->stats->winner)
    			->setKills($p->stats->kills)
    			->setDeaths($p->stats->deaths)
    			->setAssists($p->stats->assists)
    			->setGold($p->stats->goldEarned)
    			->setDamageTaken($p->stats->totalDamageTaken)
    			->setDamageDealt($p->stats->totalDamageDealtToChampions)
    		;

    		if(!is_null($summoners[$p->participantId]))
    		{
    			$participant->setSummoner($summoners[$p->participantId]);
    		}

    		// -- Items
			foreach(range(0,6) as $i)
			{
				$field = "item" . $i;
				if($p->stats->$field == 0) { continue; }

    			$item  = $this->em->getRepository($item_class)->findOneByDistantId($p->stats->$field);
	    		if(!$item)
	    		{
	    			$item = $this->factory->getImporter('item')->import(['region' => 'na', 'itemId' => (int) $p->stats->$field, 'version' => $data->matchVersion]);
	    		}
	    		$participant->addItems($item);
	    	}

    		$this->em->persist($participant);
    	}

    	return $game;
    }
}
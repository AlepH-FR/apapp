<?php

namespace DLCompare\LoLApiBundle\Model;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;

use DLCompare\LoLApiBundle\Entity\Champion;
use DLCompare\LoLApiBundle\Entity\Participant;
use DLCompare\LoLApiBundle\Entity\Item;

/**
 * ParticipantRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ParticipantRepository extends EntityRepository
{    
	/**
	 * Counts number of game participants for a specified version
	 * 
	 * @param string $version
	 * @return integer
	 */
	public function countByVersion($version)
	{
		$qb = $this->createQueryBuilder('p');
		$ex = $qb->expr();

		$result = $qb
			->select('COUNT(p)')
			->leftJoin('p.game', 'g')
			->where($ex->like('g.version', $ex->literal($version . '%')))
			->getQuery()
			->getSingleScalarResult()
		;

		return $result;
	}

	/**
	 * Counts number of game participants of a champion for a specified version
	 * 
	 * @param string $version
	 * @param DLCompare\LoLApiBundle\Entity\Champion $champion
	 * @return integer
	 */
	public function countByVersionByChampion($version, Champion $champion)
	{
		$qb = $this->createQueryBuilder('p');
		$ex = $qb->expr();

		$result = $qb
			->select('COUNT(p)')
			->leftJoin('p.game', 'g')
			->leftJoin('p.champion', 'c')
			->where($ex->like('g.version', $ex->literal($version . '%')))
			->andWhere($ex->eq('c.id', $champion->getId()))
			->getQuery()
			->getSingleScalarResult()
		;

		return $result;
	}

	/**
	 * Counts number of game participants of a champion tag (or role) for a specified version
	 * 
	 * @param string $version
	 * @param string tag
	 * @return integer
	 */
	public function countByVersionByTag($version, $tag)
	{
		$qb = $this->createQueryBuilder('p');
		$ex = $qb->expr();

		$result = $qb
			->select('COUNT(p)')
			->leftJoin('p.game', 'g')
			->leftJoin('p.champion', 'c')
			->where($ex->like('g.version', $ex->literal($version . '%')))
			->andWhere($ex->like('c.tags', $ex->literal($tag.'%')))
			->getQuery()
			->getSingleScalarResult()
		;

		return $result;
	}

	/**
	 * Counts number of game participants using an item for a specified version
	 * 
	 * @param string $version
	 * @param DLCompare\LoLApiBundle\Entity\Item $item
	 * @return integer
	 */
	public function countByVersionByItem($version, Item $item)
	{
		$qb = $this->createQueryBuilder('p');
		$ex = $qb->expr();

		$result = $qb
			->select('COUNT(p)')
			->leftJoin('p.game', 'g')
			->leftJoin('p.items', 'i')
			->where($ex->like('g.version', $ex->literal($version . '%')))
			->andWhere($ex->eq('i.id', $item->getId()))
			->getQuery()
			->getSingleScalarResult()
		;

		return $result;
	}

	/**
	 * Counts number of wins of a champion for a specified version
	 * 
	 * @param string $version
	 * @param DLCompare\LoLApiBundle\Entity\Champion $champion
	 * @return integer
	 */
	public function countByVersionByChampionByWin($version, Champion $champion)
	{
		$qb = $this->createQueryBuilder('p');
		$ex = $qb->expr();

		$result = $qb
			->select('COUNT(p)')
			->leftJoin('p.game', 'g')
			->leftJoin('p.champion', 'c')
			->where($ex->like('g.version', $ex->literal($version . '%')))
			->andWhere($ex->eq('c.id', $champion->getId()))
			->andWhere($ex->eq('p.winner', $ex->literal(1)))
			->getQuery()
			->getSingleScalarResult()
		;

		return $result;
	}

	/**
	 * Counts number of wins of participants using an item for a specified version
	 * 
	 * @param string $version
	 * @param DLCompare\LoLApiBundle\Entity\Item $item
	 * @return integer
	 */
	public function countByVersionByItemByWin($version, Item $item)
	{
		$qb = $this->createQueryBuilder('p');
		$ex = $qb->expr();

		$result = $qb
			->select('COUNT(p)')
			->leftJoin('p.game', 'g')
			->leftJoin('p.items', 'i')
			->where($ex->like('g.version', $ex->literal($version . '%')))
			->andWhere($ex->eq('i.id', $item->getId()))
			->andWhere($ex->eq('p.winner', $ex->literal(1)))
			->getQuery()
			->getSingleScalarResult()
		;

		return $result;		
	}

	/**
	 * Counts number of wins of participants using an item AND a champion for a specified version
	 * 
	 * @param DLCompare\LoLApiBundle\Entity\Champion $champion
	 * @param string $version
	 * @param DLCompare\LoLApiBundle\Entity\Item $item
	 * @return integer
	 */
	public function countWinsByVersionByChampionByItem(Champion $champion, $version, Item $item)
	{
		$qb = $this->createQueryBuilder('p');
		$ex = $qb->expr();

		$result = $qb
			->select('COUNT(p)')
			->leftJoin('p.game', 'g')
			->leftJoin('p.items', 'i')
			->leftJoin('p.champion', 'c')
			->where($ex->like('g.version', $ex->literal($version . '%')))
			->andWhere($ex->eq('c.id', $champion->getId()))
			->andWhere($ex->eq('i.id', $item->getId()))
			->andWhere($ex->eq('p.winner', $ex->literal(1)))
			->getQuery()
			->getSingleScalarResult()
		;

		return $result;			
	}

	/**
	 * Counts number of wins of a champion tag (or role) for a specified version
	 * 
	 * @param string $version
	 * @param string tag
	 * @return integer
	 */
	public function countByVersionByTagByWin($version, $tag)
	{
		$qb = $this->createQueryBuilder('p');
		$ex = $qb->expr();

		$result = $qb
			->select('COUNT(p)')
			->leftJoin('p.game', 'g')
			->leftJoin('p.champion', 'c')
			->where($ex->like('g.version', $ex->literal($version . '%')))
			->andWhere($ex->like('c.tags', $ex->literal($tag.'%')))
			->andWhere($ex->eq('p.winner', $ex->literal(1)))
			->getQuery()
			->getSingleScalarResult()
		;

		return $result;
	}

	/**
	 * Counts number of kills of a champion or a specified version
	 * 
	 * @param string $version
	 * @param DLCompare\LoLApiBundle\Entity\Champion $champion
	 * @return integer
	 */
	public function countKillsByVersionByChampion($version, Champion $champion)
	{
		$qb = $this->createQueryBuilder('p');
		$ex = $qb->expr();

		$result = $qb
			->select('SUM(p.kills)')
			->leftJoin('p.game', 'g')
			->leftJoin('p.champion', 'c')
			->where($ex->like('g.version', $ex->literal($version . '%')))
			->andWhere($ex->eq('c.id', $champion->getId()))
			->getQuery()
			->getSingleScalarResult()
		;

		return $result;
	}

	/**
	 * Counts number of kills for a champion's tag (or role) or a specified version
	 * 
	 * @param string $version
	 * @param string $tag
	 * @return integer
	 */
	public function countKillsByVersionByTag($version, $tag)
	{
		$qb = $this->createQueryBuilder('p');
		$ex = $qb->expr();

		$result = $qb
			->select('SUM(p.kills)')
			->leftJoin('p.game', 'g')
			->leftJoin('p.champion', 'c')
			->where($ex->like('g.version', $ex->literal($version . '%')))
			->andWhere($ex->like('c.tags', $ex->literal($tag.'%')))
			->getQuery()
			->getSingleScalarResult()
		;

		return $result;
	}

	/**
	 * Counts number of deaths of a champion or a specified version
	 * 
	 * @param string $version
	 * @param DLCompare\LoLApiBundle\Entity\Champion $champion
	 * @return integer
	 */
	public function countDeathsByVersionByChampion($version, Champion $champion)
	{
		$qb = $this->createQueryBuilder('p');
		$ex = $qb->expr();

		$result = $qb
			->select('SUM(p.deaths)')
			->leftJoin('p.game', 'g')
			->leftJoin('p.champion', 'c')
			->where($ex->like('g.version', $ex->literal($version . '%')))
			->andWhere($ex->eq('c.id', $champion->getId()))
			->getQuery()
			->getSingleScalarResult()
		;

		return $result;
	}

	/**
	 * Counts number of deaths for a champion's tag (or role) or a specified version
	 * 
	 * @param string $version
	 * @param string $tag
	 * @return integer
	 */
	public function countDeathsByVersionByTag($version, $tag)
	{
		$qb = $this->createQueryBuilder('p');
		$ex = $qb->expr();

		$result = $qb
			->select('SUM(p.deaths)')
			->leftJoin('p.game', 'g')
			->leftJoin('p.champion', 'c')
			->where($ex->like('g.version', $ex->literal($version . '%')))
			->andWhere($ex->like('c.tags', $ex->literal($tag.'%')))
			->getQuery()
			->getSingleScalarResult()
		;

		return $result;
	}

	/**
	 * Counts number of assists of a champion or a specified version
	 * 
	 * @param string $version
	 * @param DLCompare\LoLApiBundle\Entity\Champion $champion
	 * @return integer
	 */
	public function countAssistsByVersionByChampion($version, Champion $champion)
	{
		$qb = $this->createQueryBuilder('p');
		$ex = $qb->expr();

		$result = $qb
			->select('SUM(p.assists)')
			->leftJoin('p.game', 'g')
			->leftJoin('p.champion', 'c')
			->where($ex->like('g.version', $ex->literal($version . '%')))
			->andWhere($ex->eq('c.id', $champion->getId()))
			->getQuery()
			->getSingleScalarResult()
		;

		return $result;
	}

	/**
	 * Counts number of assists for a champion's tag (or role) or a specified version
	 * 
	 * @param string $version
	 * @param string $tag
	 * @return integer
	 */
	public function countAssistsByVersionByTag($version, $tag)
	{
		$qb = $this->createQueryBuilder('p');
		$ex = $qb->expr();

		$result = $qb
			->select('SUM(p.assists)')
			->leftJoin('p.game', 'g')
			->leftJoin('p.champion', 'c')
			->where($ex->like('g.version', $ex->literal($version . '%')))
			->andWhere($ex->like('c.tags', $ex->literal($tag.'%')))
			->getQuery()
			->getSingleScalarResult()
		;

		return $result;
	}

	/**
	 * Get gpm of a champion or a specified version
	 * 
	 * @param string $version
	 * @param DLCompare\LoLApiBundle\Entity\Champion $champion
	 * @return integer
	 */
	public function getGoldPerMinute($version, Champion $champion)
	{
		// gold
		$qb = $this->createQueryBuilder('p');
		$ex = $qb->expr();

		$gold = $qb
			->select('SUM(p.gold)')
			->leftJoin('p.game', 'g')
			->leftJoin('p.champion', 'c')
			->where($ex->like('g.version', $ex->literal($version . '%')))
			->andWhere($ex->eq('c.id', $champion->getId()))
			->getQuery()
			->getSingleScalarResult()
		;

		// minutes
		$qb = $this->createQueryBuilder('p');
		$ex = $qb->expr();

		$duration = $qb
			->select('SUM(g.duration)')
			->leftJoin('p.game', 'g')
			->leftJoin('p.champion', 'c')
			->where($ex->like('g.version', $ex->literal($version . '%')))
			->andWhere($ex->eq('c.id', $champion->getId()))
			->getQuery()
			->getSingleScalarResult()
		;

		return ($duration == 0)
			? 0
			: number_format(60 * $gold / $duration, 2)
		;
	}

	/**
	 * Get most common build of a champion based on game length and version
	 * 
	 * @param DLCompare\LoLApiBundle\Entity\Champion $champion
	 * @param string $version
	 * @param integer $start 
	 * @param integer $end
	 * @return array(DLCompare\LoLApiBundle\Entity\Item)
	 */
	public function getCommonBuild(Champion $champion, $version, $start = 40, $end = 1000)
	{
		$sql = "
			SELECT sub.id AS id, sub.build, COUNT(sub.id) AS cpt FROM
			(
				SELECT p.id , GROUP_CONCAT(i.item_id) AS build FROM participant p 
				LEFT JOIN participant_items i ON i.participant_id = p.id 
				LEFT JOIN game g ON p.game_id = g.id
				LEFT JOIN champion c ON p.champion_id = c.id
				WHERE c.id = " . $champion->getId() . "
					AND g.version LIKE '". $version . "%'
					AND g.duration > " . $start * 60 . "
					AND g.duration < " . $end * 60 . "
				GROUP BY p.id 
				ORDER BY build DESC
			) AS sub
			GROUP BY sub.build
			ORDER BY cpt DESC
			LIMIT 1
		";	

		$rsm = new ResultSetMapping();
        $rsm->addScalarResult('id', 'id');
        $query  = $this->getEntityManager()->createNativeQuery($sql, $rsm);
        $result = $query->getResult();
        if(count($result) == 0) { return new Participant(); }

        return $this->findOneById($result[0]['id']);
	}
}
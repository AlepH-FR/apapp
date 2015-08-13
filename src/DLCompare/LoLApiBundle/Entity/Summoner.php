<?php

namespace DLCompare\LoLApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection as Collection;

/**
 * Summoner
 *
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="idx_distant_id", columns={"distant_id"})})
 * @ORM\Entity(repositoryClass="DLCompare\LoLApiBundle\Model\SummonerRepository")
 */
class Summoner
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="distant_id", type="integer")
     */
    private $distantId;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="highest_league", type="string", length=255, nullable=true)
     */
    private $highestLeague;

    /**
     * @var Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Participant", mappedBy="summoner", cascade={"remove"}, fetch="EXTRA_LAZY")
     */
    private $participants;

    /**
     * Initializes collections
     */
    public function __construct()
    {
        $this->participants = new Collection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set distantId
     *
     * @param integer $distantId
     * @return Summoner
     */
    public function setDistantId($distantId)
    {
        $this->distantId = $distantId;

        return $this;
    }

    /**
     * Get distantId
     *
     * @return integer 
     */
    public function getDistantId()
    {
        return $this->distantId;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Summoner
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set highestÃLeague
     *
     * @param string $highestLeague
     * @return Summoner
     */
    public function setHighestLeague($highestLeague)
    {
        $this->highestLeague = $highestLeague;

        return $this;
    }

    /**
     * Get highestÃLeague
     *
     * @return string 
     */
    public function getHighestLeague()
    {
        return $this->highestLeague;
    }

    /**
     * Get participation in game of this summoner
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getParticipants()
    {
        return $this->participants;
    }
}

<?php

namespace DLCompare\LoLApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection as Collection;

/**
 * Game
 *
 * @ORM\Table(
 *      indexes={
 *          @ORM\Index(name="idx_version", columns={"version"}),
 *          @ORM\Index(name="idx_region", columns={"region"}),
 *          @ORM\Index(name="idx_queue_type", columns={"queue_type"}),
 *          @ORM\Index(name="idx_distant_id", columns={"distant_id"})
 *      }
 * )
 * @ORM\Entity(repositoryClass="DLCompare\LoLApiBundle\Model\GameRepository")
 */
class Game
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
     * @ORM\Column(name="region", type="string", length=255)
     */
    private $region;

    /**
     * @var string
     *
     * @ORM\Column(name="platform_id", type="string", length=255, nullable=true)
     */
    private $platformId;

    /**
     * @var string
     *
     * @ORM\Column(name="match_type", type="string", length=255, nullable=true)
     */
    private $matchType;

    /**
     * @var string
     *
     * @ORM\Column(name="queue_type", type="string", length=255)
     */
    private $queueType;

    /**
     * @var string
     *
     * @ORM\Column(name="season", type="string", length=255, nullable=true)
     */
    private $season;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var integer
     *
     * @ORM\Column(name="duration", type="integer")
     */
    private $duration;

    /**
     * @var string
     *
     * @ORM\Column(name="version", type="string", length=255)
     */
    private $version;

    /**
     * @var string
     *
     * @ORM\Column(name="match_mode", type="string", length=255, nullable=true)
     */
    private $matchMode;

    /**
     * @var string
     *
     * @ORM\Column(name="data", type="text", nullable=true)
     */
    private $data;

    /**
     * @var Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="Participant", mappedBy="game", cascade={"remove"}, fetch="EXTRA_LAZY", orphanRemoval=true)
     */
    private $participants;

    /**
     * @var Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Champion", inversedBy="bans", cascade={"remove"}, fetch="EXTRA_LAZY", orphanRemoval=true)
     * @ORM\JoinTable(name="game_bans")
     */
    private $bans;

    /**
     * Initializes collections
     */
    public function __construct()
    {
        $this->participants = new Collection();
        $this->bans         = new Collection();
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
     * @return Game
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
     * Set region
     *
     * @param string $region
     * @return Game
     */
    public function setRegion($region)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return string 
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set platformId
     *
     * @param string $platformId
     * @return Game
     */
    public function setPlatformId($platformId)
    {
        $this->platformId = $platformId;

        return $this;
    }

    /**
     * Get platformId
     *
     * @return string 
     */
    public function getPlatformId()
    {
        return $this->platformId;
    }

    /**
     * Set matchType
     *
     * @param string $matchType
     * @return Game
     */
    public function setMatchType($matchType)
    {
        $this->matchType = $matchType;

        return $this;
    }

    /**
     * Get matchType
     *
     * @return string 
     */
    public function getMatchType()
    {
        return $this->matchType;
    }

    /**
     * Set queueType
     *
     * @param string $queueType
     * @return Game
     */
    public function setQueueType($queueType)
    {
        $this->queueType = $queueType;

        return $this;
    }

    /**
     * Get queueType
     *
     * @return string 
     */
    public function getQueueType()
    {
        return $this->queueType;
    }

    /**
     * Set season
     *
     * @param string $season
     * @return Game
     */
    public function setSeason($season)
    {
        $this->season = $season;

        return $this;
    }

    /**
     * Get season
     *
     * @return string 
     */
    public function getSeason()
    {
        return $this->season;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Game
     */
    public function setCreatedAt(\DateTime $createdAt = null)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set duration
     *
     * @param integer $duration
     * @return Game
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get duration
     *
     * @return integer 
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set version
     *
     * @param string $version
     * @return Game
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Get version
     *
     * @return string 
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Set matchMode
     *
     * @param string $matchMode
     * @return Game
     */
    public function setMatchMode($matchMode)
    {
        $this->matchMode = $matchMode;

        return $this;
    }

    /**
     * Get matchMode
     *
     * @return string 
     */
    public function getMatchMode()
    {
        return $this->matchMode;
    }

    /**
     * Set data
     *
     * @param string $data
     * @return Game
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data
     *
     * @return string 
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Get participants of this game
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getParticipants()
    {
        return $this->participants;
    }

    /**
     * Get bans of this champion in games
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getBans()
    {
        return $this->bans;
    }

    /**
     * Add ban of a champion for this game
     *
     * @param Doctrine\Common\Collections\Collection $bans
     * @return Game
     */
    public function addBans(Champion $ban)
    {
        if(!$this->bans->contains($ban))
        {
            $this->bans->add($ban);
        }
        return $this;
    }

    /**
     * Set bans for this game
     *
     * @param Doctrine\Common\Collections\Collection $bans
     * @return Game
     */
    public function setBans(Collection $bans)
    {
        foreach($bans as $ban)
        {
            $this->addBans($ban);
        }

        return $this;
    }
}

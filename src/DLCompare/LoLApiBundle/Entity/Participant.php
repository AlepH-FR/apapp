<?php

namespace DLCompare\LoLApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection as Collection;

/**
 * Participant
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="DLCompare\LoLApiBundle\Model\ParticipantRepository")
 */
class Participant
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
     * @var boolean
     *
     * @ORM\Column(name="winner", type="boolean")
     */
    private $winner;

    /**
     * @var integer
     *
     * @ORM\Column(name="kills", type="integer")
     */
    private $kills;

    /**
     * @var integer
     *
     * @ORM\Column(name="death", type="integer")
     */
    private $deaths;

    /**
     * @var integer
     *
     * @ORM\Column(name="assist", type="integer")
     */
    private $assists;

    /**
     * @var integer
     *
     * @ORM\Column(name="gold", type="integer")
     */
    private $gold;

    /**
     * @var integer
     *
     * @ORM\Column(name="damage_taken", type="integer")
     */
    private $damageTaken;

    /**
     * @var integer
     *
     * @ORM\Column(name="damage_dealt", type="integer")
     */
    private $damageDealt;
    
    /**
     * @var Game
     * 
     * @ORM\ManyToOne(targetEntity="Game", inversedBy="participants", cascade={"remove"})
     * @ORM\JoinColumn(name="game_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $game;

    /**
     * @var Champion
     * 
     * @ORM\ManyToOne(targetEntity="Champion", inversedBy="participants", cascade={"remove"})
     */
    private $champion;

    /**
     * @var Summoner
     * 
     * @ORM\ManyToOne(targetEntity="Summoner", inversedBy="participants", cascade={"remove"})
     */
    private $summoner;

    /**
     * @var Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Item", inversedBy="participants", cascade={"remove"}, fetch="EXTRA_LAZY")
     * @ORM\JoinTable(name="participant_items")
     */
    private $items;

    public function __construct()
    {
        $this->items = new Collection();
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
     * Set winner
     *
     * @param boolean $winner
     * @return Participant
     */
    public function setWinner($winner)
    {
        $this->winner = $winner;

        return $this;
    }

    /**
     * Get winner
     *
     * @return boolean 
     */
    public function getWinner()
    {
        return $this->winner;
    }

    /**
     * Set kills
     *
     * @param integer $kills
     * @return Participant
     */
    public function setKills($kills)
    {
        $this->kills = $kills;

        return $this;
    }

    /**
     * Get kills
     *
     * @return integer 
     */
    public function getKills()
    {
        return $this->kills;
    }

    /**
     * Set deaths
     *
     * @param integer $deaths
     * @return Participant
     */
    public function setDeaths($deaths)
    {
        $this->deaths = $deaths;

        return $this;
    }

    /**
     * Get deaths
     *
     * @return integer 
     */
    public function getDeaths()
    {
        return $this->deaths;
    }

    /**
     * Set assists
     *
     * @param integer $assists
     * @return Participant
     */
    public function setAssists($assists)
    {
        $this->assists = $assists;

        return $this;
    }

    /**
     * Get assists
     *
     * @return integer 
     */
    public function getAssists()
    {
        return $this->assists;
    }

    /**
     * Set gold
     *
     * @param integer $gold
     * @return Participant
     */
    public function setGold($gold)
    {
        $this->gold = $gold;

        return $this;
    }

    /**
     * Get gold
     *
     * @return integer 
     */
    public function getGold()
    {
        return $this->gold;
    }

    /**
     * Set damageTaken
     *
     * @param integer $damageTaken
     * @return Participant
     */
    public function setDamageTaken($damageTaken)
    {
        $this->damageTaken = $damageTaken;

        return $this;
    }

    /**
     * Get damageTaken
     *
     * @return integer 
     */
    public function getDamageTaken()
    {
        return $this->damageTaken;
    }

    /**
     * Set damageDealt
     *
     * @param integer $damageDealt
     * @return Participant
     */
    public function setDamageDealt($damageDealt)
    {
        $this->damageDealt = $damageDealt;

        return $this;
    }

    /**
     * Get damageDealt
     *
     * @return integer 
     */
    public function getDamageDealt()
    {
        return $this->damageDealt;
    }

    /**
     * Get game
     *
     * @return Game 
     */
    public function getGame()
    {
        return $this->game;
    }

    /**
     * Set game
     *
     * @param Game $game
     * @return Participant 
     */
    public function setGame(Game $game)
    {
        $this->game = $game;

        return $this;
    }

    /**
     * Get champion
     *
     * @return Champion 
     */
    public function getChampion()
    {
        return $this->champion;
    }

    /**
     * Set champion
     *
     * @param Champion $champion
     * @return Participant 
     */
    public function setChampion(Champion $champion)
    {
        $this->champion = $champion;
        
        return $this;
    }

    /**
     * Get summoner
     *
     * @return Summoner 
     */
    public function getSummoner()
    {
        return $this->summoner;
    }

    /**
     * Set summoner
     *
     * @param Summoner $summoner
     * @return Participant 
     */
    public function setSummoner(Summoner $summoner)
    {
        $this->summoner = $summoner;
        
        return $this;
    }

    /**
     * Get items of this participant
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Add item for this participant
     *
     * @param Doctrine\Common\Collections\Collection $items
     * @return Participant
     */
    public function addItems(Item $item)
    {
        if(!$this->items->contains($item))
        {
            $this->items->add($item);
        }
        return $this;
    }

    /**
     * Set items for this participant
     *
     * @param Doctrine\Common\Collections\Collection $items
     * @return Participant
     */
    public function setItems(Collection $items)
    {
        foreach($items as $item)
        {
            $this->addItems($item);
        }

        return $this;
    }
}

<?php

namespace DLCompare\LoLApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection as Collection;

/**
 * Item
 *
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="idx_distant_id", columns={"distant_id"})})
 * @ORM\Entity(repositoryClass="DLCompare\LoLApiBundle\Model\ItemRepository")
 */ 
class Item
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
     * @ORM\Column(name="description", type="string", length=700)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="note", type="text", nullable=true)
     */
    private $note;

    /**
     * @var boolean
     *
     * @ORM\Column(name="flag", type="boolean", nullable=true)
     */
    private $flag;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255)
     */
    private $image;

    /**
     * @var integer
     *
     * @ORM\Column(name="cost", type="integer")
     */
    private $cost;

    /**
     * @var string
     *
     * @ORM\Column(name="tags", type="string", length=255)
     */
    private $tags;

    /**
     * @var string
     *
     * @ORM\Column(name="stats", type="text")
     */
    private $stats;

    /**
     * @var string
     *
     * @ORM\Column(name="effects", type="text")
     */
    private $effects;

    /**
     * @var Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Participant", mappedBy="items", cascade={"remove"}, fetch="EXTRA_LAZY")
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
     * @return Item
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
     * @return Item
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
     * Set description
     *
     * @param string $description
     * @return Item
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set note
     *
     * @param string $note
     * @return Item
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return string 
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set flag
     *
     * @param boolean $flag
     * @return Item
     */
    public function setFlag($flag)
    {
        $this->flag = $flag;

        return $this;
    }

    /**
     * Get flag
     *
     * @return string 
     */
    public function getFlag()
    {
        return $this->flag;
    }

    /**
     * Set image
     *
     * @param string $image
     * @return Item
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set cost
     *
     * @param integer $cost
     * @return Item
     */
    public function setCost($cost)
    {
        $this->cost = $cost;

        return $this;
    }

    /**
     * Get cost
     *
     * @return integer 
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * Set tags
     *
     * @param string $tags
     * @return Item
     */
    public function setTags($tags)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * Get tags
     *
     * @return string 
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Set stats
     *
     * @param string $stats
     * @return Item
     */
    public function setStats($stats)
    {
        $this->stats = $stats;

        return $this;
    }

    /**
     * Get stats
     *
     * @return string 
     */
    public function getStats()
    {
        return $this->stats;
    }

    /**
     * Set effects
     *
     * @param string $effects
     * @return Item
     */
    public function setEffects($effects)
    {
        $this->effects = $effects;

        return $this;
    }

    /**
     * Get effects
     *
     * @return string 
     */
    public function getEffects()
    {
        return $this->effects;
    }

    /**
     * Get participations of games for this item
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getParticipants()
    {
        return $this->participants;
    }
}

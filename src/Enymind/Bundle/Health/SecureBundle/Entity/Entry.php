<?php

namespace Enymind\Bundle\Health\SecureBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Enymind\Bundle\Health\SecureBundle\Entity\Entry
 *
 * @ORM\Table(name="entries")
 * @ORM\Entity
 */
class Entry
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer $type_id
     *
     * @ORM\Column(name="type_id", type="integer")
     * @ORM\ManyToOne(targetEntity="EntryType", inversedBy="entry_types")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     */
    private $type_id;

    /**
     * @var integer $value
     *
     * @ORM\Column(name="value", type="integer")
     */
    private $value;

    /**
     * @var \DateTime $added
     *
     * @ORM\Column(name="added", type="datetime")
     */
    private $added;


    public function __construct()
    {
        $this->added = new \DateTime("now");
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
     * Set type_id
     *
     * @param integer $typeId
     * @return Entry
     */
    public function setTypeId($typeId)
    {
        $this->type_id = $typeId;
    
        return $this;
    }

    /**
     * Get type_id
     *
     * @return integer 
     */
    public function getTypeId()
    {
        return $this->type_id;
    }

    /**
     * Set value
     *
     * @param integer $value
     * @return Entry
     */
    public function setValue($value)
    {
        $this->value = $value;
    
        return $this;
    }

    /**
     * Get value
     *
     * @return integer 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set added
     *
     * @param \DateTime $added
     * @return Entry
     */
    public function setAdded($added)
    {
        $this->added = $added;
    
        return $this;
    }

    /**
     * Get added
     *
     * @return \DateTime 
     */
    public function getAdded()
    {
        return $this->added;
    }
}

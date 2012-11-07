<?php

namespace Enymind\Bundle\Health\SecureBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Enymind\Bundle\Health\SecureBundle\Entity\EntryType
 *
 * @ORM\Table(name="entry_types")
 * @ORM\Entity
 */
class EntryType
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
     * @var integer $owner_id
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="users")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id")
     */
    private $owner_id;
    
    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=32)
     */
    private $name;

    /**
     * @var string $description
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var integer $min
     *
     * @ORM\Column(name="min", type="integer")
     */
    private $min;

    /**
     * @var integer $max
     *
     * @ORM\Column(name="max", type="integer")
     */
    private $max;

    /**
     * @var string $quantity
     *
     * @ORM\Column(name="quantity", type="string", length=16)
     */
    private $quantity;


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
     * Set owner_id
     *
     * @param integer $ownerId
     * @return EntryType
     */
    public function setOwnerId($ownerId)
    {
        $this->owner_id = $ownerId;
    
        return $this;
    }

    /**
     * Get owner_id
     *
     * @return integer 
     */
    public function getOwnerId()
    {
        return $this->owner_id;
    }
    
    /**
     * Set name
     *
     * @param string $name
     * @return EntryType
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
     * @return EntryType
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
     * Set min
     *
     * @param integer $min
     * @return EntryType
     */
    public function setMin($min)
    {
        $this->min = $min;
    
        return $this;
    }

    /**
     * Get min
     *
     * @return integer 
     */
    public function getMin()
    {
        return $this->min;
    }

    /**
     * Set max
     *
     * @param integer $max
     * @return EntryType
     */
    public function setMax($max)
    {
        $this->max = $max;
    
        return $this;
    }

    /**
     * Get max
     *
     * @return integer 
     */
    public function getMax()
    {
        return $this->max;
    }

    /**
     * Set quantity
     *
     * @param string $quantity
     * @return EntryType
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    
        return $this;
    }

    /**
     * Get quantity
     *
     * @return string 
     */
    public function getQuantity()
    {
        return $this->quantity;
    }
    
    /**
     * Get defalut_value
     *
     * @return integer 
     */
    public function getDefaultValue()
    {
        return ceil( ceil( $this->getMax() / 2 ) + intval( $this->getMin() ) );
    }
}

<?php

namespace Enymind\Bundle\Health\SecureBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Enymind\Bundle\Health\SecureBundle\Entity\EntryGroup
 *
 * @ORM\Table(name="entry_groups")
 * @ORM\Entity
 */
class EntryGroup
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
     * @var boolean $visible
     *
     * @ORM\Column(name="visible", type="boolean")
     */
    private $visible;
    
    /**
     * @var array $entry_types
     *
     * @ORM\Column(name="entry_types", type="array")
     */
    private $entry_types;
    
    private $entry_types_ac;


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
     * @return EntryGroup
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
     * @return EntryGroup
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
     * @return EntryGroup
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
     * Set visible
     *
     * @param boolean $visible
     * @return EntryGroup
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;
    
        return $this;
    }

    /**
     * Get visible
     *
     * @return boolean 
     */
    public function getVisible()
    {
        return $this->visible;
    }
    
    /**
     * Set entry_types
     *
     * @param array $entryTypes
     * @return EntryGroup
     */
    public function setEntryTypes($entryTypes)
    {
        if ( is_a($entryTypes, "Doctrine\Common\Collections\ArrayCollection") ) {
          $entryTypesArray = array();
          foreach( $entryTypes as $entryType ) {
            $entryTypesArray[] = $entryType->getId();
          }
          $this->entry_types = $entryTypesArray;
        }
        else
          $this->entry_types = $entryTypes;
    
        return $this;
    }

    /**
     * Set entry_types_ac
     *
     * @param Doctrine\Common\Collections\ArrayCollection $entryTypesAC
     * @return EntryGroup
     */
    public function setEntryTypesArrayCollection($entryTypesAC)
    {
        $this->entry_types_ac = $entryTypesAC;
    
        return $this;
    }
    
    /**
     * Get entry_types
     *
     * @return Doctrine\Common\Collections\ArrayCollection 
     */
    public function getEntryTypes()
    {
        return $this->entry_types_ac;
    }
    
    /**
     * Get entry_types_array
     *
     * @return array 
     */
    public function getEntryTypesArray()
    {
        return $this->entry_types;
    }
}

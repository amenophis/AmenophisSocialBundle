<?php

namespace Amenophis\Bundle\SocialBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/** @ORM\MappedSuperclass */
class Social
{
    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $class_name;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $type;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    protected $item_id;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    protected $user_id;

    /***** Auto Generated *****/

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
     * Set class_name
     *
     * @param string $className
     * @return Social
     */
    public function setClassName($className)
    {
        $this->class_name = $className;
    
        return $this;
    }

    /**
     * Get class_name
     *
     * @return string 
     */
    public function getClassName()
    {
        return $this->class_name;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Social
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set item_id
     *
     * @param integer $itemId
     * @return Social
     */
    public function setItemId($itemId)
    {
        $this->item_id = $itemId;
    
        return $this;
    }

    /**
     * Get item_id
     *
     * @return integer 
     */
    public function getItemId()
    {
        return $this->item_id;
    }

    /**
     * Set user_id
     *
     * @param integer $userId
     * @return Social
     */
    public function setUserId($userId)
    {
        $this->user_id = $userId;
    
        return $this;
    }

    /**
     * Get user_id
     *
     * @return integer 
     */
    public function getUserId()
    {
        return $this->user_id;
    }
}
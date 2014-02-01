<?php

namespace Wedding\RespondBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Wedding\RespondBundle\Entity\RSVPType
 *
 * @ORM\Table(name="rsvp_type")
 * @ORM\Entity
 */
class RSVPType
{
    
    /**
     * @ORM\Id
     * @ORM\Column(type="string", unique=true, length=255)
     */
    private $type;
    
    
    /**
     * Set type
     *
     * @param string $type
     * @return Type
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

}
<?php

namespace Wedding\RespondBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Tweet
 *
 * @ORM\Table(name="guest")
 * @ORM\Entity
 */
class Guest
{
    /**
     * @var integer
     *
     * @ORM\Column(name="guest_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Wedding\RespondBundle\Entity\RSVP")
     * @ORM\JoinColumn(name="rsvp_id", referencedColumnName="rsvp_id")
     */
    private $rsvp;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=255)
     */
    private $first_name;
    
    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=255)
     */
    private $last_name; 

    /**
     * Get id
     *
     * @return integer 
     */
    public function getID()
    {
        return $this->id;
    }
    
    /**
     * Set rsvp
     *
     * @param \Wedding\RespondBundle\Entity\RSVP $rsvp
     * @return Guest
     */
    public function setRSVP(\Wedding\RespondBundle\Entity\RSVP $rsvp)
    {
        $this->rsvp = $rsvp;
    
        return $this;
    }

    /**
     * Get rsvp
     *
     * @return \Wedding\RespondBundle\Entity\RSVP
     */
    public function getRSVP()
    {
        return $this->rsvp;
    }
    
    /**
     * Set first_name
     *
     * @param string $first_name
     * @return RSVP
     */
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
    
        return $this;
    }

    /**
     * Get first_name
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->first_name;
    }
    
    /**
     * Set last_name
     *
     * @param string $last_name
     * @return RSVP
     */
    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
    
        return $this;
    }

    /**
     * Get last_name
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->last_name;
    }
    
}

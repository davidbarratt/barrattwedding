<?php

namespace Wedding\RespondBundle\Entity;

use Wedding\RespondBundle\Entity\RSVPType;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Tweet
 *
 * @ORM\Table(name="rsvp")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class RSVP
{
    /**
     * @var integer
     *
     * @ORM\Column(name="rsvp_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="RSVPType")
     * @ORM\JoinColumn(name="type", referencedColumnName="type")
     */
    private $type;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="attending", type="boolean")
     */
    private $attending;
    
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
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;
    
    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=20)
     */
    private $phone;
    
    /**
     * @ORM\Column(type="datetime")
     */
    private $created;
    
    /**
     * @var string
     *
     * @ORM\Column(name="note", type="text", nullable=true)
     */
    private $note;
    
    /**
     * @ORM\OneToMany(targetEntity="Guest", mappedBy="rsvp", cascade={"all"})
     */    
    private $guest;
    
    /**
     * @ORM\ManyToMany(targetEntity="Song", inversedBy="rsvp")
     * @ORM\JoinTable(name="rsvp_song",
     *      joinColumns={@ORM\JoinColumn(name="rsvp_id", referencedColumnName="rsvp_id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="song_id", referencedColumnName="song_id")}
     * )
     **/
    private $song;
    
    /**
     * Construct
     */
    public function __construct()
    {
        $this->guest = new ArrayCollection();
        $this->song = new ArrayCollection();
    }
    
    /**
     * @ORM\PrePersist
     */
    public function setCreatedValue()
    {
        $this->created = new \DateTime();
    }

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
     * Set type
     *
     * @param Wedding\RespondBundle\Entity\RSVPType $type
     * @return RSVP
     */
    public function setType(RSVPType $type = null)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return Wedding\RespondBundle\Entity\RSVPType 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set attending
     *
     * @param boolean $attending
     * @return RSVP
     */
    public function setAttending($attending)
    {
        $this->attending = $attending;
    
        return $this;
    }

    /**
     * Get attending
     *
     * @return boolean 
     */
    public function getAttending()
    {
        return $this->attending;
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
    
    /**
     * Set email
     *
     * @param string $email
     * @return RSVP
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }
    
    /**
     * Set phone
     *
     * @param string $phone
     * @return RSVP
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    
        return $this;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }
    
    /**
     * Set note
     *
     * @param string $note
     * @return RSVP
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
     * Add guest
     *
     * @param \Wedding\RespondBundle\Entity\Guest $guest
     * @return Guest
     */
    public function addGuest(\Wedding\RespondBundle\Entity\Guest $guest)
    {
        $this->guest[] = $guest;
    
        return $this;
    }

    /**
     * Remove guest
     *
     * @param \Wedding\RespondBundle\Entity\Guest $guest
     */
    public function removeGuest(\Wedding\RespondBundle\Entity\Guest $guest)
    {
        $this->guest->removeElement($guest);
    }

    /**
     * Get guest
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGuest()
    {
        return $this->guest;
    }
    
    /**
     * Add song
     *
     * @param \Wedding\RespondBundle\Entity\Song $song
     * @return RSVP
     */
    public function addSong(\Wedding\RespondBundle\Entity\Song $song)
    {
        $this->song[] = $song;
    
        return $this;
    }

    /**
     * Remove song
     *
     * @param \Wedding\RespondBundle\Entity\Song $song
     */
    public function removeSong(\Wedding\RespondBundle\Entity\Song $song)
    {
        $this->song->removeElement($song);
    }

    /**
     * Get song
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSong()
    {
        return $this->song;
    }
    
    /**
     * Set created
     *
     * @param \DateTime $verified
     * @return Email
     */
    public function setCreated($created)
    {
        $this->created = $created;
    
        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }
    
}

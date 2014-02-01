<?php

namespace Wedding\RespondBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

class Respond
{

    /**
     * @Assert\NotNull()
     */
    protected $attending;
    
    /**
     * @Assert\NotBlank()
     * @Assert\Length(
     *      max = "255"
     * )
     */
    protected $first_name;
    
    /**
     * @Assert\NotBlank()
     * @Assert\Length(
     *      max = "255"
     * )
     */
    protected $last_name;
    
    /**
     * @Assert\Email()
     * @Assert\Length(
     *      max = "255"
     * )
     */
    protected $email;
    
    /**
     * @Assert\NotBlank()
     * @Assert\Length(
     *      max = "255"
     * )
     */
    protected $phone;
    
    /**
     * Song List
     */
    protected $guest;
    
    /**
     * Song List
     */
    protected $song_list;
    
    /**
     * Note
     */
    protected $note;
    
    public function __construct()
    {
        $this->attendee = new ArrayCollection();
    }
    
    
    public function setAttending($attending)
    {
        $this->attending = $attending;
    }

    public function getAttending()
    {
        return $this->attending;
    }

    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
    }

    public function getFirstName()
    {
        return $this->first_name;
    }
    
    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
    }

    public function getLastName()
    {
        return $this->last_name;
    }
    
    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }
    
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    public function getPhone()
    {
        return $this->phone;
    }
    
    public function addGuest(\Wedding\RespondBundle\Form\Model\Guest $guest)
    {
        $this->guest[] = $guest;
    
        return $this;
    }

    public function removeGuest(\Wedding\RespondBundle\Form\Model\Guest $guest)
    {
        $this->attendee->removeElement($guest);
    }

    public function getGuest()
    {
        return $this->guest;
    }
    
    public function setSongList($song_list)
    {
        $this->song_list = $song_list;
    }

    public function getSongList()
    {
        return $this->song_list;
    }
    
    public function setNote($note)
    {
        $this->note = $note;
    }

    public function getNote()
    {
        return $this->note;
    }
    
}

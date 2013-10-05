<?php

namespace Wedding\RespondBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;


class Attendee
{

    /**
     * @Assert\Length(
     *      max = "255"
     * )
     */
    protected $first_name;
    
    /**
     * @Assert\Length(
     *      max = "255"
     * )
     */
    protected $last_name;
    
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
    
}

<?php

namespace Wedding\SocialBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Social
 *
 * @ORM\Table(name="social")
 */
class Social
{
    /**
     * @var integer
     *
     * @ORM\Column(name="social_id", type="int")
     * @ORM\Id
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;
    
    /*
     * @ORM\OneToOne(targetEntity="SocialTwitter", mappedBy="social_id", cascade={"all"})
     **/
    private $twitter;

    
    /**
     * Set id
     *
     * @param integer $id
     * @return Social
     */
    public function setID($id)
    {
        $this->id = $id;
    
        return $this;
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
     * Set created
     *
     * @param \DateTime $created
     * @return Social
     */
    public function setCreated($created)
    {
        $this->created = new \DateTime($created);
    
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
    
    /**
     * Set twitter
     *
     * @param \Wedding\SocailBundle\Entity\SocialTwitter $twitter
     * @return Social
     */
    public function setTwitter(\Wedding\SocailBundle\Entity\SocialTwitter $twitter)
    {
        $this->twitter = $twitter;
    
        return $this;
    }

    /**
     * Get twitter
     *
     * @return \Wedding\SocailBundle\Entity\SocialTwitter
     */
    public function getTwitter()
    {
        return $this->twitter;
    }
    
}

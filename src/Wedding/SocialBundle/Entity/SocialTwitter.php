<?php

namespace Wedding\SocialBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SocialTwitter
 *
 * @ORM\Table(name="social_twitter")
 */
class SocialTwitter
{
    /**
     * @var integer
     *
     * @ORM\Column(name="social_twitter_id", type="bigint")
     * @ORM\Id
     */
    private $id;
    
    /**
     * @ORM\OneToOne(targetEntity="Social", inversedBy="twitter", cascade={"persist"})
     * @ORM\JoinColumn(name="social_id", referencedColumnName="social_id")
     */
    private $social;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="text")
     */
    private $text;

    
    /**
     * Set id
     *
     * @param integer $id
     * @return SocialTwitter
     */
    public function setID($id)
    {
        $this->id = $id;
    
        return $this;
    }
    
    /**
     * Set social
     *
     * @param \Wedding\SocailBundle\Entity\Social $social
     * @return SocialTwitter
     */
    public function setSocial(\Wedding\SocailBundle\Entity\Social $social)
    {
        $this->social = $social;
    
        return $this;
    }

    /**
     * Get social
     *
     * @return \Wedding\SocailBundle\Entity\Social 
     */
    public function getSocial()
    {
        return $this->social;
    }


    /**
     * Set text
     *
     * @param string $text
     * @return SocialTwitter
     */
    public function setText($text)
    {
        $this->text = $text;
    
        return $this;
    }

    /**
     * Get text
     *
     * @return string 
     */
    public function getText()
    {
        return $this->text;
    }

    
}

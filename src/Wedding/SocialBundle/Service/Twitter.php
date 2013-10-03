<?php

namespace Wedding\SocialBundle\Service;

use Guzzle\Http\Client;
use Guzzle\Plugin\Oauth\OauthPlugin;
use Guzzle\Http\Exception\BadResponseException;
use Doctrine\ORM\EntityManager;

use Wedding\SocialBundle\Entity\Social;
use Wedding\SocialBundle\Entity\SocialTwitter;

class Twitter {
    
    protected $em;
    
    protected $client;
         
    public function __construct(EntityManager $em, $consumer_key, $consumer_secret, $access_key, $access_secret)
    {
        
        $this->em = $em;
        
        $this->client = new Client('https://api.twitter.com/1.1'); 
        $oauth = new OauthPlugin(array(
          'consumer_key' => $consumer_key,
          'consumer_secret' => $consumer_secret,
          'token' => $access_key,
          'token_secret' => $access_secret,
        ));
        $this->client->addSubscriber($oauth);
        
    }
    
    public function findSaveTweets($query = '')
    {
    
      $repository = $this->em->getRepository('Wedding\TwitterBundle\Entity\Tweet');
      $latest = $repository->findMostRecent();
      $latest_id = ($latest) ? $latest->getID() : 0;
      $statuses = $this->findTweets($query, $latest_id);
      $this->saveTweets($statuses);
      
      $tweets = array();
      
      if ($recent = $repository->findRecent()) {
        
        foreach ($recent as $tweet) {
          $tweets[] = '<p class="tweet"><span class="text">'.$tweet->getText().'</span> <span class="from">&mdash;<a href="http://twitter.com/'.$tweet->getUser()->getUsername().'">@'.$tweet->getUser()->getUsername().'</a></span></p>';
        }
        
      }
      
      return $tweets;
  
    }
    
    public function findTweets($query = '', $since_id = 0)
    {
    
      $statuses = array();
      
      try {
          $response = $this->client->get('search/tweets.json?include_entities=true&count=100&since_id='.$since_id.'&q='.urlencode($query))->send();
      } catch (BadResponseException $e) {
          return $statuses;
      }
      
      $data = $response->json();
            
      if (empty($data['statuses'])) {
        return $statuses;
      }
      
      $statuses = $data['statuses'];
      
      return $statuses;
      
    }
    
    public function saveTweets($statuses = array())
    {
      
      $repository = $this->em->getRepository('Wedding\TwitterBundle\Entity\Social');
      
      foreach ($statuses as $status) {
      
        if (substr($status['text'], 0, 2) == 'RT') {
          continue;
        }
        
        $tweet = new SocialTwitter();
        $tweet->setID($status['id']);
        $tweet->setText($this->embedTweet($status['id']));
                
        $social = new Social();
        $social->setCreated($status['created_at']);
        
        $tweet->setSocial($social);
        
        $this->em->persist($tweet);
        
        $this->em->flush();
        
      }
      
    }
    
    public function embedTweet($id)
    {
      
      $embed = '';
            
      $twitter = new Client('https://api.twitter.com/1'); 
      
      try {
          $response = $twitter->get('statuses/oembed.json?omit_script=true&related=andriamckinney,davidwbarratt&id='.$id)->send();
      } catch (BadResponseException $e) {
          return $embed;
      }
      
      $data = $response->json();
      
      $embed = !empty($data['html']) ? $data['html'] : '';
      
      return $emebed;
      
    }
    
}

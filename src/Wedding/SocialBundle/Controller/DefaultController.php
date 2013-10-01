<?php

namespace Wedding\SocialBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('WeddingSocialBundle:Default:index.html.twig', array('name' => $name));
    }
}

<?php

namespace Wedding\RespondBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use Wedding\RespondBundle\Entity\RSVP;
use Wedding\RespondBundle\Entity\Guest;
use Wedding\RespondBundle\Entity\Song;
use Wedding\RespondBundle\Form\Type\RespondType;
use Wedding\RespondBundle\Form\Model\Respond;

class DefaultController extends Controller
{
    
    public function indexAction(Request $request)
    {
      $respond = new Respond();
      
      // Build the Registration Form
      $form = $this->createForm(new RespondType(), $respond);
      
      // If this Form has been completed
      if ($request->isMethod('POST')) {
      
        // Bind the Form to the request
        $form->bind($request);
        
        // Check to make sure the form is valid before procceding
        if ($form->isValid()) {
          
          $respond = $form->getData();
          
          $song_repository = $this->getDoctrine()->getRepository('Wedding\RespondBundle\Entity\Song');
          
          $type_repository = $this->getDoctrine()->getRepository('Wedding\RespondBundle\Entity\RSVPType');
          
          $type = $type_repository->findOneByType('wedding');
          
          $song_list = $respond->getSongList();
          $song_ids = explode(',', $song_list);
          
          $song_finder = $this->get('wedding_respond.songfinder');
          $song_finder->getSaveSongs($song_ids);
          
          $rsvp = new RSVP();
          $rsvp->setAttending($respond->getAttending());
          $rsvp->setType($type);
          $rsvp->setFirstName($respond->getFirstName());
          $rsvp->setLastName($respond->getLastName());
          $rsvp->setEmail($respond->getEmail());
          $rsvp->setPhone($respond->getPhone());
          $rsvp->setNote($respond->getNote());
                    
          $songs = $song_repository->findById($song_ids);
          
          if (!empty($songs)) {
            foreach ($songs as $song) {
              $rsvp->addSong($song);
            }
          }
          
            
          
          $em = $this->getDoctrine()->getManager();
          
          $em->persist($rsvp);
          $em->flush();
          
          
          if ($respond->getGuest()) {
           
            foreach ($respond->getGuest() as $guest) {
            
              $rsvp_guest = new Guest();
              $rsvp_guest->setFirstName($guest->getFirstName());
              $rsvp_guest->setLastName($guest->getLastName());
              $rsvp_guest->setRSVP($rsvp);
              
              $em->persist($rsvp_guest);
              
              $rsvp->addGuest($rsvp_guest);
              
              $em->flush();
              
            }
            
          }
          
          
          // Send the Email to Will & Jess
          $message = \Swift_Message::newInstance();
          $message->setSubject('RSVP');
          
          $from = array(
            $rsvp->getEmail() => $rsvp->getFirstName().' '.$rsvp->getLastName(),
          );
          
          $message->setFrom($from);
          
          $bridegroom = array(
            'david@davidwbarratt.com' => 'David Barratt',
            'andsworth@gmail.com' => 'Andria McKinney',
          );
          
          $message->setTo($bridegroom);
          
          $params = array(
            'rsvp' => $rsvp,
            'songs' => $songs,
          );
          
          $text = $this->renderView('WeddingRespondBundle:Default:email.txt.twig', $params);
          
          $message->setBody($text);
          
          $this->get('mailer')->send($message);
          
          // Send the Email to the User
          $title = ($rsvp->getAttending()) ? 'Invitation Accepted' : 'Invitation Declined';
          
          $params = array(
            'attending' => $rsvp->getAttending(),
          );
          
          $content = $this->renderView('WeddingRespondBundle:Default:thanks.html.twig', $params);
          
          if ($rsvp->getAttending()) {
          
            $message = \Swift_Message::newInstance();
            $message->setSubject($title);
            unset($bridegroom['andsworth@gmail.com']);
            $message->setFrom($bridegroom);
            $message->setTo($rsvp->getEmail());
            
            $message->setBody($content, 'text/html');
            
            $this->get('mailer')->send($message);
            
          }
          
          
          if ($request->isXmlHttpRequest()) {
          
            $data = array(
              'title' => $title,
              'content' => $content,
            );
            
            $response = new JsonResponse();
            $response->setData($data);
            
            return $response;
            
          }
          
          // Set the Message
          if ($rsvp->getAttending()) {
            $this->get('session')->getFlashBag()->add('message', $title);
          }
          else {
            $this->get('session')->getFlashBag()->add('notice', $title);
          }
                    
          // Redirect back to the homaepage
          return $this->redirect($this->generateUrl('wedding_respond_homepage'));
          
        }
        else {
          
          if ($request->isXmlHttpRequest()) {
          
            $errors = array();
          
            foreach ($form->all() as $child) {
              foreach ($child->getErrors() as $error) {
                $errors[] = array(
                  'id' => $form->getName().'_'.$child->getName(),
                  'text' => $error->getMessage(),
                );
              }
            }
          
            $data = array(
              'errors' => $errors,
            );
            
            $response = new JsonResponse();
            $response->setData($data);
            
            return $response;
          
          }
          
        }
      
      }
      
      $kernel = $this->get('kernel');
      $path = $kernel->locateResource('@WeddingRespondBundle/Resources/public/images/photos/');
      
      $dir = opendir($path);
      
      $photos = array();
      
      while ($filename = readdir($dir)) {
        if (substr($filename, 0, 1) != '.') {
          $photos[] = $filename;
        }
      }
      
      // Ensure that the Photos are in alphabetical order.
      sort($photos);
      
      $params = array(
        'photos' => $photos,
        'form' => $form->createView(),
      );
      
      return $this->render('WeddingRespondBundle:Default:index.html.twig', $params);
      
    }
    
    public function thanksAction(Request $request, $attending = TRUE)
    {
      
      $params = array(
        'attending' => $attending,
      );
      
      return $this->render('WeddingRespondBundle:Default:thanks.html.twig', $params);
      
    }
    
    public function peopleAction(Request $request)
    {

                
      $people = array(
        'ladies' => array(
          'jeannie' => array(
            'name' => 'Jeannie Mckinney',
            'title' => 'Bridesmaid',
            'social' => array(
              'facebook' => 'jeanniemckinney',
              'twitter' => 'JeannieMcKinney',
            ),
          ),
          'amanda' => array(
            'name' => 'Amanda Barratt',
            'title' => 'Bridesmaid',
            'social' => array(
              'facebook' => 'amanda.barratt',
              'twitter' => 'Ramanda',
            ),
          ),
          'christine' => array(
            'name' => 'Christine Devlin',
            'title' => 'Bridesmaid',
            'social' => array(
              'facebook' => 'stine.devlin3', 
              'twitter' => 'stinethebean',
            ),
            
          ),  
        ),
        'gentlemen' => array(
          'will' => array(
            'name' => 'William Zavala',
            'title' => 'Groomsman',
            'social' => array(
              'facebook' => 'Alavaz',
              'twitter' => 'FunnyMSB',
            ),
          ),
          'andrew' => array(
            'image' => '/bundles/weddingrespond/images/people/andrew.jpg',
            'name' => 'Andrew Tungate',
            'title' => 'Groomsman',
            'social' => array(
              'facebook' => 'atungate',
              'twitter' => 'andrewstungate',
            ),
          ),
          'carlos' => array(
            'name' => 'Carlos Reyes',
            'title' => 'Groomsman',
            'social' => array(
              'facebook' => '2036168',
              'twitter' => 'Reyes_Carlos_',
            ),
          ),
        ),
      );
      
      $params = array(
        'title' => 'Wedding Party',
        'people' => $people,
      );
            
      return $this->render('WeddingRespondBundle:Default:people.html.twig', $params);
      
    }
    
    public function registryAction(Request $request)
    {
      
      return $this->render('WeddingRespondBundle:Default:registry.html.twig');
      
    }
    
    public function travelAction(Request $request)
    {
      
      return $this->render('WeddingRespondBundle:Default:travel.html.twig');
      
    }
    
    
    public function songsAction(Request $request)
    {
      
      $song_finder = $this->get('wedding_respond.songfinder');
      $songs = $song_finder->findSongs($request->get('q'));
      
      $response = new JsonResponse();
      $response->setData($songs);
      
      return $response;
      
    }
    
}

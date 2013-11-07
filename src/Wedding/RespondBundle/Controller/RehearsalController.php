<?php

namespace Wedding\RespondBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use Wedding\RespondBundle\Entity\RSVP;
use Wedding\RespondBundle\Entity\Guest;
use Wedding\RespondBundle\Form\Type\RespondRehearsalType;
use Wedding\RespondBundle\Form\Model\RespondRehearsal;

class RehearsalController extends Controller
{
    
    public function indexAction(Request $request)
    {
      $respond = new RespondRehearsal();
      
      // Build the Registration Form
      $form = $this->createForm(new RespondRehearsalType(), $respond);
      
      // If this Form has been completed
      if ($request->isMethod('POST')) {
      
        // Bind the Form to the request
        $form->bind($request);
        
        // Check to make sure the form is valid before procceding
        if ($form->isValid()) {
          
          $respond = $form->getData();
                    
          $type_repository = $this->getDoctrine()->getRepository('Wedding\RespondBundle\Entity\RSVPType');
          
          $type = $type_repository->findOneByType('rehearsal');
                              
          $rsvp = new RSVP();
          $rsvp->setAttending($respond->getAttending());
          $rsvp->setType($type);
          $rsvp->setFirstName($respond->getFirstName());
          $rsvp->setLastName($respond->getLastName());
          $rsvp->setEmail($respond->getEmail());
          $rsvp->setPhone($respond->getPhone());
          $rsvp->setNote($respond->getNote());
          
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
          $message->setSubject('Rehearsal Dinner RSVP');
          
          $from = array(
            $rsvp->getEmail() => $rsvp->getFirstName().' '.$rsvp->getLastName(),
          );
          
          $message->setFrom($from);
          
          $grooms_parents = array(
            'sailvenice@gmail.com' => 'Tim & Dove Barratt',
          );
          
          $bridegroom = array(
            'david@davidwbarratt.com' => 'David Barratt',
            'andsworth@gmail.com' => 'Andria McKinney',
          );
          
          $message->setTo($grooms_parents);
          $message->setCC($bridegroom);
          
          $params = array(
            'rsvp' => $rsvp,
          );
          
          $text = $this->renderView('WeddingRespondBundle:Rehearsal:email.txt.twig', $params);
          
          $message->setBody($text);
          
          $this->get('mailer')->send($message);
          
          // Send the Email to the User
          $title = ($rsvp->getAttending()) ? 'Rehearsal Dinner - Invitation Accepted' : 'Rehearsal Dinner - Invitation Declined';
          
          $params = array(
            'attending' => $rsvp->getAttending(),
          );
          
          $content = $this->renderView('WeddingRespondBundle:Rehearsal:thanks.html.twig', $params);
          
          if ($rsvp->getAttending()) {
          
            $message = \Swift_Message::newInstance();
            $message->setSubject($title);
            
            $message->setFrom($grooms_parents);
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
          return $this->redirect($this->generateUrl('wedding_respond_rehearsal'));
          
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
      
      $params = array(
        'form' => $form->createView(),
      );
      
      return $this->render('WeddingRespondBundle:Rehearsal:index.html.twig', $params);
      
    }
        
}

<?php

namespace Enymind\Bundle\Health\SecureBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Enymind\Bundle\Health\SecureBundle\Entity\User;
use Enymind\Bundle\Health\SecureBundle\Form\UserType;

class UserController extends Controller
{
    /**
     * Sends user credentials by email
     *
     * @Route("/send/{username}", name="secure_user_send")
     * @Method("POST")
     * @Template("EnymindHealthSecureBundle:User:send.html.twig")
     */
    public function sendAction(Request $request, $username)
    {
        $isSent = false;
        $isSaved = false;
      
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EnymindHealthSecureBundle:User')->findOneBy(array('username' => $username));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        if( $request->request->get('save-email') )
        {
          $entity->setEmail( $request->request->get('email') );
          $em->persist($entity);
          $em->flush();
          
          $isSaved = true;
        }
        
        try
        {
          $message = \Swift_Message::newInstance()
              ->setSubject( $this->get('translator')->trans('Health Portal Credentials, do not reply') )
              ->setFrom('no-reply@enymind.fi')
              ->setTo( $request->request->get('email') )
              ->setBody($this->renderView('EnymindHealthSecureBundle:User:message.txt.twig',
                      array('email' => $request->request->get('email'), 'entity' => $entity)))
          ;
          $this->get('mailer')->send($message);
          $isSent = true;
        }
        catch (Exception $e) {
          //
        }
        
        return array(
            'sent' => $isSent,
            'saved' => $isSaved
        );
    }
    
    /**
     * Registers (creates) a new User entity.
     *
     * @Route("/register", name="secure_user_register")
     * @Method("POST")
     * @Template("EnymindHealthSecureBundle:User:register.html.twig")
     */
    public function registerAction(Request $request)
    {
        $username = $request->request->get('username');
        $password = $request->request->get('password');
        
        if ( empty( $username ) ) {
            throw $this->createNotFoundException('username not set.');
        }
        else if ( empty( $password ) ) {
            throw $this->createNotFoundException('password not set.');
        }
      
        $entity = new User();
        $entity->setUsername( $username );
        $entity->setPassword( $password );

        $em = $this->getDoctrine()->getManager();
        $em->persist($entity);
        $em->flush();

        return array(
            'entity' => $entity
        );
    }
}

<?php

namespace Enymind\Bundle\Health\WelcomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }
  
    /**
     * @Route("/login", defaults={"username" = ""})
     * @Route("/login/{username}")
     * @Template()
     */
    public function loginAction($username)
    {
        $request = $this->getRequest();
        $session = $request->getSession();
        $lastUsername = "";

        if( $request->attributes->has( SecurityContext::AUTHENTICATION_ERROR ) )
        {
          $error = $request->attributes->get( SecurityContext::AUTHENTICATION_ERROR );
        }
        else
        {
          $error = $session->get( SecurityContext::AUTHENTICATION_ERROR );
          $session->remove( SecurityContext::AUTHENTICATION_ERROR );
        }
      
        if( $error )
          $lastUsername = $session->get( SecurityContext::LAST_USERNAME );
        
        if( !empty( $username ) )
          $lastUsername = $username;
        
        if( $error ) {
          $message = $error->getMessage();
          if( !empty( $message ) )
            $this->get('session')->setFlash('warning', $this->get('translator')->trans('Error occured during log in process:') . " " . $message );
        }
        
        return array(
          'last_username' => $lastUsername,
          'error'         => $error
        );
    }
    
    /**
     * @Route("/help")
     * @Template()
     */
    public function helpAction()
    {
        return array();
    }
    
    /**
     * @Route("/genid")
     * @Template()
     */
    public function genidAction()
    {
        return array('genid' => rand(10000, 99999));
    }
}

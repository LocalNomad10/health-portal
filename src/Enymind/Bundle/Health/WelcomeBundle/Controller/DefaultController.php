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
     * @Route("/login")
     * @Template()
     */
    public function loginAction()
    {
        $request = $this->getRequest();
        $session = $request->getSession();

        if( $request->attributes->has( SecurityContext::AUTHENTICATION_ERROR ) )
        {
          $error = $request->attributes->get( SecurityContext::AUTHENTICATION_ERROR );
        }
        else
        {
          $error = $session->get( SecurityContext::AUTHENTICATION_ERROR );
          $session->remove( SecurityContext::AUTHENTICATION_ERROR );
        }
      
        return array(
          'last_username' => $session->get( SecurityContext::LAST_USERNAME ),
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

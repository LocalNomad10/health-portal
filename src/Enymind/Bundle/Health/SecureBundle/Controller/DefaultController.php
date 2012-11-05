<?php

namespace Enymind\Bundle\Health\SecureBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @Secure(roles="ROLE_USER")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }
}

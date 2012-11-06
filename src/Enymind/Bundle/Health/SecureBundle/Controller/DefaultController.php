<?php

namespace Enymind\Bundle\Health\SecureBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Enymind\Bundle\Health\SecureBundle\Entity\Entry;
use Enymind\Bundle\Health\SecureBundle\Entity\EntryType;
use Symfony\Component\HttpFoundation\Request;

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
    
    /**
     * @Route("/enter")
     * @Secure(roles="ROLE_USER")
     * @Template()
     */
    public function enterAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entryTypes = $em->getRepository('EnymindHealthSecureBundle:EntryType')->findAll();
      
        return array('entryTypes' => $entryTypes);
    }
    
    /**
     * @Route("/enter/{entryTypeId}")
     * @Secure(roles="ROLE_USER")
     * @Template()
     */
    public function enterFormAction($entryTypeId)
    {
        $em = $this->getDoctrine()->getManager();
        $entryType = $em->getRepository('EnymindHealthSecureBundle:EntryType')->find($entryTypeId);
        
        $defaultValue = ceil( ceil( $entryType->getMax() / 2 ) + intval( $entryType->getMin() ) );
        
        return array('entryType' => $entryType,
                     'defaultValue' => $defaultValue
            );
    }
    
    /**
     * @Route("/enter/{entryTypeId}/save")
     * @Method("POST")
     * @Secure(roles="ROLE_USER")
     */
    public function enterFormSaveAction(Request $request, $entryTypeId)
    {
        $value = $request->request->get('value');
        
        if ( empty( $value ) ) {
            throw $this->createNotFoundException('value not set.');
        }
      
        $em = $this->getDoctrine()->getManager();
        $entryType = $em->getRepository('EnymindHealthSecureBundle:EntryType')->find($entryTypeId);
        
        $entry = new Entry();
        $entry->setTypeId( $entryType );
        $entry->setOwnerId( $this->getUser() );
        $entry->setValue( $value );
        
        $em->persist($entry);
        $em->flush();
      
        $this->get('session')->setFlash('notice', $this->get('translator')->trans('Your entry were added!') );
        
        $response = $this->forward('EnymindHealthSecureBundle:Default:index');
        return $response;
    }
}

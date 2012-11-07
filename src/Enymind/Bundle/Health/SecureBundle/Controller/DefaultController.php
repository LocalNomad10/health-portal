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
use Symfony\Component\HttpFoundation\Response;

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
        $entryTypes = $em->getRepository('EnymindHealthSecureBundle:EntryType')->findBy(
                array("owner_id" => array( 1, $this->getUser()->getId() )), // where
                array("name" => "ASC") // order by
                );
      
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
        
        return array('entryType' => $entryType
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
    
    /**
     * @Route("/group")
     * @Secure(roles="ROLE_USER")
     * @Template()
     */
    public function groupAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entryGroups = $em->getRepository('EnymindHealthSecureBundle:EntryGroup')->findBy(
                array("owner_id" => array( 1, $this->getUser()->getId() )), // where
                array("name" => "ASC") // order by
                );
      
        return array('entryGroups' => $entryGroups);
    }
    
    /**
     * @Route("/group/{entryGroupId}")
     * @Secure(roles="ROLE_USER")
     * @Template()
     */
    public function groupFormAction($entryGroupId)
    {
        $em = $this->getDoctrine()->getManager();
        $entryGroup = $em->getRepository('EnymindHealthSecureBundle:EntryGroup')->find($entryGroupId);
        
        $entryTypes = array();
        
        foreach( $entryGroup->getEntryTypes() as $entryTypeId ) {
          $entryType = $em->getRepository('EnymindHealthSecureBundle:EntryType')->find($entryTypeId);
          
          $entryTypes[] = $entryType;
        }
        
        return array('entryGroup' => $entryGroup,
                     'entryTypes' => $entryTypes
            );
    }
    
    /**
     * @Route("/group/{entryGroupId}/save")
     * @Method("POST")
     * @Secure(roles="ROLE_USER")
     */
    public function groupFormSaveAction(Request $request, $entryGroupId)
    {
        $values = $request->request->get('value');
        
        if ( count( $values ) == 0 ) {
            throw $this->createNotFoundException('values not set.');
        }
      
        $em = $this->getDoctrine()->getManager();
        $entryGroup = $em->getRepository('EnymindHealthSecureBundle:EntryGroup')->find($entryGroupId);
        
        foreach( $entryGroup->getEntryTypes() as $index => $entryTypeId ) {
          $entryType = $em->getRepository('EnymindHealthSecureBundle:EntryType')->find($entryTypeId);

          $entry = new Entry();
          $entry->setTypeId( $entryType );
          $entry->setOwnerId( $this->getUser() );
          $entry->setValue( $values[$index] );

          $em->persist($entry);
        }
        
        $em->flush();
      
        $this->get('session')->setFlash('notice', $this->get('translator')->trans('Your group were added!') );
        
        $response = $this->forward('EnymindHealthSecureBundle:Default:index');
        return $response;
    }
    
    /**
     * @Route("/stats")
     * @Secure(roles="ROLE_USER")
     * @Template()
     */
    public function statsAction()
    {
        return array();
    }
    
    /**
     * @Route("/stats/data")
     * @Secure(roles="ROLE_USER")
     */
    public function statsDataAction()
    {
        $entries = $this->getUser()->getEntries();
        
        $entriesByType = array();
        foreach( $entries as $entry ) {
          $entriesByType[ $entry->getTypeId()->getName() ][] = $entry;
        }
        
        $results = array();
        foreach( $entriesByType as $typeName => $entries ) {
          $result = array('label' => $typeName );
          foreach( $entries as $entry ) {
            $result['data'][]=array($entry->getAdded()->getTimestamp(), $entry->getValue());
          }
          $results[] = $result;
        }
        
        return new Response( json_encode($results) );
    }
    
    /**
     * @Route("/report")
     * @Secure(roles="ROLE_USER")
     * @Template()
     */
    public function reportAction()
    {
        return array('entries' => $this->getUser()->getEntries());
    }
}

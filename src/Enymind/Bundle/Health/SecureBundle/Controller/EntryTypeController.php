<?php

namespace Enymind\Bundle\Health\SecureBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Enymind\Bundle\Health\SecureBundle\Entity\EntryType;
use Enymind\Bundle\Health\SecureBundle\Form\EntryTypeType;

class EntryTypeController extends Controller
{
    /**
     * Lists all EntryType entities.
     *
     * @Route("/", name="secure_manage_types")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('EnymindHealthSecureBundle:EntryType')->findBy(
                array("owner_id" => array( $this->getUser()->getId() )), // where
                array("name" => "ASC") // order by
                );

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Displays a form to create a new EntryType entity.
     *
     * @Route("/new", name="secure_manage_types_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new EntryType();
        $form   = $this->createForm(new EntryTypeType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new EntryType entity.
     *
     * @Route("/create", name="secure_manage_types_create")
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
        $entity  = new EntryType();
        $entity->setOwnerId( $this->getUser() );
        $form = $this->createForm(new EntryTypeType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->setFlash('notice', $this->get('translator')->trans('Your entry type were added!') );

            $response = $this->forward('EnymindHealthSecureBundle:EntryType:index');
            return $response;
        }

        $this->get('session')->setFlash('error', $this->get('translator')->trans('Error adding entry type!') );
        
        $response = $this->forward('EnymindHealthSecureBundle:EntryType:index');
        return $response;
    }

    /**
     * Displays a form to edit an existing EntryType entity.
     *
     * @Route("/{id}/edit", name="secure_manage_types_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EnymindHealthSecureBundle:EntryType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EntryType entity.');
        }
        
        if( $entity->getOwnerId()->getId() != $this->getUser()->getId() ) {
            throw $this->createNotFoundException('EntryType entity not belognin to user.');
        }

        $editForm = $this->createForm(new EntryTypeType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing EntryType entity.
     *
     * @Route("/{id}/update", name="secure_manage_types_update")
     * @Method("POST")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EnymindHealthSecureBundle:EntryType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EntryType entity.');
        }
        
        if( $entity->getOwnerId()->getId() != $this->getUser()->getId() ) {
            throw $this->createNotFoundException('EntryType entity not belognin to user.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new EntryTypeType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            $this->get('session')->setFlash('notice', $this->get('translator')->trans('Your entry type were saved!') );

            $response = $this->forward('EnymindHealthSecureBundle:EntryType:index');
            return $response;
        }

        $this->get('session')->setFlash('error', $this->get('translator')->trans('Error saving entry type!') );
        
        $response = $this->forward('EnymindHealthSecureBundle:EntryType:index');
        return $response;
    }

    /**
     * Deletes a EntryType entity.
     *
     * @Route("/{id}/delete", name="secure_manage_types_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('EnymindHealthSecureBundle:EntryType')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find EntryType entity.');
            }
            
            if( $entity->getOwnerId()->getId() != $this->getUser()->getId() ) {
                throw $this->createNotFoundException('EntryType entity not belognin to user.');
            }

            $em->remove($entity);
            $em->flush();
            
            $this->get('session')->setFlash('notice', $this->get('translator')->trans('Your entry type were deleted!') );

            $response = $this->forward('EnymindHealthSecureBundle:EntryType:index');
            return $response;
        }

        $this->get('session')->setFlash('error', $this->get('translator')->trans('Error deleting entry type!') );
        
        $response = $this->forward('EnymindHealthSecureBundle:EntryType:index');
        return $response;
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}

<?php

namespace Enymind\Bundle\Health\SecureBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Enymind\Bundle\Health\SecureBundle\Entity\EntryGroup;
use Enymind\Bundle\Health\SecureBundle\Form\EntryGroupType;

class EntryGroupController extends Controller
{
    /**
     * Lists all EntryGroup entities.
     *
     * @Route("/", name="secure_manage_group")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('EnymindHealthSecureBundle:EntryGroup')->findBy(
                array("owner_id" => array( $this->getUser()->getId() )), // where
                array("name" => "ASC") // order by
                );

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Displays a form to create a new EntryGroup entity.
     *
     * @Route("/new", name="secure_manage_group_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new EntryGroup();
        $form   = $this->createForm(new EntryGroupType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new EntryGroup entity.
     *
     * @Route("/create", name="secure_manage_group_create")
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
        $entity  = new EntryGroup();
        $entity->setOwnerId( $this->getUser() );
        $form = $this->createForm(new EntryGroupType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->setFlash('notice', $this->get('translator')->trans('Your entry group were added!') );

            $response = $this->forward('EnymindHealthSecureBundle:EntryGroup:index');
            return $response;
        }

        $this->get('session')->setFlash('error', $this->get('translator')->trans('Error adding entry group!') );
        
        $response = $this->forward('EnymindHealthSecureBundle:EntryGroup:index');
        return $response;
    }

    /**
     * Displays a form to edit an existing EntryGroup entity.
     *
     * @Route("/{id}/edit", name="secure_manage_group_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EnymindHealthSecureBundle:EntryGroup')->find($id);
        
        $entity->setEntryTypesArrayCollection( $em->getRepository('EnymindHealthSecureBundle:EntryType')->findBy(
                array("id" => $entity->getEntryTypesArray() ) ) );

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EntryGroup entity.');
        }
        
        if( $entity->getOwnerId()->getId() != $this->getUser()->getId() ) {
            throw $this->createNotFoundException('EntryGroup entity not belognin to user.');
        }

        $editForm = $this->createForm(new EntryGroupType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing EntryGroup entity.
     *
     * @Route("/{id}/update", name="secure_manage_group_update")
     * @Method("POST")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EnymindHealthSecureBundle:EntryGroup')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EntryGroup entity.');
        }
        
        if( $entity->getOwnerId()->getId() != $this->getUser()->getId() ) {
            throw $this->createNotFoundException('EntryGroup entity not belognin to user.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new EntryGroupType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            $this->get('session')->setFlash('notice', $this->get('translator')->trans('Your entry group were saved!') );

            $response = $this->forward('EnymindHealthSecureBundle:EntryGroup:index');
            return $response;
        }

        $this->get('session')->setFlash('error', $this->get('translator')->trans('Error saving entry group!') );
        
        $response = $this->forward('EnymindHealthSecureBundle:EntryGroup:index');
        return $response;
    }

    /**
     * Deletes a EntryGroup entity.
     *
     * @Route("/{id}/delete", name="secure_manage_group_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('EnymindHealthSecureBundle:EntryGroup')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find EntryGroup entity.');
            }
            
            if( $entity->getOwnerId()->getId() != $this->getUser()->getId() ) {
                throw $this->createNotFoundException('EntryGroup entity not belognin to user.');
            }

            $em->remove($entity);
            $em->flush();
            
            $this->get('session')->setFlash('notice', $this->get('translator')->trans('Your entry group were deleted!') );

            $response = $this->forward('EnymindHealthSecureBundle:EntryGroup:index');
            return $response;
        }

        $this->get('session')->setFlash('error', $this->get('translator')->trans('Error deleting entry group!') );
        
        $response = $this->forward('EnymindHealthSecureBundle:EntryGroup:index');
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

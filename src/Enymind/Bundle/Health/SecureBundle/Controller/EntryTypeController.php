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
     * Finds and displays a EntryType entity.
     *
     * @Route("/{id}/show", name="secure_manage_types_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EnymindHealthSecureBundle:EntryType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EntryType entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
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
     * @Template("EnymindHealthSecureBundle:EntryType:new.html.twig")
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

            return $this->redirect($this->generateUrl('secure_manage_types_show', array('id' => $entity->getId())));
        }

        $this->get('session')->setFlash('notice', $this->get('translator')->trans('Your entry type were added!') );
        
        $response = $this->forward('secure_manage_types');
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
     * @Template("EnymindHealthSecureBundle:EntryType:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EnymindHealthSecureBundle:EntryType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EntryType entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new EntryTypeType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('secure_manage_types_edit', array('id' => $id)));
        }

        $this->get('session')->setFlash('notice', $this->get('translator')->trans('Your entry type were saved!') );
        
        $response = $this->forward('secure_manage_types');
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

            $em->remove($entity);
            $em->flush();
        }

        $this->get('session')->setFlash('notice', $this->get('translator')->trans('Your entry type were deleted!') );
        
        $response = $this->forward('secure_manage_types');
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

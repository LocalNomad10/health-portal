<?php

namespace Enymind\Bundle\Health\SecureBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Enymind\Bundle\Health\SecureBundle\Entity\EntryGroup;
use Enymind\Bundle\Health\SecureBundle\Form\EntryGroupType;

/**
 * EntryGroup controller.
 *
 * @Route("/secure/manage/group")
 */
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

        $entities = $em->getRepository('EnymindHealthSecureBundle:EntryGroup')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a EntryGroup entity.
     *
     * @Route("/{id}/show", name="secure_manage_group_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EnymindHealthSecureBundle:EntryGroup')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EntryGroup entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
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
     * @Template("EnymindHealthSecureBundle:EntryGroup:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new EntryGroup();
        $form = $this->createForm(new EntryGroupType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('secure_manage_group_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
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

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EntryGroup entity.');
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
     * @Template("EnymindHealthSecureBundle:EntryGroup:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EnymindHealthSecureBundle:EntryGroup')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EntryGroup entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new EntryGroupType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('secure_manage_group_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
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

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('secure_manage_group'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}

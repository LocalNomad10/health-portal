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
     * Lists all User entities.
     *
     * @Route("/", name="secure_user")
     * @Secure(roles="ROLE_ADMIN")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('EnymindHealthSecureBundle:User')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a User entity.
     *
     * @Route("/{id}/show", name="secure_user_show")
     * @Secure(roles="ROLE_USER")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EnymindHealthSecureBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new User entity.
     *
     * @Route("/new", name="secure_user_new")
     * @Secure(roles="ROLE_ADMIN")
     * @Template()
     */
    public function newAction()
    {
        $entity = new User();
        $form   = $this->createForm(new UserType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

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
              ->setSubject('Health Portal Credentials, do not reply')
              ->setFrom('no-reply@enymind.fi')
              ->setTo( $entity->getEmail() )
              ->setBody($this->renderView('EnymindHealthSecureBundle:User:message.txt.twig', array('entity' => $entity)))
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
        if ( empty( $request->request->get('username') ) ) {
            throw $this->createNotFoundException('username not set.');
        }
        else if ( empty( $request->request->get('password') ) ) {
            throw $this->createNotFoundException('password not set.');
        }
      
        $entity = new User();
        $entity->setUsername( $request->request->get('username') );
        $entity->setPassword( $request->request->get('password') );

        $em = $this->getDoctrine()->getManager();
        $em->persist($entity);
        $em->flush();

        return array(
            'entity' => $entity
        );
    }
    
    /**
     * Creates a new User entity.
     *
     * @Route("/create", name="secure_user_create")
     * @Secure(roles="ROLE_ADMIN")
     * @Method("POST")
     * @Template("EnymindHealthSecureBundle:User:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new User();
        $form = $this->createForm(new UserType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('secure_user_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing User entity.
     *
     * @Route("/{id}/edit", name="secure_user_edit")
     * @Secure(roles="ROLE_ADMIN")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EnymindHealthSecureBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $editForm = $this->createForm(new UserType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing User entity.
     *
     * @Route("/{id}/update", name="secure_user_update")
     * @Secure(roles="ROLE_ADMIN")
     * @Method("POST")
     * @Template("EnymindHealthSecureBundle:User:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EnymindHealthSecureBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new UserType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('secure_user_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a User entity.
     *
     * @Route("/{id}/delete", name="secure_user_delete")
     * @Secure(roles="ROLE_ADMIN")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('EnymindHealthSecureBundle:User')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find User entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('secure_user'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}

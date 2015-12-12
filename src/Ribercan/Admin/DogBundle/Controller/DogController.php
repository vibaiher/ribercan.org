<?php

namespace Ribercan\Admin\DogBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Ribercan\Admin\DogBundle\Entity\Dog;
use Ribercan\Admin\DogBundle\Form\DogType;

/**
 * Dog controller.
 *
 * @Route("/dog")
 */
class DogController extends Controller
{

    /**
     * Lists all Dog entities.
     *
     * @Route("/", name="dog")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('RibercanAdminDogBundle:Dog')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new Dog entity.
     *
     * @Route("/", name="dog_create")
     * @Method("POST")
     * @Template("RibercanAdminDogBundle:Dog:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Dog();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('dog_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Dog entity.
     *
     * @param Dog $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Dog $entity)
    {
        $form = $this->createForm(new DogType(), $entity, array(
            'action' => $this->generateUrl('dog_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Dog entity.
     *
     * @Route("/new", name="dog_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Dog();
        $dog_form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'dog_form'   => $dog_form->createView(),
        );
    }

    /**
     * Finds and displays a Dog entity.
     *
     * @Route("/{id}", name="dog_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RibercanAdminDogBundle:Dog')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Dog entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Dog entity.
     *
     * @Route("/{id}/edit", name="dog_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RibercanAdminDogBundle:Dog')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Dog entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Dog entity.
    *
    * @param Dog $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Dog $entity)
    {
        $form = $this->createForm(new DogType(), $entity, array(
            'action' => $this->generateUrl('dog_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Dog entity.
     *
     * @Route("/{id}", name="dog_update")
     * @Method("PUT")
     * @Template("RibercanAdminDogBundle:Dog:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RibercanAdminDogBundle:Dog')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Dog entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('dog_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Dog entity.
     *
     * @Route("/{id}", name="dog_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('RibercanAdminDogBundle:Dog')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Dog entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('dog'));
    }

    /**
     * Creates a form to delete a Dog entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('dog_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}

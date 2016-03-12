<?php

namespace Ribercan\Admin\DogBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Ribercan\Admin\DogBundle\Entity\Dog;
use Ribercan\Admin\DogBundle\Form\DogType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * Dog controller.
 *
 * @Route("/dogs")
 */
class DogController extends Controller
{

    /**
     * Lists all Dog entities.
     *
     * @Route("", name="admin_dogs")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $dogs = $this->dogRepository()->findAll();

        return array(
            'dogs' => $dogs,
        );
    }

    /**
     * Creates a new Dog entity.
     *
     * @Route("", name="admin_dog_create")
     * @Method("POST")
     * @Template("RibercanAdminDogBundle:Dog:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $dog = new Dog();
        $form = $this->createCreateForm($dog);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($dog);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_dog_show', array('id' => $dog->getId())));
        }

        return array(
            'dog' => $dog,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Dog entity.
     *
     * @param Dog $dog The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Dog $dog)
    {
        $form = $this->createForm(DogType::class, $dog, array(
            'action' => $this->generateUrl('admin_dog_create'),
            'method' => 'POST',
        ));

        $form->add('submit', SubmitType::class, array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Dog entity.
     *
     * @Route("/new", name="admin_dog_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $dog = new Dog();
        $form = $this->createCreateForm($dog);

        return array(
            'form'   => $form->createView()
        );
    }

    /**
     * Finds and displays a Dog entity.
     *
     * @Route("/{id}", name="admin_dog_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $dog = $this->dogRepository()->find($id);

        if (!$dog) {
            throw $this->createNotFoundException('Unable to find Dog entity.');
        }

        $form = $this->createDeleteForm($id);

        return array(
            'dog'  => $dog,
            'delete_form' => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Dog entity.
     *
     * @Route("/{id}/edit", name="admin_dog_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $dog = $this->dogRepository()->find($id);

        if (!$dog) {
            throw $this->createNotFoundException('Unable to find Dog entity.');
        }

        $editForm = $this->createEditForm($dog);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'dog'         => $dog,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Dog entity.
    *
    * @param Dog $dog The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Dog $dog)
    {
        $form = $this->createForm(DogType::class, $dog, array(
            'action' => $this->generateUrl('admin_dog_update', array('id' => $dog->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', SubmitType::class, array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Dog entity.
     *
     * @Route("/{id}", name="admin_dog_update")
     * @Method("PUT")
     * @Template("RibercanAdminDogBundle:Dog:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $dog = $this->dogRepository()->find($id);

        if (!$dog) {
            throw $this->createNotFoundException('Unable to find Dog entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($dog);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_dog_edit', array('id' => $id)));
        }

        return array(
            'dog'      => $dog,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Dog entity.
     *
     * @Route("/{id}", name="admin_dog_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $dog = $this->dogRepository()->find($id);

            if (!$dog) {
                throw $this->createNotFoundException('Unable to find Dog entity.');
            }

            $em->remove($dog);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_dogs'));
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
            ->setAction($this->generateUrl('admin_dog_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', SubmitType::class, array('label' => 'Delete'))
            ->getForm()
        ;
    }

    private function dogRepository()
    {
        $em = $this->getDoctrine()->getManager();
        return $em->getRepository('RibercanAdminDogBundle:Dog');
    }
}

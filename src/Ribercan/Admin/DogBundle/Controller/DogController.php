<?php

namespace Ribercan\Admin\DogBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Ribercan\Admin\DogBundle\Entity\Dog;
use Ribercan\Admin\DogBundle\Form\DogType;

class DogController extends Controller
{

    /**
     * @Template()
     */
    public function indexAction()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $dogs = $entityManager->getRepository('RibercanAdminDogBundle:Dog')->findAll();

        return array(
            'dogs' => $dogs,
        );
    }

    /**
     * @Template("RibercanAdminDogBundle:Dog:new.html.twig")
     */
    public function newAction(Request $request)
    {
        $dog = new Dog();
        $form = $this->createForm(DogType::class, $dog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($dog);
            $entityManager->flush();

            return $this->redirectToRoute('admin_dogs_show', array('id' => $dog->getId()));
        }

        return array(
            'dog' => $dog,
            'form' => $form->createView(),
        );
    }

    /**
     * @Template()
     */
    public function showAction(Dog $dog)
    {
        $deleteForm = $this->createDeleteForm($dog);

        return array(
            'dog'  => $dog,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * @Template()
     */
    public function editAction(Request $request, Dog $dog)
    {
        $deleteForm = $this->createDeleteForm($dog);
        $editForm = $this->createForm(DogType::class, $dog);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($dog);
            $entityManager->flush();

            return $this->redirectToRoute('admin_dogs_edit', array('id' => $dog->getId()));
        }

        return array(
            'dog'         => $dog,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    public function deleteAction(Request $request, Dog $dog)
    {
        $form = $this->createDeleteForm($dog);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($dog);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_dogs_index');
    }

    private function createDeleteForm($dog)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_dogs_delete', array('id' => $dog->getId())))
            ->setMethod('DELETE')
            ->add('submit', SubmitType::class, array(
                    'label' => 'Delete',
                    'attr' => array(
                        'class' => 'btn btn-danger'
                    )
                )
            )
            ->getForm()
        ;
    }
}

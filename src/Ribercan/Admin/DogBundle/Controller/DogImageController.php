<?php

namespace Ribercan\Admin\DogBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

use Ribercan\Admin\DogBundle\Entity\DogImage;

/**
 * DogImage controller.
 *
 * @Route("/dogs/{dog_id}/images")
 */
class DogImageController extends Controller
{
    /**
     * Lists all DogImage entities.
     *
     * @Route("", name="dog_images_index")
     * @Method("GET")
     * @Template()
     */
    public function indexAction($dog_id)
    {
        $em = $this->getDoctrine()->getManager();

        $dog = $em->getRepository('RibercanAdminDogBundle:Dog')->find($dog_id);
        $images = $em->getRepository('RibercanAdminDogBundle:DogImage')->findBy(array('dog' => $dog));

        return array('dog' => $dog, 'images' => $images);
    }

    /**
     * @Route("", name="dog_images_create")
     * @Method("POST")
     * @Template("RibercanAdminDogBundle:DogImage:new.html.twig")
     */
    public function createAction($dog_id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $dog = $em->getRepository('RibercanAdminDogBundle:Dog')->find($dog_id);

        $entity = new DogImage();
        $entity->setDog($dog);

        $form = $this->createUploadForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $entity->upload();

            $em->persist($entity);
            $em->flush();

            $this->addFlash('success', 'Image uploaded succesfully');

            return $this->redirect($this->generateUrl('dog_images_show', array('dog_id' => $dog->getId(), 'id' => $entity->getId())));
        }

        return array('dog' => $dog, 'image_form' => $form->createView());
    }

    /**
     * @Route("/new", name="dog_images_new")
     * @Method("GET")
     * @Template("RibercanAdminDogBundle:DogImage:new.html.twig")
     */
    public function newAction($dog_id)
    {
        $em = $this->getDoctrine()->getManager();

        $dog = $em->getRepository('RibercanAdminDogBundle:Dog')->find($dog_id);

        $entity = new DogImage();
        $entity->setDog($dog);

        $form = $this->createUploadForm($entity);

        return array('dog' => $dog, 'image_form' => $form->createView());
    }

    /**
     * Finds and displays a DogImage entity.
     *
     * @Route("/{id}", name="dog_images_show")
     * @Method("GET")
     * @Template("RibercanAdminDogBundle:DogImage:show.html.twig")
     */
    public function showAction(DogImage $dog_image)
    {
        return array('dog' => $dog_image->getDog(), 'dog_image' => $dog_image);
    }

    private function createUploadForm(DogImage $entity)
    {
        $form = $this->createFormBuilder($entity, array('csrf_protection' => false))
            ->setAction($this->generateUrl('dog_images_create', array('dog_id' => $entity->getDog()->getId())))
            ->setMethod('POST')
            ->add('name')
            ->add('file')
            ->add('submit', SubmitType::class, array('label' => 'Subir'))
            ->getForm();

        return $form;
    }
}

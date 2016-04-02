<?php

namespace Ribercan\Admin\DogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

use Ribercan\Admin\DogBundle\Entity\Dog;
use Ribercan\Admin\DogBundle\Entity\DogImage;

class DogImageController extends Controller
{
    /**
     * @ParamConverter("dog", class="RibercanAdminDogBundle:Dog", options={"id" = "dog_id"})
     * @Template("RibercanAdminDogBundle:DogImage:index.html.twig")
     */
    public function indexAction(Dog $dog)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $images = $entityManager->getRepository('RibercanAdminDogBundle:DogImage')->findBy(array(
          'dog' => $dog
        ));

        return array(
          'dog' => $dog,
          'images' => $images
        );
    }

    /**
     * @ParamConverter("dog", class="RibercanAdminDogBundle:Dog", options={"id" = "dog_id"})
     * @Template("RibercanAdminDogBundle:DogImage:new.html.twig")
     */
    public function newAction(Request $request, Dog $dog)
    {
        $entity = new DogImage();
        $entity->setDog($dog);

        $form = $this->createUploadForm($entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entity->upload();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($entity);
            $entityManager->flush();

            $this->addFlash('success', 'Image uploaded succesfully');

            return $this->redirectToRoute('admin_dog_images_show', array('dog_id' => $dog->getId(), 'id' => $entity->getId()));
        }

        return array(
          'dog' => $dog,
          'image_form' => $form->createView()
        );
    }

    /**
     * @Template("RibercanAdminDogBundle:DogImage:show.html.twig")
     */
    public function showAction(DogImage $dog_image)
    {
        return array(
          'dog' => $dog_image->getDog(),
          'dog_image' => $dog_image
        );
    }

    private function createUploadForm(DogImage $entity)
    {
        $form = $this->createFormBuilder($entity, array('csrf_protection' => false))
            ->add('name')
            ->add('file')
            ->add('submit', SubmitType::class, array('label' => 'Subir'))
            ->getForm();

        return $form;
    }
}

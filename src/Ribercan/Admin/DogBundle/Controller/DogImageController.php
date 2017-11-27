<?php

namespace Ribercan\Admin\DogBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Ribercan\Admin\DogBundle\Entity\Dog;
use Ribercan\Admin\DogBundle\Entity\DogImage;
use Ribercan\Admin\DogBundle\Form\DogImageType;

class DogImageController extends Controller
{

    /**
     * @Template()
     */
    public function indexAction(Dog $dog, Request $request)
    {
        $imageForm = $this->createForm(DogImageType::class, $dog);
        $imageForm->handleRequest($request);

        if ($imageForm->isSubmitted() && $imageForm->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($dog);
            $entityManager->flush();
        }

        return array(
            'dog' => $dog,
            'images' => $dog->getImages(),
            'image_form' => $imageForm->createView()
        );
    }

    public function markAsCoverAction(DogImage $dogImage)
    {
        $dog = $dogImage->getDog();
        $dog->setUploadedImages([]);
        $entityManager = $this->getDoctrine()->getManager();
        foreach ($dog->getImages() as $otherDogImages) {
            $otherDogImages->setFirstImage(false);
            $entityManager->persist($otherDogImages);
        }
        $dogImage->setFirstImage(true);
        $entityManager->persist($dogImage);
        $entityManager->flush();

        return $this->redirectToRoute(
            'admin_dog_images_index',
            array(
                'id' => $dog->getId()
            )
        );
    }
}

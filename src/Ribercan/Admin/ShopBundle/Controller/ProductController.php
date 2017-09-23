<?php

namespace Ribercan\Admin\ShopBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Ribercan\ShopBundle\Entity\Product;
use Ribercan\Admin\ShopBundle\Form\ProductType;

class ProductController extends Controller
{
    public function indexAction()
    {
        $products = $this->get('doctrine')->
            getRepository('RibercanShopBundle:Product')
            ->findAll();
        return $this->render(
            'RibercanAdminShopBundle:Product:index.html.twig',
            array('products' => $products)
        );
    }

    public function newAction(Request $request)
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute(
                'admin_product_show',
                array(
                    'id' => $product->getId()
                )
            );
        }

        return $this->render(
            'RibercanAdminShopBundle:Product:new.html.twig',
            array(
                'product' => $product,
                'form' => $form->createView(),
            )
        );
    }

    public function showAction(Product $product)
    {
        $delete_form = $this->createDeleteForm($product);

        return $this->render(
            'RibercanAdminShopBundle:Product:show.html.twig',
            array(
                'product'  => $product,
                'delete_form' => $delete_form->createView()
            )
        );
    }

    public function editAction(Request $request, Product $product)
    {
        $editForm = $this->createForm(ProductType::class, $product);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('admin_product_show', array('id' => $product->getId()));
        }

        return $this->render(
            'RibercanAdminShopBundle:Product:edit.html.twig',
            array(
                'product' => $product,
                'edit_form' => $editForm->createView()
            )
        );
    }

    public function deleteAction(Request $request, Product $product)
    {
        $form = $this->createDeleteForm($product);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($product);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_products_index');
    }

    private function createDeleteForm(Product $product)
    {
        return $this->createFormBuilder()
            ->setAction(
                $this->generateUrl(
                    'admin_product_delete',
                    array(
                        'id' => $product->getId()
                    )
                )
            )
            ->setMethod('DELETE')
            ->add('submit', SubmitType::class, array('label' => 'Delete'))
            ->getForm()
        ;
    }
}

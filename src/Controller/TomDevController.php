<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProductRepository;


class TomDevController extends AbstractController
{
    #[Route('/TomDev', name: 'app_tom_dev')]
    public function index(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();

        return $this->render('tom_dev/index.html.twig', [
            'products' => $products,
            'controller_name' => 'TomDevController',
        ]);
    }

    #[Route('/Add', name: 'app_add')]
    public function addForm(ProductRepository $productRepository): Response
    {
        $product = new Product();
        $products = $productRepository->findAll();
        $form = $this->createForm(ProductType::class, $product);
        return $this->render('home/addForm.html.twig', [
            'products' => $products,
            'controller_name' => 'TomDevController',
            'addForm' => $form->createView(),
        ]);
    }
}
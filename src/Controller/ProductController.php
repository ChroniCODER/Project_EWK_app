<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\ProductDoc;
use App\Form\CollecType;
use App\Form\Product1Type;
use App\Form\ProductDocType;
use App\Form\ProductManualType;
use App\Repository\ProductDocRepository;
use App\Repository\ProductRepository;
use DateInterval;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/product')]
class ProductController extends AbstractController
{
    #[Route('/', name: 'app_product_index', methods: ['GET'])]

    public function index(Request $request, ProductRepository $productRepository)
    {
        $orderBy = $request->get('orderBy', 'date');
        if ($orderBy === 'name') {
            $products = $productRepository->findAllSortedByName();
        } else {
            $products = $productRepository->findAllSortedByDate();
        }

        return $this->render('product/index.html.twig', [
            'products' => $products,
        ]);
    }

    /* public function index(ProductRepository $productRepository): Response
    {
        return $this->render('product/index.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    } */

    #[Route('/new', name: 'app_product_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ProductRepository $productRepository): Response
    {
        $product = new Product();
        $form = $this->createForm(Product1Type::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $product = $form->getData();

            $purchaseDate = $product->getPurchaseDate();
            $warrantyDuration = $product->getWarrantyDuration();
            $expirationDate = clone $purchaseDate;
            $expirationDate = $expirationDate->add(new DateInterval('P' . $warrantyDuration . 'Y'));
            $product->setExpirationDate($expirationDate);

            $productRepository->save($product, true);

            return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('product/new.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/addManual', name: 'app_product_addManual', methods: ['GET', 'POST'])]
    public function addManual(Request $request, Product $product, ProductDocRepository $productDocRepository): Response
    {

        $form = $this->createForm(ProductManualType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $productManual = $form->getData();


            $productManual->setProduct($product);
            $productDocRepository->save($productManual, true);

            return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('product/addManual.html.twig', [
            'product' => $product,
            'form' => $form,

        ]);
    }

    #[Route('/{id}/addDoc', name: 'app_product_addDoc', methods: ['GET', 'POST'])]
    public function addDoc(Request $request, Product $product, ProductDocRepository $productDocRepository): Response
    {

        $form = $this->createForm(CollecType::class);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($form->get('docs')->getData() as $doc) {
                $doc->setProduct($product);
                $productDocRepository->save($doc, true);
            }
            return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('product/addDoc.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_product_show', methods: ['GET'])]
    public function show(Product $product): Response
    {
        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_product_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Product $product, ProductRepository $productRepository): Response
    {
        $form = $this->createForm(Product1Type::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $product = $form->getData();

            $purchaseDate = $product->getPurchaseDate();
            $warrantyDuration = $product->getWarrantyDuration();
            $expirationDate = clone $purchaseDate;
            $expirationDate = $expirationDate->add(new DateInterval('P' . $warrantyDuration . 'Y'));
            $product->setExpirationDate($expirationDate);

            $productRepository->save($product, true);

            return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('product/edit.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_product_delete', methods: ['POST'])]
    public function delete(Request $request, Product $product, ProductRepository $productRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $product->getId(), $request->request->get('_token'))) {
            $productRepository->remove($product, true);
        }

        return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/delete-doc{id}', name: 'app_productDoc_delete', methods: ['POST', 'DELETE'])]
    public function deleteDoc(int $id, ProductDocRepository $productDocRepository)
    {
        // Recherche du productDoc par ID
        $productDoc = $productDocRepository->find($id);

        // Suppression du productDoc
        $productDocRepository->remove($productDoc, true);

        // Vérification que le produit existe
        if (!$productDoc) {
            return new JsonResponse(['message' => 'Doc non trouvé'], 404);
        }

        // Suppression du produit
        // $product->delete();

        // Retour d'une réponse de succès
        return new JsonResponse(['message' => 'Doc supprimé avec succès']);
    }

    #[Route('/delete-manual/{id}', name: 'app_product_deleteManual', methods: ['POST', 'DELETE'])]
    public function deleteManual(int $id, ProductDocRepository $productDocRepository, Request $request)
    {
        // Recherche du productDoc par ID
        $productDoc = $productDocRepository->find($id);

        // Vérification que le productDoc existe et a un champ manual
        if (!$productDoc || !$productDoc->getManual()) {
            return new JsonResponse(['message' => 'Manual non trouvé'], 404);
        }

        // Suppression du manual
        $productDocRepository->remove($productDoc, true);

        // Retour d'une réponse de succès
        $referer = $request->headers->get('referer');
        return $this->redirect($referer);
    }




    /* #[Route('/name', name: 'app_product_index_name', methods: ['GET'])]
    public function indexByName(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAllSortedByName();

        return $this->render('product/index.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/date', name: 'app_product_index_date', methods: ['GET'])]
    public function indexByDate(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAllSortedByDate();

        return $this->render('product/index.html.twig', [
            'products' => $products,
        ]);
    } */
}

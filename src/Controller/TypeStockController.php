<?php

namespace App\Controller;

use App\Entity\TypeStock;
use App\Form\TypeStockType;
use App\Repository\TypeStockRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/type/stock')]
class TypeStockController extends AbstractController
{
    #[Route('/', name: 'app_type_stock_index', methods: ['GET'])]
    public function index(TypeStockRepository $typeStockRepository): Response
    {
        return $this->render('type_stock/index.html.twig', [
            'type_stocks' => $typeStockRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_type_stock_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TypeStockRepository $typeStockRepository): Response
    {
        $typeStock = new TypeStock();
        $form = $this->createForm(TypeStockType::class, $typeStock);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $typeStockRepository->add($typeStock, true);

            return $this->redirectToRoute('aapp_type_stock_new', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('type_stock/new.html.twig', [
            'type_stock' => $typeStock,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_type_stock_show', methods: ['GET'])]
    public function show(TypeStock $typeStock): Response
    {
        return $this->render('type_stock/show.html.twig', [
            'type_stock' => $typeStock,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_type_stock_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TypeStock $typeStock, TypeStockRepository $typeStockRepository): Response
    {
        $form = $this->createForm(TypeStockType::class, $typeStock);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $typeStockRepository->add($typeStock, true);

            return $this->redirectToRoute('app_type_stock_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('type_stock/edit.html.twig', [
            'type_stock' => $typeStock,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_type_stock_delete', methods: ['POST'])]
    public function delete(Request $request, TypeStock $typeStock, TypeStockRepository $typeStockRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeStock->getId(), $request->request->get('_token'))) {
            $typeStockRepository->remove($typeStock, true);
        }

        return $this->redirectToRoute('app_type_stock_index', [], Response::HTTP_SEE_OTHER);
    }
}

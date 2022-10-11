<?php

namespace App\Controller;

use App\Entity\Materiel;
use App\Entity\Stock;
use App\Entity\TypeStock;
use App\Form\ChoixMaterielType;
use App\Form\EtiquetteType;
use App\Form\StockType;
use App\Repository\HistoriqueStockRepository;
use App\Repository\StockRepository;
use App\Repository\TypeStockRepository;
use App\Service\StockService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/stock')]
class StockController extends AbstractController
{
    #[Route('/', name: 'app_stock_historique', methods: ['GET'])]
    public function index(HistoriqueStockRepository $hitoriqueRepo): Response
    {
        return $this->render('stock/index.html.twig', [
            'historiques' => $hitoriqueRepo->findAll(),
        ]);
    }
    #[Route('/nouveau', name: 'app_stock_choix', methods: ['GET', 'POST'])]
    public function choisir(Request $request): Response
    {
        
        $form = $this->createForm(ChoixMaterielType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            return $this->redirectToRoute('app_stock_materiel', ['idmat'=>$form->get('materiel')->getData()->getId()], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('stock/achat.html.twig', [
             'stock' => null, 
            'form' => $form,
           
        ]);
    }

    #[Route('/entree/{idmat}/materiel/', name: 'app_stock_materiel', methods: ['GET', 'POST'])]
    public function new(Request $request, StockRepository $stockRepository,TypeStockRepository $typeRip,ManagerRegistry $doctrine,StockService $stockServe): Response
    {
        $materiel= $doctrine
            ->getRepository(Materiel::class)
            ->find($request->get('idmat'));

        $stock = new Stock();
        $stock->setMateriel($materiel);

        if($materiel->getMateriel()=="Etiquette"){
            $form = $this->createForm(EtiquetteType::class, $stock);
            $autre = false;
        }
        else{
            $form = $this->createForm(StockType::class, $stock);
            $autre=true;
        }
       
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
        
            
            //traitement du stockage 
            $listeStock=$stockServe->traiterStock($stock,$form->all(),$autre,0);
            
            foreach ($listeStock as $stockage){
                 if($stockage instanceof Stock){
                    //définir le type de stockage en Entree
                    $stockage->setTypeStock($stockServe->getTypeStock(0));
                    //definir la date de stockage
                    $stockage->setDateStock(date_create(date("Y-m-d h:m:s")));
                    //insertion
                    $stockRepository->add($stockage, true);
                 }
            }
            return $this->redirectToRoute('app_stock_choix', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('stock/achat.html.twig', [
            'stock' => $stock,
            'form' => $form,
        ]);
    }

    /*     #[Route('/entree/{idmat}/etiquette/', name: 'app_stock_etiquette', methods: ['GET', 'POST'])]
    public function nouveau(Request $request, StockRepository $stockRepository,TypeStockRepository $typeRipo): Response
    {
        $stock = new Stock();
        $form = $this->createForm(EtiquetteType::class, $stock);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /* $stock->setSortie(0);
            $stock->setDateStock(date_create(date("H:i:s")));
            $typeStock = $typeRipo->findOneBy(['typeStock' => 'Entrée']);
            //dd($typeStock);
            $stock->setTypeStock($typeStock); */

            //définir le type de stockage en Entree
            // définir la date de stock
            //définir la sortie à 0 


    /*         $stockRepository->add($stock, true);

            return $this->redirectToRoute('app_stock_etiquette', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('stock/etiquette.html.twig', [
            'stock' => $stock,
            'form' => $form,
        ]);
    } */ 


    #[Route('/{id}', name: 'app_stock_show', methods: ['GET'])]
    public function show(Stock $stock): Response
    {
        return $this->render('stock/show.html.twig', [
            'stock' => $stock,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_stock_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Stock $stock, StockRepository $stockRepository): Response
    {
        $form = $this->createForm(StockType::class, $stock);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $stockRepository->add($stock, true);

            return $this->redirectToRoute('app_stock_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('stock/edit.html.twig', [
            'stock' => $stock,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_stock_delete', methods: ['POST'])]
    public function delete(Request $request, Stock $stock, StockRepository $stockRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$stock->getId(), $request->request->get('_token'))) {
            $stockRepository->remove($stock, true);
        }

        return $this->redirectToRoute('app_stock_index', [], Response::HTTP_SEE_OTHER);
    }
}

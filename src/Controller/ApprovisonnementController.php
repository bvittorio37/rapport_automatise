<?php

namespace App\Controller;

use App\Entity\Materiel;
use App\Entity\Site;
use App\Entity\Stock;
use App\Entity\StockSite;
use App\Form\ApprovisionEttiquetteType;
use App\Form\ApprovisionType;
use App\Form\ChoixApprovisionnementType;
use App\Repository\StockRepository;
use App\Repository\StockSiteRepository;
use App\Repository\TypeStockRepository;
use App\Service\ApproSiteService;
use App\Service\StockService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/approvisonnement')]
class ApprovisonnementController extends AbstractController
{
    #[Route('/', name: 'app_approvisonnement')]
    public function index(Request $request): Response
    {
       
        $form = $this->createForm(ChoixApprovisionnementType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            return $this->redirectToRoute('app_approvisionnement_site', 
                ['idmat'=>$form->get('materiel')->getData()->getId()
                ,'idsite'=>$form->get('site')->getData()->getId()
            ], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('approvisonnement/approvisionnement.html.twig', [
            'stock' => null,
            'form' => $form,
        ]);
    }
    #[Route('/{idsite}/{idmat}/site/', name: 'app_approvisionnement_site', methods: ['GET', 'POST'])]
    public function new(Request $request, StockRepository $stockRepository, StockSiteRepository $approRep,ManagerRegistry $doctrine,StockService $stockServe
            ,ApproSiteService $approService): Response
    {
        $materiel= $doctrine
            ->getRepository(Materiel::class)
            ->find($request->get('idmat'));

        $site= $doctrine
            ->getRepository(Site::class)
            ->find($request->get('idsite'));

        $stockSite = new StockSite();
        $stockSite->setMateriel($materiel);
        $stockSite->setSite($site);

        if($materiel->getMateriel()=="Etiquette"){
            
            $form = $this->createForm(ApprovisionEttiquetteType::class,$stockSite);
            $autre = false;
        }
        else{
            $form = $this->createForm(ApprovisionType::class, $stockSite);
            $autre=true;
        }
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Traitement de l'approvisionnement
            $approSite= $approService->traitementApprovisionnement($stockSite,$form->all(),$autre,0);
            
            $approRep->add($approSite,true);
           
            //Faire une sortie de stock dans le magasin
            $stock = new Stock();
            $stock->setMateriel($materiel);
            $listeStock=$stockServe->traiterStock($stock,$form->all(),$autre,1);
            $stockage=$listeStock[0];
            
            if($stockage instanceof Stock){
                //définir le type de stockage en Entree
                $stockage->setTypeStock($stockServe->getTypeStock(1));
                //insertion
                $stockRepository->add($stockage, true);
            }     
           
            // Approvisionner les sites
           
 

            return $this->redirectToRoute('app_approvisonnement', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('approvisonnement/approvisionnement.html.twig', [
           'stock'=> $stockSite,
            'form' => $form,
        ]);
    }

}

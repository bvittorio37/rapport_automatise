<?php

namespace App\Controller;

use App\Entity\Emballage;
use App\Entity\Materiel;
use App\Entity\Unite;
use App\Entity\UniteMateriel;
use App\Form\ChoixMaterielType;
use App\Form\MaterielType;
use App\Repository\CategorieMaterielRepository;
use App\Repository\MaterielRepository;
use App\Repository\UniteRepository;
use App\Service\TypageService;
use App\Service\TypepageService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/materiel')]
class MaterielController extends AbstractController
{
    #[Route('/', name: 'app_materiel_index', methods: ['GET'])]
    public function index( CategorieMaterielRepository $catRepo ): Response
    {
        
        return $this->render('materiel/index.html.twig', [
            'categories' => $catRepo->findAll(),
        ]);
    }

    #[Route('/nouveau', name: 'app_materiel_nouveau', methods: ['GET', 'POST'])]
    public function new(Request $request, MaterielRepository $materielRepository,UniteRepository $uniteRepo,TypageService $typeServe): Response
    {
        $materiel = new Materiel();
        /// Initialisation de l'unite primaire du materiel
        $unitePrimaire = new UniteMateriel();
        $unitePrimaire->setTypeUnite($typeServe->getUnitePrimaireType());
        $unitePrimaire->setQunatite(1);
        $materiel->addUniteMateriel($unitePrimaire);


        //initialisation de l'emballage du materiel
        $emballage = new UniteMateriel();
        $emballage->setUnite($typeServe->getUniteCarton());
        $emballage->setTypeUnite($typeServe->getEmballageType());
        $materiel->addUniteMateriel($emballage);

        
        $form = $this->createForm(MaterielType::class, $materiel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $materielRepository->add($materiel, true);
            return $this->redirectToRoute('app_materiel_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('materiel/new.html.twig', [
            'materiel' => $materiel,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_materiel_show', methods: ['GET'])]
    public function show(Materiel $materiel): Response
    {
        return $this->render('materiel/show.html.twig', [
            'materiel' => $materiel,
        ]);
    }

    #[Route('/{id}/modiffier', name: 'app_materiel_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request,Materiel $materiel, MaterielRepository $materielRepository,UniteRepository $uniteRepo,TypageService $typeServe): Response
    {
       
        $form = $this->createForm(MaterielType::class, $materiel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $materielRepository->add($materiel, true);
            return $this->redirectToRoute('app_materiel_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('materiel/edit.html.twig', [
            'materiel' => $materiel,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_materiel_delete', methods: ['POST'])]
    public function delete(Request $request, Materiel $materiel, MaterielRepository $materielRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$materiel->getId(), $request->request->get('_token'))) {
            $materielRepository->remove($materiel, true);
        }

        return $this->redirectToRoute('app_materiel_index', [], Response::HTTP_SEE_OTHER);
    }
}

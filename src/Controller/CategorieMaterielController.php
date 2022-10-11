<?php

namespace App\Controller;

use App\Entity\CategorieMateriel;
use App\Form\CategorieMaterielType;
use App\Repository\CategorieMaterielRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/categorie/materiel')]
class CategorieMaterielController extends AbstractController
{
    /* #[Route('/', name: 'app_categorie_materiel_index', methods: ['GET'])]
    public function index(CategorieMaterielRepository $categorieMaterielRepository): Response
    {
        return $this->render('categorie_materiel/index.html.twig', [
            'categorie_materiels' => $categorieMaterielRepository->findAll(),
        ]);
    } */

    #[Route('/new', name: 'app_categorie_materiel_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CategorieMaterielRepository $categorieMaterielRepository): Response
    {
        $categorieMateriel = new CategorieMateriel();
        $form = $this->createForm(CategorieMaterielType::class, $categorieMateriel);
        $form->handleRequest($request); 

        if ($form->isSubmitted() && $form->isValid()) {
            $categorieMaterielRepository->add($categorieMateriel, true);

            return $this->redirectToRoute('app_categorie_materiel_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('categorie_materiel/new.html.twig', [
            'categorie_materiel' => $categorieMateriel,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_categorie_materiel_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CategorieMateriel $categorieMateriel, CategorieMaterielRepository $categorieMaterielRepository): Response
    {
        $form = $this->createForm(CategorieMaterielType::class, $categorieMateriel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categorieMaterielRepository->add($categorieMateriel, true);

            return $this->redirectToRoute('app_categorie_materiel_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('categorie_materiel/edit.html.twig', [
            'categorie_materiel' => $categorieMateriel,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_categorie_materiel_delete', methods: ['POST'])]
    public function delete(Request $request, CategorieMateriel $categorieMateriel, CategorieMaterielRepository $categorieMaterielRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categorieMateriel->getId(), $request->request->get('_token'))) {
            $categorieMaterielRepository->remove($categorieMateriel, true);
        }

        return $this->redirectToRoute('app_categorie_materiel_index', [], Response::HTTP_SEE_OTHER);
    }
}

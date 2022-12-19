<?php

namespace App\Controller;

use App\Entity\Paf;
use App\Entity\Site;
use App\Form\PafType;
use App\Form\SiteType;
use App\Repository\PafRepository;
use App\Repository\SiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/site')]
class SiteController extends AbstractController
{
    #[Route('/', name: 'app_site_index', methods: ['GET'])]
    public function index(SiteRepository $siteRepository): Response
    {
        return $this->render('site/index.html.twig', [
            'sites' => $siteRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_site_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SiteRepository $siteRepository): Response
    {
        $site = new Site();
        $form = $this->createForm(SiteType::class, $site);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $siteRepository->add($site, true);

            return $this->redirectToRoute('app_site_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('site/new.html.twig', [
            'site' => $site,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_site_show', methods: ['GET', 'POST'])]
    public function show(Request $request,Site $site, PafRepository  $pafRepository): Response
    {
        $paf = new Paf();
        $paf->setSite($site);
        $form = $this->createForm(PafType::class, $paf);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pafRepository->add($paf, true);
            return $this->redirectToRoute('app_site_show', ['id'=>$site->getId()], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('site/show.html.twig', [
            'paf' => $paf,
            'form' => $form,
            'site' => $site,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_site_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Site $site, SiteRepository $siteRepository): Response
    {
        $form = $this->createForm(SiteType::class, $site);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $siteRepository->add($site, true);

            return $this->redirectToRoute('app_site_edit', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('site/edit.html.twig', [
            'site' => $site,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_site_delete', methods: ['POST'])]
    public function delete(Request $request, Site $site, SiteRepository $siteRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$site->getId(), $request->request->get('_token'))) {
            $siteRepository->remove($site, true);
        }

        return $this->redirectToRoute('app_site_index', [], Response::HTTP_SEE_OTHER);
    }
}

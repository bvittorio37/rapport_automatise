<?php

namespace App\Controller;

use App\Entity\HistoriqueAffectation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use App\Form\AffectationType;
use App\Form\UserType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Form\RegistrationFormType;
use App\Repository\HistoriqueAffectationRepository;
use App\Security\AuthentificationAuthenticator;
use App\Service\UtilisateurService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

#[Route('/utilisateurs')]
class UtlisisateurController extends AbstractController
{
    #[Route('/', name: 'app_utilisateur', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('utlisisateur/index.html.twig', [
            'utilisateurs' => $userRepository->findAll(),
        ]
    );
    }

    #[Route('/ajout', name: 'utilisateur.ajout')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, AuthentificationAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setEtat(false);
            $user->setPassword(
            $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email
            return $this->redirectToRoute('app_utilisateur');
           /* return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );*/

        }

        return $this->render('Utlisisateur/ajout.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
    #[Route('/{id}/affecter', name: 'utilisateur.affecter', methods: ['GET', 'POST'])]
    public function affecter(Request $request, User $user, UserRepository $userRepository, HistoriqueAffectationRepository $histoRipo): Response
    {
        $form = $this->createForm(AffectationType::class, $user);
        $form->handleRequest($request);
        $ancienSite= $user->getSite();
        
        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->add($user, true);
            $historique = new HistoriqueAffectation();
            $historique->setNom($user->getNoms());
            $historique->setPrenom($user->getPrenoms());
            $historique->setAncienSite($ancienSite);
            $historique->setSiteAffectation($user->getSite());
            $historique->setDateAffectation(date_create(date("H:i:s")));
            $historique->setIsCourant(true);
            $histoRipo->add($historique,true);
            return $this->redirectToRoute('app_utilisateur', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Utlisisateur/affectation.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    
    }
    
    #[Route('/{id}/activer', name: 'utilisateur.activer', methods: ['GET', 'POST'], options: ['expose' => true])]
    public function activer( Request $request, User $user, UserRepository $userRepository, UtilisateurService $utiServe): Response
    {
        if ($request->isXmlHttpRequest()|| $request->query->get('showJson') == 1) {
            $retour= $utiServe->activation($user);     
            return new JsonResponse($retour); 
        }  
        return $this->redirectToRoute('app_utilisateur', [], Response::HTTP_SEE_OTHER);
    }
    

    #[Route('/{id}/editer', name: 'utilisateur.editer', methods: ['GET', 'POST'])]
    public function edit(Request $request,UserPasswordHasherInterface $userPasswordHasher, User $user, UserRepository $userRepository): Response
    {

        $user->setPassword(" ");
        $form = $this->createForm(UserType::class, $user);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
            $userPasswordHasher->hashPassword( $user,$user->getPassword()) );
            $userRepository->add($user, true);

            return $this->redirectToRoute('app_utilisateur', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    
    }

    /*
    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    

    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }*/
}


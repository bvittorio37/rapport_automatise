<?php

namespace App\Controller;

use App\Entity\Mail;
use App\Form\MailType;
use App\Repository\MailRepository;
use App\Repository\RapportRepository;
use App\Service\MailService;
use App\Service\PdfService;
use App\Service\RapportService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

#[Route('/mail')]
class MailController extends AbstractController
{
    #[Route('/', name: 'app_mail_index', methods: ['GET'])]
    public function index(MailRepository $mailRepository): Response
    {
        return $this->render('mail/index.html.twig', [
            'mails' => $mailRepository->findAll(),
        ]);
    }

    #[Route('/{id}/{nompdf}/new', name: 'app_mail_new', methods: ['GET', 'POST'])]
    public function new(Request $request,MailService $mailServe, MailRepository $mailRepository,RapportService $rapportServe,MailerInterface $mailer,RapportRepository $rapRepos,PdfService $pdfServe): Response
    {
        $idRapport = $request->get('id');
        $nompdf = $request->get('nompdf');
        $rapport=$rapRepos->find($idRapport);
        $html= $this->render('depart/show.html.twig', ['rapport' => $rapport]);
        $pdf=$pdfServe->genererPdf($html);
        $mail = new Mail();
        $subject = str_replace('-',' ',$nompdf);
        $mail->setObject($subject);
        $form = $this->createForm(MailType::class, $mail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $to=$mailServe->getMailsTo($mail->getDepartement());
         
            $cc= $mailServe->getMailsCc($mail->getCc());
            $email = (new Email())
                ->from($rapport->getUtilisateur()->getEmail())
                ->to(...$to)
                ->cc(...$cc)
                ->subject($mail->getObject())
                ->text($mail->getMessage())
                ->attach($pdf,sprintf('%s.pdf', $nompdf) , 'application/pdf');
            try{
                $mailer->send($email);
            }
            
            catch(TransportExceptionInterface $e){
               dd($e->getMessage()); 
            }
            
          /*$mailRepository->add($mail, true);*/
            return $this->redirectToRoute('app_mail_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('mail/new.html.twig', [
            'mail' => $mail,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_mail_show', methods: ['GET'])]
    public function show(Mail $mail): Response
    {        
        return $this->render('mail/show.html.twig', [
            'mail' => $mail,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_mail_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Mail $mail, MailRepository $mailRepository): Response
    {
        $form = $this->createForm(MailType::class, $mail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mailRepository->add($mail, true);

            return $this->redirectToRoute('app_mail_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('mail/edit.html.twig', [
            'mail' => $mail,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_mail_delete', methods: ['POST'])]
    public function delete(Request $request, Mail $mail, MailRepository $mailRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$mail->getId(), $request->request->get('_token'))) {
            $mailRepository->remove($mail, true);
        }
        return $this->redirectToRoute('app_mail_index', [], Response::HTTP_SEE_OTHER);
    }
}

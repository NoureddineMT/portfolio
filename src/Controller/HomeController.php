<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Project;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(
        Request $request,
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator,
        MailerInterface $mailer
    ): Response {

        $projects = $entityManager->getRepository(Project::class)->findAll();


        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        // Variabile per controllare la visualizzazione del form
        $formSent = false;

        if ($form->isSubmitted() && $form->isValid()) {
            $existingContact = $entityManager->getRepository(Contact::class)->findOneByEmailWithin24Hours($contact->getEmail());

            if ($existingContact) {
                $this->addFlash(
                    'error',
                    'Vous avez déjà envoyé un message au cours des dernières 24 heures. Veuillez réessayer plus tard.'
                );
            } else {
                $contact->setDate(new \DateTime());
                $entityManager->persist($contact);
                $entityManager->flush();

                // Aggiorniamo la variabile per indicare che il form è stato inviato
                $formSent = true;

                $this->addFlash(
                    'success',
                    'Votre message a bien été envoyé'
                );

                $email = (new TemplatedEmail())
                    ->from($this->getParameter('app.mailAddress'))
                    ->to($this->getParameter('app.mailAddress'))
                    ->cc($contact->getEmail())
                    ->subject($contact->getObject())
                    ->htmlTemplate('emails/contact.html.twig')
                    ->context([
                        'firstName' => $contact->getFirstName(),
                        'lastName' => $contact->getLastName(),
                        'contactEmail' => $contact->getEmail(),
                        'object' => $contact->getObject(),
                        'message' => $contact->getMessage(),
                    ]);

                $mailer->send($email);

                // Redirect per evitare l'invio multiplo ricaricando la pagina
                return $this->redirectToRoute('app_home');
            }
        }

        return $this->render('home/index.html.twig', [
            'contactForm' => $form->createView(),
            'formSent' => $formSent, 
            'projects'=>$projects,
        ]);
    }

}
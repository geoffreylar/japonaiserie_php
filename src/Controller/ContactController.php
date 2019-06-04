<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Mail\GestionMail;
use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Cocur\Slugify\Slugify; 

class ContactController extends AbstractController
{
        /**
     * @Route("/contact", name="contact")
     * @return Response
     */
    public function mail(Request $request, GestionMail $gest): Response
    {

        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        /*if ($produit->getSlug() !== $slug){
            return $this->redirectToRoute('control.show.html.twig', [
                'id' => $produit->getId(),
                'slug' => $produit->getSlug()
            ],301);
        }*/

        if ($form->isSubmitted() && $form->isValid())
        {
            $gest->envoie($contact);
            $this->addFlash('success', 'mail envoyé');
            return $this->redirectToRoute('contact/contact.html.twig', [
                'slug' => $produit->getSlug()
            ]);
        }
    
        return $this->render('contact/contact.html.twig', [ 
            'form' => $form->createView() 
        ]);
    }
}
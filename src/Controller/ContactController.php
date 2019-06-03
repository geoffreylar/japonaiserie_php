<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
        /**
     * @Route("/contact", name="contact")
     * @return Response
     */
    public function mail(): Response
    {

        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);

        /*if ($produit->getSlug() !== $slug){
            return $this->redirectToRoute('control.show.html.twig', [
                'id' => $produit->getId(),
                'slug' => $produit->getSlug()
            ],301);
        }*/
    
        return $this->render('contact/contact.html.twig', [ 
            'form' => $form->createView() 
        ]);
    }
}
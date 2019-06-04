<?php

namespace App\Mail;

use App\Entity\Contact;
use Twig\Environment;

class GestionMail
{

    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var Environment
     */
    private $rendu;

    public function __çonstruct(\Swift_Mailer $mailer, Environment $rendu)
    {
        $this->mailer = $mailer;
        $this->rendu = $rendu;
    }

    public function envoie(Contact $contact)
    {
        $message = (new \Swift_Mailer($contact->getContact()->getObjet() ))
        ->setFrom($contact->getMail())
        ->setTo('recipient@example.com')
        ->setBody(
            $this->rendu(
                'contact/email.html.twig',
                ['contact' => $contact]
        ),
        'text/html'
    );  

    $this->$mailer->send($message);

    }
}
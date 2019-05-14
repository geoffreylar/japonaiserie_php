<?php

namespace App\Controller\Admin;

use App\Entity\Produit;
use App\Form\ProduitType;
use App\Controller\Admin\Property;
use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminProduitController extends AbstractController
{
    /**
     * @var ProduitRepository 
     */
    private $repository;

    /**
     * @var ObjectManager
     */
    private $em;
    
    public function __construct(ProduitRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/admin", name="admin.produit.prodindex")
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function prodindex()
    {
        $produit = $this->repository-> findAll(); 

        return $this->render('admin/produit/prodindex.html.twig', compact('produit'));
    }

    //Fonction de création de produit

    /**
     * @Route("/admin/produit/prodcreate", name="admin.produit.prodcreate")
     */
    public function prodcreate(Request $request)
    {
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->em->persist($produit);
            $this->em->flush();
            $this->addFlash('sucess', 'Le bien à été créé');
            return $this->redirectToRoute('admin.produit.prodindex');
        }

        return $this->render('admin/produit/prodcreate.html.twig', [ 
        'produit' => $produit,
        'form' => $form->createView()
        ]);
    }

    //Fonction d'édition de produit

    /**
     * @Route("/admin/produit/{id}", name="admin.produit.prodedit", methods="GET|POST")
     */
    public function prodedit(Produit $produit, Request $request)
    { 
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->em->flush();
            $this->addFlash('sucess', 'Le bien à été modifié');
            return $this->redirectToRoute('admin.produit.prodindex');
        }

        return $this->render('admin/produit/prodedit.html.twig', [ 
        'produit' => $produit,
        'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/produit/{id}", name="admin.produit.proddelete", methods="DELETE")
     */
    public function proddelete(Produit $produit, Request $request)
    {
        if ($this->isCsrfTokenValid('delete'.$produit->getId(), $request->get('token_delete'))){
            $this->em->remove($produit);
            $this->em->flush();
            $this->addFlash('sucess', 'Le bien à été supprimé');
        }
        return $this->redirectToRoute('admin.produit.prodindex');
    }
}
 
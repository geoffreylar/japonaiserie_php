<?php

namespace App\Controller;

use App\Entity\Produit;
use Cocur\Slugify\Slugify; 
use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ControlController extends AbstractController
{
    /**
     * @var ProduitRepository
     */
    private $repository;
    
    public function __construct(ProduitRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/control", name="control.action")
     * @return Response
     */
    public function action(): Response{
    {

        $properties = $this->repository-> findAll(); 

        return $this->render('control/page.html.twig'
            , ['properties' => $properties ]);
    }
    }


    /**
     * @Route("/control/{slug}-{id}", name="control.show", requirements={"slug": "[a-z0-9\-]*"})
     * @param Property $property, string $slug
     * @return Response
     */
    public function show(Produit $produit, string $slug): Response{
        {
            if ($produit->getSlug() !== $slug){
                return $this->redirectToRoute('control.show.html.twig', [
                    'id' => $produit->getId(),
                    'slug' => $produit->getSlug()
                ],301);
            }
    
            return $this->render('control/show.html.twig'
                , ['properties' => $produit ]);
        }
    }
}

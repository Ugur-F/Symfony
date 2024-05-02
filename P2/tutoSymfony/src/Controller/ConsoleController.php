<?php

namespace App\Controller;

use App\Entity\Console;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConsoleController extends AbstractController
{
    #[Route('/console/{id}', name: 'app_console')]
    public function index(EntityManagerInterface $entityManager, int $id): Response
    {

        $product = $entityManager->GetRepository(Console::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException('Produit non trouvé'. $id);    
        }

        return $this->render('console/index.html.twig', [
            'controller_name' => 'ConsoleController',
            'name' => $product->GetName(),
        ]);
    }

    #[Route('/add-console', name: 'create_console')]
    public function createConsole(EntityManagerInterface $entityManager): Response
    {
        $product = new Console();
        $product->setName('Playstation5');
        $product->setSlug('Console-ps5');
        $product->setSubtitle('Lorem ipsum, dolor sit amet consectetur adipisicing elit.');
        $product->setDescription('Lorem ipsum, dolor sit amet consectetur adipisicing elit.');
        $product->setImage('ps5d500.png');
        $product->setVideo('e2T1s1X6f8k');
        $product->setLink('https://www.playstation.com/fr-be/ps5/');

        
        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($product);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new product with id '.$product->getId());

    }
}

<?php

namespace App\Controller;

use App\Entity\Strip;
use App\Repository\StripRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RandomStripController extends AbstractController
{
    private function getRandomStrip(): Strip
    {
        // Récupere tous les Strips du Repository
        $allStrips = $this->stripRepository->findAll();
        
        // Créé un tableau pour stocker les Strips
        $stripArray = [];
        
        // Utilisez une boucle foreach pour ajouter chaque Strip au tableau
        foreach($allStrips as $strip) {
            $stripArray[] = $strip;
        }
        
        // Générez un nombre aléatoire entre  0 et la longueur du tableau
        $randomIndex = array_rand($stripArray);
        
        // Retournez le Strip aléatoire
        return $stripArray[$randomIndex];
    }

    private StripRepository $stripRepository;

    public function __construct(StripRepository $stripRepository)
    {
        $this->stripRepository = $stripRepository;
    }

    #[Route('/strips/random', name: 'app_random_strip')]
    public function index(): Response
    {
        $randomStrip = $this->getRandomStrip();
        return $this->render('random_strip/index.html.twig', [
            'controller_name' => 'RandomStripController',
            'RandomStrip' => $randomStrip
        ]);
    }

}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Property;

class RandomPropertiesController extends AbstractController
{
    #[Route('/randomProperties', name: 'randomProperties', methods: ['POST'])]
    public function __invoke(EntityManagerInterface $entityManager): Response
    {
        $i = 0;
        $words = ["House", "Apartment", "Condo", "Villa", "Mansion", "Cottage", "Bungalow", "Studio", "Townhouse", "Loft", "Duplex", "Penthouse"];
        $adjectives = ["Beautiful", "Spacious", "Cozy", "Modern", "Luxury", "Charming", "Elegant", "Sunny", "Quiet", "Central"];

        while($i < 5)
        {
            $p = new Property();
            $p->setPrice(rand(2500, 99999));

            $randomName = $adjectives[array_rand($adjectives)] . " " . $words[array_rand($words)] . " " . rand(1, 999);
            $p->setName($randomName);

            $entityManager->persist($p);
            $i++;
        }
        $entityManager->flush();
        return new JsonResponse(['status' => 'Properties generated'], Response::HTTP_CREATED);
    }
}

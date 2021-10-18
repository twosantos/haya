<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Property;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index()
    {
        return $this->render('home/index.html.twig', [
        ]);
    }

    /**
     * @Route("/randomProperties", name="randomProperties")
     */
    public function randomProperties()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $i = 0;
        while($i < 5)
        {
            $p = new Property();
            $p->setPrice(rand(2500, 99999));
            $p->setName(substr(file_get_contents("https://loripsum.net/generate.php?p=1&l=short"), 59, 75));
            $entityManager->persist($p);
            $i++;
        }
        $entityManager->flush();
        return new Response();
    }
}

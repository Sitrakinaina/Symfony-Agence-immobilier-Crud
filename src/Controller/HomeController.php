<?php

namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(PropertyRepository $repo, EntityManagerInterface $em): Response
    {

        // for ($i = 0; $i <= 10; $i++) {
        //     $property = new Property();
        //     $property->setTitle("Bien numero  $i")
        //         ->setDescription("description du bien numero $i")
        //         ->setSurface(rand(1000, 9000))
        //         ->setRooms(rand(1, 5))
        //         ->setBedrooms(rand(1, 5))
        //         ->setFloor(rand(1, 7))
        //         ->setPrice(rand(5000, 1000))
        //         ->setHeat(1)
        //         ->setCity("city numero $i")
        //         ->setAddress("adresse")
        //         ->setPostalCode(101)
        //         ->setImage("https://blog.hubspot.fr/hs-fs/hubfs/media/marketingimmobilier.jpeg?width=610&height=406&name=marketingimmobilier.jpeg");
        //     $em->persist($property);

        //     $em->flush();
        // }
        $properties = $repo->findAll();




        return $this->render('home/index.html.twig', [
            'properties' => $properties,
            // 'helloController' => 'helloController',
        ]);
    }
    #[Route('/biens/{id}', name: "property.show")]
    public function show(PropertyRepository $repo, int $id): Response
    {
        $property = $repo->find($id);
        return $this->render('home/show.html.twig', [
            'property' => $property
        ]);
    }
}

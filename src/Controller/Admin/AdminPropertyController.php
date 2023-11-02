<?php

namespace App\Controller\Admin;

use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;

class AdminPropertyController extends AbstractController
{
    private $repo;
    private $em;
    public function __construct(PropertyRepository $repo, EntityManagerInterface $em)
    {
        $this->repo  = $repo;
        $this->em = $em;
    }

    #[Route('/admin/index', name: 'app.admin.index')]

    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $properties = $paginator->paginate(
            $this->repo->findAllVisible(),
            $request->query->getInt('page', 1),
            5
        );
        return $this->render('admin/index.html.twig', [

            "properties" => $properties
        ]);
    }

    #[Route('/admin/create ', name: 'app.admin.create')]

    public function create(Request $request): Response
    {
        $property = new Property();
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $property = $form->getData();
            $this->em->persist($property);
            $this->em->flush();
            $this->addFlash('success', 'creation de nouveau bien reussi');
            return $this->redirectToRoute('app.admin.index');
        }
        return $this->render('admin/create.html.twig', [
            'form' => $form
        ]);
    }
    /*
    *@params Property $property
    */
    #[Route('admin/edit/{id}', name: 'app.admin.edit')]
    public function edit(Property $property, Request $request): Response
    {
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success', 'modification du bien reussi');
            return $this->redirectToRoute('app.admin.index');
        }
        return $this->render('admin/edit.html.twig', [
            'form' => $form
        ]);
    }
    /*
    *@params Property $property
    */
    #[Route('admin/delete/{id}', name: 'app.admin.delete')]
    public function remove(Property $property, Request $request): Response
    {
        if ($this->isCsrfTokenValid('delete' . $property->getId(), $request->get('_token'))) {
            $this->em->remove($property);
            $this->em->flush();
            $this->addFlash('success', 'suppression reussi');
            return $this->redirectToRoute('app.admin.index');
        }
    }
}

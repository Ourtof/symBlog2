<?php

namespace App\Controller;

use App\Entity\Ingredient;
use App\Form\IngredientType;
use App\Repository\IngredientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IngredientController extends AbstractController
{

    public function __construct(private IngredientRepository $ingredientRepository)
    {
    }


    #[Route('/ingredient', name: 'ingredient.index')]
    public function index(): Response
    {
        return $this->render('ingredient/index.html.twig', [
            'controller_name' => 'IngredientController',
        ]);
    }

    #[Route('/ingredient/nouvel-ingredient', name: 'ingredient.create')]
    public function create(Request $request): Response
    {

        // 1 - créer un formulaire : OK 
        // 2 - afficher ce formulaire : OK
        // 3 - récupérer les informations de ce formulaire : OK
        // 4 - envoyer les informations dans la bdd : OK
        // 5 - envoyer l'utilisateur sur la page d'index

        $newIngredient = new Ingredient;

        $form = $this->createForm(IngredientType::class, $newIngredient);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $entity = $form->getData();

            $this->ingredientRepository->save($entity, true);

            return $this->redirectToRoute('ingredient.index');
        }


        return $this->render('ingredient/create.html.twig', [
            "form" => $form->createView()]);
    }
}

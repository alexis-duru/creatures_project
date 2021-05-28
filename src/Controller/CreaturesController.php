<?php

namespace App\Controller;

use App\Entity\Creature;
use App\Form\EditCreatureType;
use App\Repository\CreatureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreaturesController extends AbstractController
{
    /**
     * @Route("/creatures", name="app_creatures")
     */
    public function creature(CreatureRepository $CreatureRepository): Response
    {
        $creatures = $CreatureRepository->findAll();

        return $this->render('creatures/index.html.twig', [
            'creatures' => $creatures,
        ]);
    }

    /**
     * @Route("/creatures/{id<\d+>}", name="app_creatures_single")
     *
     * @param mixed $id
     */
    public function find(CreatureRepository $CreatureRepository, $id): Response
    {
        $creature = $CreatureRepository->find($id);

        return $this->render('creatures/single.html.twig', [
            'creature' => $creature,
        ]);
    }

    ////// FORMULAIRE //////

    /**
     * @Route("/creature/add", name="app_creature_add")
     * @Route("/creature/edit/{id}", name="app_creature_edit")
     */
    public function editEntity(Creature $creature = null, Request $request, EntityManagerInterface $entityManager): Response
    {
        if (!$creature) {
            $creature = new Creature();
        }
        $form = $this->createForm(EditCreatureType::class, $creature);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($creature);
            $entityManager->flush();

            // $this->addFlash('success', 'Your __entity__ has been created successfully.');

            return $this->redirectToRoute('app_creatures');
        }

        //PERMET DE CRER LA VUE DU FORMULAIRE//
        return $this->render('creatures/single-edit.html.twig', [
            'creature' => $creature,
            'form' => $form->createView(),
            'isModification' => null !== $creature->getId(),
        ]);
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Place;
use App\Form\PlaceType;

/**
* @Route("/{_locale}")
*/
class PlaceController extends AbstractController
{
    /**
     * Liste tout les villes
     * @Route("/place", name="place.list")
     * @return Response
     */
    public function list(EntityManagerInterface $em) : Response
    {
    	$places = $this->getDoctrine()->getRepository(Place::class)->findAll();

    	return $this->render('place/list.html.twig',array(
    		'places'=>$places)
    	);
    }

    /**
	* Chercher et afficher une ville.
	* @Route("/place/{id}", name="place.show", requirements={"id" = "\d+"})
	* @param Place $place
	* @return Response
	*/
	public function show(Place $place) : Response
	{
		return $this->render('place/show.html.twig', [
		'place' => $place,
		]);
	}

	/**
	* Créer une nouvelle ville.
	* @Route("/new-place", name="place.create")
	* @param Request $request
	* @param EntityManagerInterface $em
	* @return RedirectResponse|Response
	*/
	public function create(Request $request, EntityManagerInterface $em) : Response
	{
		$place = new Place();
		$form = $this->createForm(PlaceType::class, $place);
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			$em->persist($place);
			$em->flush();
			return $this->redirectToRoute('place.list');
		}
		return $this->render('place/create.html.twig', [
		'form' => $form->createView(),
		]);
	}

	/**
	* Éditer une ville.
	* @Route("/place/{id}/edit", name="place.edit", requirements={"id" = "\d+"})
	* @param Request $request
	* @param EntityManagerInterface $em
	* @return RedirectResponse|Response
	*/
	public function edit(Request $request, Place $place, EntityManagerInterface $em) : Response
	{
		$form = $this->createForm(PlaceType::class, $place);
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			$em->flush();
			return $this->redirectToRoute('place.list');
		}
		return $this->render('place/edit.html.twig', [
			'form' => $form->createView(),
		]);
	}
}

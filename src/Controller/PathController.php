<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\PathType;
use App\Form\CommentType;
use App\Entity\Path;
use App\Entity\User;
use App\Entity\Comment;
date_default_timezone_set("Europe/Paris");

/**
* @Route("/{_locale}")
*/
class PathController extends AbstractController
{

    /**
     * Liste tout les covoits
     * @Route("/path", name="path.list")
     * @return Response
     */
    public function list(EntityManagerInterface $em) : Response
    {
    	$query = $em->createQuery(
		'SELECT p FROM App:Path p WHERE p.dateTime > :date ORDER BY p.dateTime ASC'
		)->setParameter('date', new \DateTime('Europe/Paris'));
		$paths = $query->getResult();

    	return $this->render('path/list.html.twig',array(
    		'paths'=>$paths)
    	);
    }

     /**
     * Liste tout les covoits
     * @Route("/path/listUser", name="path.listUserPath")
     * @return Response
     */
    public function listUserPath(EntityManagerInterface $em) : Response
    {
    	$query = $em->createQuery(
		'SELECT p FROM App:Path p ORDER BY p.dateTime DESC');
		$paths = $query->getResult();

    	return $this->render('path/listUser.html.twig',array(
    		'paths'=>$paths)
    	);
    }

    /**
	* Chercher et afficher un covoit.
	* @Route("/path/{id}", name="path.show", requirements={"id" = "\d+"})
	* @param Path $path
	* @return Response
	*/
	public function show(Path $path, Request $request, EntityManagerInterface $em) : Response
	{
		$comment = new Comment();
		$passengers = $path->getPassenger();
		$form = $this->createForm(CommentType::class, $comment);
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			
			$data = $form->getData();
			$comment->setDateComment(new \DateTime('Europe/Paris'));
			$comment->setRide($path);
			$comment->setAuthor($user = $this->getUser());


			$path->addRideComment($comment);
			$user = $this->getUser();
			$user->addAuthorComment($comment);
			$em->persist($comment);
			$em->flush();
			return $this->redirect($request->getUri());
		}
		$query = $em->createQuery(
		'SELECT c FROM App:Comment c ORDER BY c.dateComment DESC'
		);
		$comments = $query->getResult();

		return $this->render('path/show.html.twig', [
		'path' => $path, 'form' => $form->createView(), 'comments'=>$comments, 'passengers' =>$passengers

		]);
	}


	/**
	* Créer un nouveau covoit.
	* @Route("/new-covoit", name="path.create")
	* @param Request $request
	* @param EntityManagerInterface $em
	* @return RedirectResponse|Response
	*/
	public function create(Request $request, EntityManagerInterface $em) : Response
	{
		$path = new Path();
		$form = $this->createForm(PathType::class, $path);
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			$path->setDriver($user = $this->getUser());
			$em->persist($path);
			$em->flush();
			return $this->redirectToRoute('path.listUserPath');
		}
		return $this->render('path/create.html.twig', [
		'form' => $form->createView(),
		]);
	}

	/**
	* Éditer un covoit.
	* @Route("/path/{id}/edit", name="path.edit", requirements={"id" = "\d+"})
	* @param Request $request
	* @param EntityManagerInterface $em
	* @return RedirectResponse|Response
	*/
	public function edit(Request $request, Path $path, EntityManagerInterface $em) : Response
	{
		$form = $this->createForm(PathType::class, $path);
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			$em->flush();
			return $this->redirectToRoute('path.listUserPath');
		}
		return $this->render('path/edit.html.twig', [
			'form' => $form->createView(),
		]);
	}

	/**
	* Supprimer un covoit.
	* @Route("/path/{id}/delete", name="path.delete", requirements={"id" = "\d+"})
	* @param Request $request
	* @param Path $path
	* @param EntityManagerInterface $em
	* @return Response
	*/
	public function delete(Request $request, Path $path, EntityManagerInterface $em) : Response
	{
		$form = $this->createForm(PathType::class, $path);
		$form->handleRequest($request);
		if ( ! $form->isSubmitted() || ! $form->isValid()) {
			return $this->render('path/delete.html.twig', [
			'path' => $path,
			'form' => $form->createView(),
			]);
		}
		$em = $this->getDoctrine()->getManager();
		$em->remove($path);
		$em->flush();
		return $this->redirectToRoute('path.listUserPath');
	}

	/**
	* Ajoute un passager à un covoit
	* @Route("/user/{id}/path", name="path.addPath", requirements={"id" = "\d+"})
	* @param Request $request
	* @param Path $path
	* @param EntityManagerInterface $em
	* @return RedirectResponse|Response
	*/
	public function addPath(Request $request, Path $path, EntityManagerInterface $em) : Response
	{
		$user = $this->getUser();
		$passengers = $path->getPassenger();
		$query = $em->createQuery(
		'SELECT p FROM App:Path p ORDER BY p.dateTime DESC');
		$paths = $query->getResult();

		$user->addPassengerPath($path);
		$path->addPassenger($user);
		$seats = $path->getSeats() - 1;
		$path->setSeats($seats);
		$em->persist($path);
		$em->persist($user);
		$em->flush();
		return $this->render('path/listPath.html.twig', [
			'user' => $user,
			'passengers' => $passengers,
			'path' => $path,
			'paths' => $paths,
		]);
	}

	 /**
    * Liste toutes les réservations
    * @Route("/path/listReservations", name="path.listReservations")
    * @return Response
    */
    public function listReservations(EntityManagerInterface $em) : Response
    {
    	$query = $em->createQuery(
		'SELECT p FROM App:Path p  ORDER BY p.dateTime DESC');
		$paths = $query->getResult();

    	return $this->render('path/listPath.html.twig', [
    		'paths' => $paths,
    	]);
    }

    /**
	* Supprimer une réservation.
	* @Route("/user/{id}/path/delete", name="path.deleteResa", requirements={"id" = "\d+"})
	* @param Request $request
	* @param Path $path
	* @param EntityManagerInterface $em
	* @return Response
	*/
	public function deleteReservation(Request $request, Path $path, EntityManagerInterface $em) : Response
	{
		$user = $this->getUser();

		$passengers = $path->getPassenger();
		$query = $em->createQuery(
		'SELECT p FROM App:Path p ORDER BY p.dateTime DESC');
		$paths = $query->getResult();

		$em = $this->getDoctrine()->getManager();		
		$path->removePassenger($user);
		$user->removePassengerPath($path);
		$seats = $path->getSeats() + 1;
		$path->setSeats($seats);
		$em->persist($path);
		$em->persist($user);
		$em->flush();

		return $this->render('path/listPath.html.twig', [
			'user' => $user,
			'passengers' => $passengers,
			'path' => $path,
			'paths' => $paths,
		]);
	}
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\CommentType;
use App\Entity\Path;
use App\Entity\User;
use App\Entity\Comment;

/**
* @Route("/{_locale}")
*/
class CommentController extends AbstractController
{
	/**
	* Supprimer un commentaire.
	* @Route("/comment/delete/{id}", name="comment.delete", requirements={"id" = "\d+"})
	* @param Request $request
	* @param Comment $comment
	* @param EntityManagerInterface $em
	* @return Response
	*/
	public function deleteComment(Request $request, Comment $comment, EntityManagerInterface $em) : Response
	{
		$path = $comment->getRide();
		$em = $this->getDoctrine()->getManager();		
		$path->removeRideComment($comment);
		$em->remove($comment);
		$em->flush();
		return $this->redirectToRoute('path.show', [
			'path' => $path,
			"id" => $path->getId(),

		]);
	}

	/**
	* Modifier un commentaire.
	* @Route("/comment/edit/{id}", name="comment.edit", requirements={"id" = "\d+"})
	* @param Request $request
	* @param Comment $comment
	* @param EntityManagerInterface $em
	* @return Response
	*/
	public function editComment(Request $request, Comment $comment, EntityManagerInterface $em) : Response
	{
		$path = $comment->getRide();
		$form = $this->createForm(CommentType::class, $comment);
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			$em->flush();
			return $this->redirectToRoute('path.show', [
				'path' => $path,
				"id" => $path->getId(),
			]);
			
		}
		return $this->render('comment/edit.html.twig', [
			'form' => $form->createView(),
			'path' => $path,
			"id" => $path->getId(),
		]);
	}
}

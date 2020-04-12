<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\UserType;
use App\Entity\Path;
use App\Entity\User;

/**
* @Route("/{_locale}")
*/
class UserController extends AbstractController
{
    /**
	* Créer un nouvel utilisateur.
	* @Route("/new-user", name="user.create")
	* @param Request $request
	* @param EntityManagerInterface $em
	* @return RedirectResponse|Response
	*/
	public function create(Request $request, EntityManagerInterface $em, UserPasswordEncoderInterface $encoder) : Response
	{
		$user = new User();
		$form = $this->createForm(UserType::class, $user);
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			
			$data = $form['password']->getData();

			$encoded = $encoder->encodePassword($user, $data);
    		$user->setPassword($encoded);
			$user->setTheme("white");
			
			$em->persist($user);
			$em->flush();
			return $this->redirectToRoute('homepage');
		}
		return $this->render('user/create.html.twig', [
		'form' => $form->createView(),
		]);
	}

	/**
	* Créer un nouvel utilisateur.
	* @Route("/new-userAdmin", name="user.createAdmin")
	* @param Request $request
	* @param EntityManagerInterface $em
	* @return RedirectResponse|Response
	*/
	public function createAdmin(Request $request, EntityManagerInterface $em, UserPasswordEncoderInterface $encoder) : Response
	{
		$user = new User();
		$form = $this->createForm(UserType::class, $user);
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			
			$data = $form['password']->getData();

			$encoded = $encoder->encodePassword($user, $data);
    		$user->setPassword($encoded);
			$user->setTheme("white");
			
			$em->persist($user);
			$em->flush();
			return $this->redirectToRoute('user.list');
		}
		return $this->render('user/createAdmin.html.twig', [
		'form' => $form->createView(),
		]);
	}

	/**
    * Liste tout les utilisateurs
    * @Route("/user", name="user.list")
    * @return Response
    */
    public function list(EntityManagerInterface $em) : Response
    {
    	$users = $this->getDoctrine()->getRepository(User::class)->findAll();

    	return $this->render('user/list.html.twig',array(
    		'users'=>$users)
    	);
    }

    /**
	* Supprimer un utilisateur.
	* @Route("/user/{id}/delete", name="user.delete", requirements={"id" = "\d+"})
	* @param Request $request
	* @param User $user
	* @param EntityManagerInterface $em
	* @return Response
	*/
	public function delete(Request $request, User $user, EntityManagerInterface $em) : Response
	{
		$form = $this->createForm(UserType::class, $user);
		$form->handleRequest($request);
		if ( ! $form->isSubmitted() || ! $form->isValid()) {
			return $this->render('user/delete.html.twig', [
			'user' => $user,
			'form' => $form->createView(),
			]);
		}
		$em = $this->getDoctrine()->getManager();
		$em->remove($user);
		$em->flush();
		return $this->redirectToRoute('user.list');
	}

	/**
	* Change de thème.
	* @Route("/user/{id}/white", name="user.theme.white", requirements={"id" = "\d+"})
	* @param Request $request
	* @param User $user
	* @param EntityManagerInterface $em
	* @return Response
	*/
	public function switchThemeWhite(Request $request, User $user, EntityManagerInterface $em) : Response
	{

		$user->setTheme("white");
		$em->flush();
		return $this->redirectToRoute('path.list');
	}

	/**
	* Change de thème.
	* @Route("/user/{id}/black", name="user.theme.black", requirements={"id" = "\d+"})
	* @param Request $request
	* @param User $user
	* @param EntityManagerInterface $em
	* @return Response
	*/
	public function switchThemeBlack(Request $request, User $user, EntityManagerInterface $em) : Response
	{

		$user->setTheme("black");
		$em->flush();
		return $this->redirectToRoute('path.list');
	}
	
	/**
	* Route par défaut
    * @Route("/", name="homepage")
    */
    public function indexAction()
    {
        return $this->render('connection.html.twig');
    }

	/**
	* Renvoi le formulaire de connexion
    * @Route("/", name="security.login")
    */
  /*  public function loginForm()
    {
        return $this->render(
            'security/login.html.twig'
        );
    }*/
}

<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(UserRepository $users): Response
    {
        return $this->render('home/index.html.twig', [
            'users' => $users->findAll(),
        ]);
    }
    #[Route('/details/{id}', name: 'app_user_detail')]
    public function detail(User $user): Response
    {

        return $this->render('home/details.html.twig', [
            'user' => $user,
        ]);
    }
}

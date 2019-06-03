<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="sec_login")
     */
    public function security_login()
    {
        return $this->render('security/login.html.twig', [
            'controller_name' => 'Login Security',
        ]);
    }

    /**
     * @Route("/register", name="sec_register")
     */
    public function security_register()
    {
        return $this->render('security/register.html.twig',[
            'controller_name' => 'Register Security'
        ]);
    }
}

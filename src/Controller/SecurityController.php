<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserRegistrationFormType;
use App\Security\LoginAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="sec_login")
     */
    public function security_login(AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    /**
     * @Route("/register", name="sec_register")
     */
    public function security_register(Request $request, UserPasswordEncoderInterface $encoder, GuardAuthenticatorHandler $guardHandler, LoginAuthenticator $loginAuthenticator)
    {
        $form = $this->createForm(UserRegistrationFormType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $data = $request->request->get('user_registration_form');
            $user = new User();
            $user->setEmail($data['email']);
            $user->setPassword($encoder->encodePassword($user, $data['password']));

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', "Account Registered Successfully!");
            return $guardHandler->authenticateUserAndHandleSuccess($user,$request,$loginAuthenticator, 'main');
        }

        return $this->render('security/register.html.twig',[
            'regForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/logout", name="sec_logout")
     */
    public function security_logout()
    {

    }

}

<?php
/**
 * Created by PhpStorm.
 * User: Xtrazyx
 * Date: 23/10/2017
 * Time: 16:04
 */

namespace App\Action;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Twig\Environment;

class LoginAction
{
    /**
     * @Route("/login", name="login")
     *
     * @param Environment $twig
     * @param RequestStack $requestStack
     * @param AuthenticationUtils $authUtils
     * @param Session $session
     *
     * @return Response
     */
    public function __invoke(
        Environment $twig,
        RequestStack $requestStack,
        AuthenticationUtils $authUtils,
        Session $session
    )
    {
        $error = $authUtils->getLastAuthenticationError();
        $lastUsername = $authUtils->getLastUsername();

        $content = $twig->render('login.html.twig', array(
            'error' => $error,
            'lastUsername' => $lastUsername
        ));

        $session->getFlashbag()->get('retrieve');

        return new Response($content);
    }
}

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
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Twig\Environment;

class LoginAction
{
    private $twig;
    private $request;
    private $authUtils;

    public function __construct(
        Environment $twig,
        RequestStack $requestStack,
        AuthenticationUtils $authenticationUtils
    )
    {
        $this->twig = $twig;
        $this->request = $requestStack->getCurrentRequest();
        $this->authUtils = $authenticationUtils;
    }

    /**
     * @Route("/login", name="login")
     */
    public function __invoke()
    {
        $error = $this->authUtils->getLastAuthenticationError();
        $lastUsername = $this->authUtils->getLastUsername();

        $content = $this->twig->render('login.html.twig', array(
            'error' => $error,
            'lastUsername' => $lastUsername
        ));
        return new Response($content);
    }
}
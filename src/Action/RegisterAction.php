<?php
/**
 * Created by PhpStorm.
 * User: Xtrazyx
 * Date: 23/10/2017
 * Time: 16:04
 */

namespace App\Action;

use App\Form\RegisterType;
use App\Manager\UserManager;
use App\Traits\RedirectTrait;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Twig\Environment;

class RegisterAction
{
    use RedirectTrait;

    private $twig;
    private $request;
    private $passwordEncoder;
    private $formFactory;
    private $userManager;
    private $router;

    public function __construct(
        Environment $twig,
        RequestStack $requestStack,
        UserPasswordEncoderInterface $passwordEncoder,
        FormFactory $formFactory,
        UserManager $userManager,
        Router $router
    )
    {
        $this->twig = $twig;
        $this->request = $requestStack->getCurrentRequest();
        $this->passwordEncoder = $passwordEncoder;
        $this->formFactory = $formFactory;
        $this->userManager = $userManager;
        $this->router = $router;
    }

    /**
     * @Route("/register", name="register")
     */
    public function __invoke()
    {
        $user = $this->userManager->new();
        $form = $this->formFactory->create(RegisterType::class, $user);

        $form->handleRequest($this->request);

        if($form->isSubmitted() && $form->isValid())
        {
            $password = $this->passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            $user->setRoles(array('ROLE_USER'));

            $this->userManager->persist($user);

            return $this->redirectToRoute('index');
        }

        return new Response($this->twig->render(
            'register.html.twig', array(
            'form' => $form->createView()
        )));
    }

    public function getRouter()
    {
        return $this->router;
    }
}
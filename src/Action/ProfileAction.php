<?php
/**
 * Created by PhpStorm.
 * User: Xtrazyx
 * Date: 23/10/2017
 * Time: 16:04
 */

namespace App\Action;

use App\Form\ProfileType;
use App\Manager\UserManager;
use App\Traits\RedirectTrait;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Twig\Environment;

class ProfileAction
{
    use RedirectTrait;

    private $router;

    public function __construct(Router $router)
    {
        $this->router =$router;
    }

    /**
     * @Route("/profile", name="profile")
     *
     * @param Environment $twig
     * @param RequestStack $requestStack
     * @param TokenStorage $tokenStorage
     * @param FormFactory $formFactory,
     * @param Session $session
     * @param UserManager $userManager
     *
     * @return Response
     */
    public function __invoke(
        Environment $twig,
        RequestStack $requestStack,
        TokenStorage $tokenStorage,
        FormFactory $formFactory,
        Session $session,
        UserManager $userManager
    )
    {
        $request = $requestStack->getCurrentRequest();
        $user = $tokenStorage->getToken()->getUser();
        $form = $formFactory->create(ProfileType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $userManager->update();

            $this->redirectToRoute('index');
        }

        $content = $twig->render('profile.html.twig', array(
            'user' => $user,
            'form' => $form->createView()

        ));

        $session->getFlashbag()->get('retrieve');

        return new Response($content);
    }

    public function getRouter()
    {
        return $this->router;
    }
}

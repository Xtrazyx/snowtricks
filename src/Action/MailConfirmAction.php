<?php
/**
 * Created by PhpStorm.
 * User: Xtrazyx
 * Date: 25/09/2017
 * Time: 13:51
 */

namespace App\Action;

use App\Entity\User;
use App\Form\ChangePasswordType;
use App\Manager\UserManager;
use App\Traits\RedirectTrait;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Twig\Environment;

class MailConfirmAction
{
    use RedirectTrait;

    private $router;

    /**
     * RetrieveAction constructor.
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * @Route("/mail_confirm/{email}/{confirm_token}", name="mail_confirm")
     *
     * @param Environment $twig
     * @param FormFactory $formFactory
     * @param RequestStack $requestStack
     * @param UserManager $userManager
     * @param Session $session
     * @param UserPasswordEncoderInterface $encoder
     * @param $email
     * @param $confirm_token
     *
     * @return Response
     */
    public function __invoke(
        Environment $twig,
        FormFactory $formFactory,
        RequestStack $requestStack,
        UserManager $userManager,
        Session $session,
        UserPasswordEncoderInterface $encoder,
        $email,
        $confirm_token
    )
    {
        $request = $requestStack->getCurrentRequest();
        $form = $formFactory->create(ChangePasswordType::class);
        $form->handleRequest($request);
        $flashBag = $session->getFlashBag();

        $user = $userManager->getByEmail($email);

        // Handle form submission if token valid
        if($form->isSubmitted() && $form->isValid() && $user instanceof User)
        {
            if (md5($confirm_token) == $session->get('cryptToken'))
            {
                $data = $form->getData();
                $user->setPassword(
                    $encoder->encodePassword(
                        $user, $data['password'])
                );
                $userManager->update();
                $session->remove('cryptToken');

                $flashBag->add('success', 'Votre nouveau mot de passe est actif, merci de vous identifier.');
                return $this->redirectToRoute('login');
            }

            $flashBag->add('warning', 'Un problème est survenu, identification impossible.');
            return $this->redirectToRoute('login');
        }

        // Check the user with send token and session token
        if($user instanceof User)
        {
            if(md5($confirm_token) == $request->getSession()->get('cryptToken'))
            {
                return new Response($twig->render(
                    'change_password.html.twig', array(
                    'form' => $form->createView()
                )));
            }
        }

        $flashBag->add('warning', 'Un problème est survenu, identification impossible.');
        return $this->redirectToRoute('login');
    }

    /**
     * @return Router
     */
    public function getRouter()
    {
        return $this->router;
    }
}

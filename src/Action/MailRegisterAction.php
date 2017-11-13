<?php
/**
 * Created by PhpStorm.
 * User: Xtrazyx
 * Date: 25/09/2017
 * Time: 13:51
 */

namespace App\Action;

use App\Entity\User;
use App\Manager\UserManager;
use App\Traits\RedirectTrait;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Twig\Environment;

class MailRegisterAction
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
     * @Route("/mail_register/{email}/{confirm_token}", name="mail_register")
     *
     * @param Environment $twig
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
        UserManager $userManager,
        Session $session,
        UserPasswordEncoderInterface $encoder,
        $email,
        $confirm_token
    )
    {
        $flashBag = $session->getFlashBag();
        $user = $userManager->getByEmail($email);

        // Check the user with send token and session token
        if($user instanceof User)
        {
            if(md5($confirm_token) == $session->get('RegisterToken'))
            {
                // Render the user able to login
                $user->setActive(true);
                $userManager->update();

                // Destroy the token
                $session->remove('RegisterToken');

                // Flash
                $flashBag->add('success', 'Votre adresse est confirmée.');

                return new Response($twig->render('confirm_register.html.twig'));
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

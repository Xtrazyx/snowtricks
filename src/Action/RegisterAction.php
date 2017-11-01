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
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Twig\Environment;

class RegisterAction
{
    use RedirectTrait;

    private $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * @Route("/register", name="register")
     *
     * @param Environment $twig
     * @param RequestStack $requestStack
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param FormFactory $formFactory
     * @param UserManager $userManager
     * @param TokenStorage $tokenStorage
     * @param Session $session
     * @param \Swift_Mailer $mailer
     *
     * @return Response
     *
     */
    public function __invoke(
        Environment $twig,
        RequestStack $requestStack,
        UserPasswordEncoderInterface $passwordEncoder,
        FormFactory $formFactory,
        UserManager $userManager,
        TokenStorage $tokenStorage,
        Session $session,
        \Swift_Mailer $mailer
    )
    {
        $request = $requestStack->getCurrentRequest();
        $user = $userManager->new();
        $form = $formFactory->create(RegisterType::class, $user);
        $flashBag = $session->getFlashBag();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            // New User with encoded password
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            $user->setRoles(array('ROLE_USER'));

            $userManager->persist($user);

            // Mail confirmation to make user active
            $mailToken = bin2hex(random_bytes(16));
            $cryptToken = md5($mailToken);
            $request->getSession()->set('RegisterToken', $cryptToken);

            // Message creation
            $message = new \Swift_Message(
                'Confirmer votre adresse email',
                $twig->render('mail_confirm_register.html.twig', array('confirm_token' => $mailToken, 'email' => $user->getEmail())),
                'text/html',
                'utf-8');
            $message->setFrom('xtrazyx@gmail.com');
            $message->setTo($user->getEmail());

            // Message sending
            $mailer->send($message);

            $flashBag->add('info', 'Vous allez recevoir un email contenant les instructions pour activer votre compte.');

            return $this->redirectToRoute('login');
        }

        return new Response($twig->render(
            'register.html.twig', array(
            'form' => $form->createView()
        )));
    }

    public function getRouter()
    {
        return $this->router;
    }
}

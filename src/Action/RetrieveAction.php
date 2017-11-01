<?php
/**
 * Created by PhpStorm.
 * User: Xtrazyx
 * Date: 25/09/2017
 * Time: 13:51
 */

namespace App\Action;

use App\Entity\User;
use App\Form\RetrievePasswordType;
use App\Manager\UserManager;
use App\Traits\RedirectTrait;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Router;
use Twig\Environment;

/**
 * Class RetrieveAction
 * @package App\Action
 *
 * Retrieve the password by sending an token by email
 */
class RetrieveAction
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
     * @Route("/retrieve", name="retrieve")
     *
     * @param Environment $twig
     * @param FormFactory $formFactory
     * @param RequestStack $requestStack
     * @param UserManager $userManager
     * @param Session $session
     * @param \Swift_Mailer $mailer
     *
     * @return Response
     */
    public function __invoke(
        Environment $twig,
        \Swift_Mailer $mailer,
        FormFactory $formFactory,
        RequestStack $requestStack,
        UserManager $userManager,
        Session $session
    )
    {
        $request = $requestStack->getCurrentRequest();
        $form = $formFactory->create(RetrievePasswordType::class);
        $form->handleRequest($request);
        $flashBag = $session->getFlashBag();

        if($form->isSubmitted() && $form->isValid())
        {
            $data = $form->getData();
            $user = $userManager->getByEmail($data['email']);
            // Envoi d'un token de confirmation par email
            if($user instanceof User)
            {
                $mailToken = bin2hex(random_bytes(16));
                $cryptToken = md5($mailToken);
                $request->getSession()->set('cryptToken', $cryptToken);

                $message = new \Swift_Message(
                    'Changement de mot de passe demandé',
                    $twig->render('mail_confirm.html.twig', array('confirm_token' => $mailToken, 'email' => $user->getEmail())),
                    'text/html',
                    'utf-8'
                );

                $message->setFrom('xtrazyx@gmail.com');
                $message->setTo($user->getEmail());

                $mailer->send($message);

                $flashBag->add('info', 'Vous allez recevoir un email contenant les instructions pour changer votre mot de passe.');

                return $this->redirectToRoute('login');
            }

            $flashBag->add('warning', $data['email'] . ' ' . 'Identification impossible, votre email n\'est pas valide.');
            return $this->redirectToRoute('login');
        }

        return new Response($twig->render(
            'retrieve.html.twig', array(
            'form' => $form->createView()
        )));
    }

    /**
     * @return Router
     */
    public function getRouter()
    {
        return $this->router;
    }
}
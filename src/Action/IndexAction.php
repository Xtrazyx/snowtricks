<?php
/**
 * Created by PhpStorm.
 * User: Xtrazyx
 * Date: 25/09/2017
 * Time: 13:51
 */

namespace App\Action;

use App\Manager\TrickManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Twig\Environment;

class IndexAction
{
    private $twig;
    private $trickManager;
    private $session;

    public function __construct(
        Environment $twig,
        TrickManager $trickManager,
        Session $session
    )
    {
        $this->twig = $twig;
        $this->trickManager = $trickManager;
        $this->session = $session;
    }

    /**
     * @Route("/", name="index")
     */
    public function __invoke()
    {
        $tricks = $this->trickManager->getAll();

        $content = $this->twig->render('index.html.twig', array(
            'tricks' => $tricks
        ));

        $flashBag = $this->session->getFlashBag();
        $flashBag->get('delete_trick');

        return new Response($content);
    }
}
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

/**
 * Class IndexAction
 * @package App\Action
 *
 * Show the index page
 * Load the tricks
 * Load Authenticated User with ROLE_USER
 */
class IndexAction
{

    /**
     * @Route("/", name="index")
     *
     * @param Environment $twig
     * @param TrickManager $trickManager
     * @param Session $session
     * @return Response
     */
    public function __invoke(
        Environment $twig,
        TrickManager $trickManager,
        Session $session
    )
    {
        $content = $twig->render('index.html.twig');

        $flashBag = $session->getFlashBag();
        $flashBag->get('delete_trick');

        return new Response($content);
    }
}
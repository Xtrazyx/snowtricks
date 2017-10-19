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
use Twig\Environment;

class IndexAction
{
    private $twig;
    private $trickManager;

    public function __construct(
        Environment $twig,
        TrickManager $trickManager
    )
    {
        $this->twig = $twig;
        $this->trickManager = $trickManager;
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
        return new Response($content);
    }
}
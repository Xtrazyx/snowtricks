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

class TrickAction
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
     * @Route("/trick/{id}", name="trick", requirements={"id": "\d+"})
     */
    public function __invoke($id)
    {
        $trick = $this->trickManager->getById($id);

        if(!$trick){
            $content = $this->twig->render('@Twig/Exception/error.html.twig', array(
                'status_code' => '404',
                'status_text' => 'La page demandée n\'existe pas'));
        }else{
            $content = $this->twig->render('trick.html.twig', array(
                'trick' => $trick
            ));
        }

        return new Response($content);
    }
}
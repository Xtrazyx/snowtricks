<?php
/**
 * Created by PhpStorm.
 * User: Xtrazyx
 * Date: 25/09/2017
 * Time: 13:51
 */

namespace App\Action;

use App\Form\PostType;
use App\Manager\PostManager;
use App\Manager\TrickManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class TrickAction
{
    private $twig;
    private $trickManager;
    private $postManager;
    private $request;
    private $formFactory;

    public function __construct(
        Environment $twig,
        TrickManager $trickManager,
        PostManager $postManager,
        RequestStack $requestStack,
        FormFactory $formFactory
    )
    {
        $this->twig = $twig;
        $this->trickManager = $trickManager;
        $this->postManager = $postManager;
        $this->request = $requestStack->getCurrentRequest();
        $this->formFactory = $formFactory;
    }

    /**
     * @Route("/trick/{id}", name="trick", requirements={"id": "\d+"})
     */
    public function __invoke($id)
    {
        $trick = $this->trickManager->getById($id);

        $form = $this->formFactory->create(PostType::class, $this->postManager->new());

        if(!$trick){
            $content = $this->twig->render('@Twig/Exception/error.html.twig', array(
                'status_code' => '404',
                'status_text' => 'La page demandée n\'existe pas'));
        }else{
            $posts = $this->postManager->getAll();

            $content = $this->twig->render('trick.html.twig', array(
                'trick' => $trick,
                'posts' => $posts,
                'form' => $form->createView()
            ));
        }

        return new Response($content);
    }
}
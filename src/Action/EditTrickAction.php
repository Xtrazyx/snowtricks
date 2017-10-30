<?php
/**
 * Created by PhpStorm.
 * User: Xtrazyx
 * Date: 25/09/2017
 * Time: 13:51
 */

namespace App\Action;

use App\Form\TrickType;
use App\Manager\GroupManager;
use App\Manager\TrickManager;
use App\Traits\RedirectTrait;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Router;
use Twig\Environment;

class EditTrickAction
{
    use RedirectTrait;

    private $twig;
    private $trickManager;
    private $groupManager;
    private $formFactory;
    private $request;
    private $router;

    public function __construct(
        Environment $twig,
        TrickManager $trickManager,
        GroupManager $groupManager,
        FormFactory $formFactory,
        RequestStack $requestStack,
        Router $router
    )
    {
        $this->twig = $twig;
        $this->trickManager = $trickManager;
        $this->groupManager = $groupManager;
        $this->formFactory = $formFactory;
        $this->request = $requestStack->getCurrentRequest();
        $this->router = $router;
    }

    /**
     * @Route("/edit_trick/{id}", name="edit_trick")
     */
    public function __invoke($id)
    {
        $trick = $this->trickManager->getById($id);
        $groups = $this->groupManager->getAll();
        $form = $this->formFactory->create(
            TrickType::class,
            $trick, array(
            'groups' => $groups));

        $form->handleRequest($this->request);

        if($form->isValid() && $form->isSubmitted())
        {
            $trick = $form->getData();
            $this->trickManager->update();

            return $this->redirectToRoute(
                'trick', array(
                'id' => $trick->getId()
            ));
        }

        return new Response($this->twig->render(
            'edit_trick.html.twig', array(
            'form' => $form->createView()
        )));
    }

    public function getRouter()
    {
        return $this->router;
    }
}

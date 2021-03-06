<?php
/**
 * Created by PhpStorm.
 * User: Xtrazyx
 * Date: 25/09/2017
 * Time: 13:51
 */

namespace App\Action;

use App\Manager\TrickManager;
use App\Traits\RedirectTrait;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Router;

class DeleteTrickAction
{
    use RedirectTrait;

    private $trickManager;
    private $router;
    private $session;

    public function __construct(
        TrickManager $trickManager,
        Router $router,
        Session $session
    )
    {
        $this->trickManager = $trickManager;
        $this->router = $router;
        $this->session= $session;
    }

    /**
     * @Route("/delete_trick/{id}", name="delete_trick")
     */
    public function __invoke($id)
    {
        $trickName = $this->trickManager->getById($id)->getName();
        $this->trickManager->delete($id);

        $flashBag = $this->session->getFlashBag();
        $flashBag->add(
            'success',
            "La figure " . $trickName . " a bien été supprimée."
        );

        return $this->redirectToRoute('index');
    }

    public function getRouter()
    {
        return $this->router;
    }
}

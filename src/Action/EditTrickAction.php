<?php
/**
 * Created by PhpStorm.
 * User: Xtrazyx
 * Date: 25/09/2017
 * Time: 13:51
 */

namespace App\Action;

use App\Form\EditTrickType;
use App\Manager\GroupManager;
use App\Manager\TrickImageManager;
use App\Manager\TrickManager;
use App\Manager\VideoManager;
use App\Traits\RedirectTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Router;
use Twig\Environment;

class EditTrickAction
{
    use RedirectTrait;

    private $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * @Route("/edit_trick/{id}", name="edit_trick")
     *
     * @param Environment $twig
     * @param TrickManager $trickManager
     * @param TrickImageManager $trickImageManager
     * @param VideoManager $videoManager
     * @param GroupManager $groupManager
     * @param FormFactory $formFactory
     * @param RequestStack $requestStack
     * @param $id
     *
     * @return Response
     */
    public function __invoke(
        Environment $twig,
        TrickManager $trickManager,
        TrickImageManager $trickImageManager,
        VideoManager $videoManager,
        GroupManager $groupManager,
        FormFactory $formFactory,
        RequestStack $requestStack,
        $id)
    {
        $trick = $trickManager->getById($id);
        $request = $requestStack->getCurrentRequest();

        if(!$trick) {
            return new Response(
                $twig->render(
                    '@Twig/Exception/error.html.twig',
                    array(
                        'status_code' => '404',
                        'status_text' => 'La page demandée n\'existe pas'
                    )
                )
            );
        }

        // Managing deleted fileInput fields : making a temporary collection for comparison
        // Videos
        $existingVideos = new ArrayCollection();
        foreach($trick->getVideos() as $video){
            $existingVideos->add($video);
        }

        $groups = $groupManager->getAll();
        $form = $formFactory->create(
            EditTrickType::class,
            $trick, array(
            'groups' => $groups));

        $form->handleRequest($request);

        if($form->isValid() && $form->isSubmitted())
        {
            //Managing deleted fileInput fields : remove videos when inputField is removed
            foreach($existingVideos as $video){
                if($trick->getVideos()->contains($video) === false){
                    $trick->removeVideo($video);
                    $videoManager->remove($video);
                }
            }

            $trickManager->update();

            return $this->redirectToRoute(
                'trick', array(
                'id' => $trick->getId()
            ));
        }

        return new Response($twig->render(
            'edit_trick.html.twig', array(
                'form' => $form->createView(),
                'trick' => $trick
        )));
    }

    public function getRouter()
    {
        return $this->router;
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: Xtrazyx
 * Date: 25/09/2017
 * Time: 13:51
 */

namespace App\Action;

use App\Manager\TrickManager;
use App\Manager\VideoManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class ManageVideoAction
{
    /**
     * @Route("/manage_video", name="manage_video")
     *
     * @param RequestStack $requestStack
     * @param TrickManager $trickManager
     * @param VideoManager $videoManager
     * @param Environment $twig
     * @return Response
     */
    public function __invoke(
        RequestStack $requestStack,
        TrickManager $trickManager,
        VideoManager $videoManager,
        Environment $twig
    )
    {
        // Handling request
        $request = $requestStack->getCurrentRequest();
        $actionType = $request->get('actionType');

        // Add new video to the trick
        if($actionType == 'create'){
            $video = $videoManager->new();

            $video->setTrick($trickManager->getById($request->request->get('trick_id')));
            $video->setSourceId($request->request->get('sourceId'));
            $videoManager->persist($video);

            return new Response($twig->render(
                'lib_video_item.html.twig', array(
                    'video' => $video
            )));
        }

        // Delete image
        if($actionType == 'delete'){
            $video = $videoManager->getById($request->get('videoId'));
            // Storing image id for confirmation message
            $deleteVideoId = array('deleted_video_id' => $video->getId());

            $video->getTrick()->removeVideo($video);
            $videoManager->remove($video);

            return new Response(json_encode($deleteVideoId));
        }

        return new Response($twig->render(
            'error.html.twig',array(
                'error' => array(
                    'code' => '404')
            )
        ));
    }
}

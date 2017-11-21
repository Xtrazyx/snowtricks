<?php
/**
 * Created by PhpStorm.
 * User: Xtrazyx
 * Date: 25/09/2017
 * Time: 13:51
 */

namespace App\Action;

use App\Manager\TrickImageManager;
use App\Manager\TrickManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class ManageImageAction
{
    /**
     * @Route("/manage_image", name="manage_image")
     *
     * @param RequestStack $requestStack
     * @param TrickManager $trickManager
     * @param TrickImageManager $trickImageManager
     * @param Environment $twig
     * @return Response
     */
    public function __invoke(
        RequestStack $requestStack,
        TrickManager $trickManager,
        TrickImageManager $trickImageManager,
        Environment $twig
    )
    {
        // Handling request
        $request = $requestStack->getCurrentRequest();
        $actionType = $request->get('actionType');

        // Add new image to the trick
        if($actionType == 'create'){
            $image = $trickImageManager->new();
            $file = new UploadedFile($request->files->get('imageFile'),'temp');

            $image->setTrick($trickManager->getById($request->request->get('trick_id')));
            $image->setFilename($file);
            $trickImageManager->persist($image);

            return new Response($twig->render(
                'lib_image_item.html.twig', array(
                    'image' => $image
            )));
        }

        // Delete image
        if($actionType == 'delete'){
            $image = $trickImageManager->getById($request->get('imageId'));
            // Storing image id for confirmation message
            $deleteImageId = array('deleted_image_id' => $image->getId());

            $image->getTrick()->removeTrickImage($image);
            $trickImageManager->remove($image);

            return new Response(json_encode($deleteImageId));
        }

        return new Response($twig->render(
            'error.html.twig',array(
                'error' => array(
                    'code' => '404')
            )
        ));
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: Xtrazyx
 * Date: 25/09/2017
 * Time: 13:51
 */

namespace App\Action;

use App\Form\TrickImageType;
use App\Manager\PostManager;
use App\Manager\TrickImageManager;
use App\Manager\TrickManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Twig\Environment;

class ManageImageAction
{
    /**
     * @Route("/manage_image", name="manage_image")
     *
     * @param RequestStack $requestStack
     * @param PostManager $postManager
     * @param TokenStorage $tokenStorage
     * @param TrickManager $trickManager
     * @param TrickImageManager $trickImageManager
     * @param FormFactory $formFactory
     * @param Environment $twig
     * @return Response
     */
    public function __invoke(
        RequestStack $requestStack,
        PostManager $postManager,
        TrickManager $trickManager,
        TrickImageManager $trickImageManager,
        FormFactory $formFactory,
        TokenStorage $tokenStorage,
        Environment $twig
    )
    {
        // Handling request
        $request = $requestStack->getCurrentRequest();
        $actionType = $request->get('actionType');

        // Add new image to the trick
        if($actionType == 'create'){
            $image = $trickImageManager->new();
            $form = $formFactory->create(TrickImageType::class);

            if($request->isMethod('GET')){
                return new Response($twig->render(
                    'form.html.twig', array(
                        'form' => $form->createView()
                    )
                ));
            }

            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){
                $image->setTrick($trickManager->getById($request->request->get('trick_id')));
                $trickImageManager->persist($image);

                return new Response($twig->render(
                    'lib_image_item.html.twig', array(
                        'image' => $image
                )));
            }

            return new Response('error', 500);
        }

        // Update image
        if($actionType == 'update'){
            $image = $trickImageManager->getById($request->request->get('image_id'));
            $form = $formFactory->create(TrickImageType::class, $image);

            if($request->isMethod('GET')){
                return new Response($twig->render(
                    'form.html.twig', array(
                        'form' => $form->createView()
                    )
                ));
            }

            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){
                $trickManager->update();

                return new Response($twig->render(
                    'lib_image_item.html.twig', array(
                    'image' => $image
                )));
            }

            return new Response('error', 500);
        }

        // Delete image
        if($actionType == 'delete'){
            $image = $trickImageManager->getById($request->request->get('image_id'));
            // Storing image id for confirmation message
            $deleteImageId = array('deleted_image_id' => $image->getId());

            $image->getTrick()->removeTrickImage($image);
            $trickImageManager->remove($image);

            return new Response(json_encode($deleteImageId));
        }

        return new Response('error', 404);
    }
}

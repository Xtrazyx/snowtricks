<?php
/**
 * Created by PhpStorm.
 * User: Xtrazyx
 * Date: 25/09/2017
 * Time: 13:51
 */

namespace App\Action;

use App\Manager\PostManager;
use App\Manager\TrickManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Twig\Environment;

class PostAction
{
    /**
     * @Route("/post", name="post")
     *
     * @param RequestStack $requestStack
     * @param PostManager $postManager
     * @param TokenStorage $tokenStorage
     * @param TrickManager $trickManager
     * @param Environment $twig
     * @return Response
     */
    public function __invoke(
        RequestStack $requestStack,
        PostManager $postManager,
        TrickManager $trickManager,
        TokenStorage $tokenStorage,
        Environment $twig
    )
    {
        // Handling request
        $request = $requestStack->getCurrentRequest();
        $content = $request->get('content');
        $user = $tokenStorage->getToken()->getUser();
        $trick = $trickManager->getById($request->get('trick_id'));

        // Setting new post
        $post = $postManager->new();
        $post->setContent($content);
        $post->setUser($user);
        $postManager->persist($post);

        $trick->addPost($post);
        $trickManager->update();

        $response = new Response($twig->render(
            'post.html.twig', array(
            'post' => $post
            )
        ));

        return $response;
    }

}
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
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class ListTrickAction
{
    const NB_PER_PAGE = 10; // Trick number per page (pagination)

    /**
     * @Route("/list_trick", name="list_trick")
     *
     * @param RequestStack $requestStack
     * @param TrickManager $trickManager
     * @param Environment $twig
     * @return Response
     */
    public function __invoke(
        RequestStack $requestStack,
        TrickManager $trickManager,
        Environment $twig
    )
    {
        $request = $requestStack->getCurrentRequest();

        // Indicates the total number of pages to the Jquery paginator
        if($request->isMethod('GET')){
            $response = new Response();
            $response->headers->set('Content-Type','application/json');
            $response->setContent(json_encode(array(
                'nbPages' => ceil($trickManager->getAllCount() / self::NB_PER_PAGE))));
            return $response;
        }

        $page = $request->get('page');
        $tricks = $trickManager->getAllPage($page);

        return new Response($twig->render(
            'trick_list.html.twig', array(
            'tricks' => $tricks
            )
        ));
    }
}
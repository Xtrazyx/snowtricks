<?php
/**
 * Created by PhpStorm.
 * User: Xtrazyx
 * Date: 11/10/2017
 * Time: 16:04
 * Gracefully borrowed from the Symfony ControllerTrait
 */

namespace App\Traits;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\Router;

/**
 * Trait RedirectTrait
 * @package App\Traits
 */
trait RedirectTrait
{
    /**
     * @return Router
     */
    abstract public function getRouter();

    /**
     * Returns a RedirectResponse to the given route with the given parameters.
     *
     * @param string $route      The name of the route
     * @param array  $parameters An array of parameters
     * @param int    $status     The status code to use for the Response
     *
     * @return RedirectResponse
     */
    protected function redirectToRoute($route, array $parameters = array(), $status = 302)
    {
        $router = $this->getRouter();
        $url = $router->generate($route, $parameters, $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH);
        return new RedirectResponse($url, $status);
    }
}
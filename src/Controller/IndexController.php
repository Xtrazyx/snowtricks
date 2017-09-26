<?php
/**
 * Created by PhpStorm.
 * User: Xtrazyx
 * Date: 25/09/2017
 * Time: 13:51
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class IndexController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function indexAction()
    {
        return $this->render('base.html.twig');
    }
}
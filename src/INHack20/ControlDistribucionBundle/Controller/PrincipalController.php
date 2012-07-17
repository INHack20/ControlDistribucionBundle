<?php

namespace INHack20\ControlDistribucionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class PrincipalController extends Controller
{
    /**
     * @Route("/",name="_bienvenido")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }
}

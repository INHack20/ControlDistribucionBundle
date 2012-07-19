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
    
    /**
     * Genera el menu dinamicamente de acuerdo a los datos almacenados.
     * 
     * @Template()
     */
    public function menuAction()
    {
         $em = $this->getDoctrine()->getEntityManager();
        
        $tipoTribunales = $em->getRepository('INHack20ControlDistribucionBundle:TribunalTipo')->findAll();
        
        return array('tipoTribunales' => $tipoTribunales);
    }
}

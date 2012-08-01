<?php

namespace INHack20\ControlDistribucionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use INHack20\ControlDistribucionBundle\Entity\Distribucion;
use INHack20\ControlDistribucionBundle\Form\DistribucionType;

/**
 * Distribucion controller.
 *
 * @Route("/distribucion")
 */
class DistribucionController extends Controller
{
    /**
     * Se en carga de generar una estadistica semanal simple o detallada de acuerdo al tipo de tribunal especificado
     * @Route("/{id}/estadisticaSemanal", name="distribucion_estadistica_semanal", options={"expose" = true})
     * @Template()
     */
    public function estadisticaSemanalAction($id){
        $request = $this->getRequest();
        
        $detallada = $request->query->get('detallada');
        $f_desde = $request->query->get('f_desde');
        $f_hasta = $request->query->get('f_hasta');
        
        $em = $this->getDoctrine()->getEntityManager();
        
        $tribunalTipo = new \INHack20\ControlDistribucionBundle\Entity\TribunalTipo();
        $tribunalTipo = $em->getRepository('INHack20ControlDistribucionBundle:TribunalTipo')->find($id);
        if(!$tribunalTipo)
        {
            throw $this->createNotFoundException('No se ha encontrado la entidad TribunalTipo');
        }
        // Dom-Sab 0-6
        $dias = array(
            0,0,0,0,0,0,0,
        );
        
        $causas = array();
        foreach($tribunalTipo->getCausas() as $causa){
            if ($detallada)
                $causas[$causa->getNombre()] = $dias;
            
                
        }
        $causas['TOTAL'] = $dias;
        $estadisticas = array();
        foreach ($tribunalTipo->getTribunales() as $tribunal){
            $estadisticas[$tribunal->getDescripcion()] = $causas;
        }
        
        $qb = $em->getRepository('INHack20ControlDistribucionBundle:Distribucion')
                ->createQueryBuilder('d')
                ->join('d.tribunal','t')
                ->join('d.causa','c')
                ->where('t.tribunalTipo = :tribunalTipo')
                ->setParameter('tribunalTipo', $tribunalTipo)
                
                ;
        if($f_desde != '' && $f_hasta != ''){
            $qb->andWhere('d.creado >= :f_desde')
                    ->setParameter('f_desde', $f_desde);
            
            $qb->andWhere('d.creado <= :f_hasta')
                    ->setParameter('f_hasta', $f_hasta.' 23:59 59');
        }//fin if
        
        $qb->orderBy('t.nro','asc');
        $qb->addOrderBy('c.id','asc');
        
        $distribuciones = $qb->getQuery()->getResult();
        //$distribucion = new Distribucion();
        $causa = 'TOTAL';
        foreach ($distribuciones as $distribucion){
           if ($detallada)
               $causa = $distribucion->getCausa()->getNombre();
           
           $tribunal = $distribucion->getTribunal()->getDescripcion();
           $dia = $distribucion->getCreado()->format('w');
           $contador = $estadisticas[$tribunal][$causa][$dia];
           $contadorTotal = $estadisticas[$tribunal]['TOTAL'][$dia];
           $estadisticas[$tribunal][$causa][$dia] = $contador + 1;
           $estadisticas[$tribunal]['TOTAL'][$dia] = $contadorTotal + 1;
        }
        
        
        return array(
            'estadisticas' => $estadisticas,
            'f_desde' => $f_desde,
            'f_hasta' => $f_hasta,
        );
    }
    
    /**
     * Se en carga de generar una estadistica diaria simple o detallada de acuerdo al tipo de tribunal especificado
     * @Route("/{id}/estadisticaDiaria", name="distribucion_estadistica_diaria")
     * @Template()
     */
    public function estadisticaDiariaAction($id){
        $request = $this->getRequest();
        
        $detallada = $request->query->get('detallada');
                
        $em = $this->getDoctrine()->getEntityManager();
        
        $tribunalTipo = new \INHack20\ControlDistribucionBundle\Entity\TribunalTipo();
        $tribunalTipo = $em->getRepository('INHack20ControlDistribucionBundle:TribunalTipo')->find($id);
        if(!$tribunalTipo)
        {
            throw $this->createNotFoundException('No se ha encontrado la entidad TribunalTipo');
        }
        $dias = array(
            'Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado',
        );
        $dia = array(
            0
        );
        
        $causas = array();
        foreach($tribunalTipo->getCausas() as $causa){
            if ($detallada)
                $causas[$causa->getNombre()] = $dia;
        }
        $causas['TOTAL'] = $dia;
        
        $estadisticas = array();
        foreach ($tribunalTipo->getTribunales() as $tribunal){
            $estadisticas[$tribunal->getDescripcion()] = $causas;
        }
        $diaHoy = new \DateTime('now');
        $qb = $em->getRepository('INHack20ControlDistribucionBundle:Distribucion')
                ->createQueryBuilder('d');
       
        $qb->join('d.tribunal','t')
                ->join('d.causa','c')
                ->where('t.tribunalTipo = :tribunalTipo')
                ->andWhere($qb->expr()->like('d.creado',"'".$diaHoy->format('Y-m-d')."%'"))
                ->setParameter('tribunalTipo', $tribunalTipo)
        ;
        
        
        
        $qb->orderBy('t.nro','asc');
        $qb->addOrderBy('c.id','asc');
        
        $distribuciones = $qb->getQuery()->getResult();
        //$distribucion = new Distribucion();
        $causa = 'TOTAL';
        foreach ($distribuciones as $distribucion){
           if ($detallada)
               $causa = $distribucion->getCausa()->getNombre();
           
           $tribunal = $distribucion->getTribunal()->getDescripcion();
           $dia = 0;
           $contador = $estadisticas[$tribunal][$causa][$dia];
           $contadorTotal = $estadisticas[$tribunal]['TOTAL'][$dia];
           
           $estadisticas[$tribunal][$causa][$dia] = $contador + 1;
           $estadisticas[$tribunal]['TOTAL'][$dia] = $contadorTotal + 1;
        }
        $dia = $dias[$diaHoy->format('w')];        
        return array(
            'estadisticas' => $estadisticas,
            'dia' => $dia,
        );
    }
}

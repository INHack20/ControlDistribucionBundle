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
     * Lists all Distribucion entities.
     *
     * @Route("/", name="distribucion")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('INHack20ControlDistribucionBundle:Distribucion')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Distribucion entity.
     *
     * @Route("/{id}/show", name="distribucion_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('INHack20ControlDistribucionBundle:Distribucion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Distribucion entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Distribucion entity.
     *
     * @Route("/new", name="distribucion_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Distribucion();
        $form   = $this->createForm(new DistribucionType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Distribucion entity.
     *
     * @Route("/create", name="distribucion_create")
     * @Method("post")
     * @Template("INHack20ControlDistribucionBundle:Distribucion:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Distribucion();
        $request = $this->getRequest();
        $form    = $this->createForm(new DistribucionType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('distribucion_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Distribucion entity.
     *
     * @Route("/{id}/edit", name="distribucion_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('INHack20ControlDistribucionBundle:Distribucion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Distribucion entity.');
        }

        $editForm = $this->createForm(new DistribucionType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Distribucion entity.
     *
     * @Route("/{id}/update", name="distribucion_update")
     * @Method("post")
     * @Template("INHack20ControlDistribucionBundle:Distribucion:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('INHack20ControlDistribucionBundle:Distribucion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Distribucion entity.');
        }

        $editForm   = $this->createForm(new DistribucionType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('distribucion_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Distribucion entity.
     *
     * @Route("/{id}/delete", name="distribucion_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('INHack20ControlDistribucionBundle:Distribucion')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Distribucion entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('distribucion'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
    
    /**
     * Se encarga de realizar la distribucion equitativa de las causas en los tribunales de control.
     * @Route("/{idCausa}/distribuir",name="distribucion_distribuir")
     * @Template()
     */
    public function distribuirAction($idCausa){
        $em = $this->getDoctrine()->getEntityManager();
        $causa = new \INHack20\ControlDistribucionBundle\Entity\Causa;
        $causa =  $em->getRepository('INHack20ControlDistribucionBundle:Causa')->find($idCausa);
            if(!$causa)
            {
                throw $this->createNotFoundException('No se ha encontrado la entidad Causa');
            }    
        $horarios = $causa->getGrupo()->getHorarios();
        //Guardar todos los errores para presentarselos al usuario.
        $errores = array();
        
        $dias = array(
            0 =>'DOM',
            1 =>'LUN',
            2 =>'MAR',
            3 =>'MIE',
            4 =>'JUE',
            5 =>'VIE',
            6 =>'SAB',
        );
        print_r($dias);   
        
        echo '<br/>Cantidad de horarios = '.count($horarios).'<br/>';
        $diasHorasTrabajoOriginal = array();
        foreach ($horarios as $horario) {
            $diasConvertidos=$horario->getDias();
            
            foreach($dias as $key => $dia) {
                $diasConvertidos = str_replace($dia, $key, $diasConvertidos);
            }
            echo $diasConvertidos;
            $diasHorasTrabajoOriginal[]  = array(
                'dias' => $diasConvertidos.",",
                'horaInicio' => $horario->getHoraInicio(),
                'horaFin' => $horario->getHoraFin(),
            );
            
        }
        echo '<BR/>';
        
        $diasSeparados = '';
        
        //print_r($diasHorasTrabajoOriginal);
        echo '<br/>';
        $diasHorasTrabajoFiltrado = array();
        foreach ($diasHorasTrabajoOriginal as $datos){
            foreach ($datos as $key => $value) {
                
                if($key == 'dias')
                {
                    if($datos['dias'] != ''){
                        
                        $diasSeparados = explode(',', $datos['dias']);
                        
                        foreach ($diasSeparados as $dia) {
                            
                                if(in_array('-', str_split($dia))){
                                    $d= explode('-', $dia);
                                        if(count($d)==2){
                                            $rangoDias = range($d[0], $d[1]);
                                                foreach ($rangoDias as $dia){
                                                    
                                                        $diasHorasTrabajoFiltrado [$dia] = array(
                                                            'horaInicio' => $datos['horaInicio'],
                                                            'horaFin' => $datos['horaFin'],
                                                            );
                                                }//fin foreach
                                        }//fin if
                                }//fin if
                                else{
                                    if($dia != '')
                                    $diasHorasTrabajoFiltrado [$dia] = array(
                                                        'horaInicio' => $datos['horaInicio'],
                                                        'horaFin' => $datos['horaFin'],
                                                        );
                                }
                        }
                        
                        
                    }
                    else
                        unset($datos[$key]);
                }
                
            }

        }
        
        //sort($diasHorasTrabajoFiltrado);
        //print_r($diasHorasTrabajoFiltrado);
        $fechaHoy = new \DateTime();
        
        echo 'Fecha de Hoy = '.$fechaHoy->format('d-m-Y h:i a  w').' <br/>';
        $diasAutorizados = array();
        foreach ($diasHorasTrabajoFiltrado as $key => $valor) {
            $diaLetra=$key;
            $diasAutorizados [] = $key;
            foreach($dias as $indice => $dia) {
                $diaLetra = str_replace($indice, $dia, $diaLetra);
            }
            echo "Arreglo $key dia= ".$diaLetra.": ";
            foreach ($valor as $key => $value) {
                echo $key.'='.$valor[$key]->format('h:i a').' ';
            }
            //print_r($valor);
            echo '<br/>';
        }
        
        echo 'dia hoy = '. $fechaHoy->format('w').'<br/>';
        
        $distribuir = false;
        if(in_array($fechaHoy->format('w'), $diasAutorizados)){
             
             $horaInicio = $diasHorasTrabajoFiltrado[$fechaHoy->format('w')]['horaInicio']
                     ->setDate($fechaHoy->format('Y'),$fechaHoy->format('m'),$fechaHoy->format('d'));
             
             $horaFin = $diasHorasTrabajoFiltrado[$fechaHoy->format('w')]['horaFin']
                     ->setDate($fechaHoy->format('Y'),$fechaHoy->format('m'),$fechaHoy->format('d'));
             //echo $horaInicio->format('d-m-Y h:i a');
             if($fechaHoy >= $horaInicio && $fechaHoy <= $horaFin){
                    $distribuir = true;
                 }
             else
                 $errores [] = 'En esta hora  '.$fechaHoy->format('h:i a').', no se permite la insercion de la causa '.$causa->getNombre().'<br/>';
        }
        else
           $errores [] = 'Los dias '.$dias[$fechaHoy->format('w')].' no se permite la insercion de la causa '.$causa->getNombre().'<br/>';
        
        if(count($errores) > 0)
            print_r($errores);
        
        if($distribuir){
        
            $tribunalTipo = $causa->getTribunalTipo();
            $tribunalesOriginales = $tribunalTipo->getTribunales();

            $distribuciones = new Distribucion();
            $distribuciones = $em->getRepository('INHack20ControlDistribucionBundle:Distribucion')->findTodayDistribuciones($tribunalTipo);

            $limiteAsignacion=$tribunalTipo->getLimiteCausas();//limite de ocurrencia

            //Cantidad de causas asignadas, hay q ver si esta en su limite o no, para tenerlo en cuenta dentro de la probabilidad.
            $tribunales = array();
            $tribunalesSorteo = array();
            $idsTribunalesSorteo = array();

            foreach ($distribuciones as $distribucion) {
                    $tribunales [] = array('tribunal' => $distribucion[0]->getTribunal() , 'valor' => $distribucion[1]); 
                    $idsTribunalesSorteo [] = $distribucion[0]->getTribunal()->getId();
            }

                foreach ($tribunales as $datos) {
                if($datos['tribunal']->isHabilitado() && $datos['tribunal']->isDespacho())
                        $tribunalesSorteo [] = $datos['tribunal'];
            }

                //Si el array esta vacio, todos los tribunales de deben incluir en el sorteo
                if(count($tribunalesSorteo)==0 && count($tribunales)==  count($tribunalesOriginales))
                {
                    foreach ($tribunalesOriginales as $tribunal) {
                        $tribunalesSorteo [] = $tribunal;
                        $tribunal->setHabilitado(true);
                            $em->persist($tribunal);
                    }
                    //die();
                }

                if(count($distribuciones)>0){

                    foreach ($tribunalesOriginales as $tribunalOriginal){

                        if(!in_array($tribunalOriginal->getId(), $idsTribunalesSorteo)){
                                    $tribunalesSorteo [] = $tribunalOriginal;
                                    $tribunalOriginal->setHabilitado(true);
                                    echo '<font color="red">Sin registro = '.$tribunalOriginal->getDescripcion().'</font><br/<br/>';
                                    //die();
                        }
                    }
                }
                else{
                    foreach ($tribunalesOriginales as $tribunal) {
                        if($tribunal->isHabilitado() && $tribunal->isDespacho())
                        $tribunalesSorteo [] = $tribunal;
                        //die();
                    }
                }
            $numAleatorio = rand(0, count($tribunalesSorteo)-1); //Genero numero aleatorio para elegir el tribunal

            /**** DEBUG ****/
                echo 'Tribunal de '.$tribunalTipo->getNombre().' ( 0 = FULL )<br/>';

                foreach ($distribuciones as $distribucion) {
                    echo '_____ '. $distribucion[0]->getTribunal()->getDescripcion() , ' Cantidad '.$distribucion[1] % $limiteAsignacion . '    Normal = ' . $distribucion[1].
                            ' Habilitado '. $distribucion[0]->getTribunal()->isHabilitado();
                    echo '<br/>';
                }

                echo '<br/>';
                echo 'Tribunales para el sorteo = '.count($tribunalesSorteo).'<br/>';
                    foreach ($tribunalesSorteo as $tribunal) {
                        echo '______' .$tribunal->getDescripcion().'<br/>';
                        }
                echo '<br/>';
                echo 'Limite de asignacion por tribunal ' . $limiteAsignacion .'<br/>';
                echo '<br/>';
                echo 'Numero aleatorio desde 0 hasta '.(count($tribunalesSorteo)-1).' = <font color="red">'.$numAleatorio . '</font><br/>';
                echo '<br/>';
                if(count($tribunalesSorteo) > 0)
                echo '<font color ="green">El ganador es el tribunal '.$tribunalesSorteo[$numAleatorio]->getDescripcion(). '</font>';
            /*** DEBUG *****/      



            $distribucion = new Distribucion();
            $distribucion->setCausa($causa);
            if(count($tribunalesSorteo) > 0)
                $distribucion->setTribunal($tribunalesSorteo[$numAleatorio]);

                $limite = false;
                foreach ($tribunales as $datos) {
                    foreach ($datos as $key => $value) {
                        if(($key == 'valor' 
                                && ($value % $limiteAsignacion) == ($limiteAsignacion - 1))
                                && $datos['tribunal']->isHabilitado()
                                && $datos['tribunal']->isDespacho()
                                && $tribunalesSorteo[$numAleatorio]->getId() == $datos['tribunal']->getId()
                        ){

                                echo '<br/>';
                                echo '<br/>';
                                echo ($value % $limiteAsignacion).'=='.($limiteAsignacion - 1);
                                echo '<br/>';
                                echo $datos['tribunal']->getDescripcion();
                                $limite = true;
                                echo 'LIMITEEEEE';
                                //die();
                        }
                    }
                }
                if($limite){
                    $tribunalesSorteo[$numAleatorio]->setHabilitado(false);
                    $em->persist($tribunalesSorteo[$numAleatorio]);
                }

            $em->persist($distribucion);
            //$em->flush();
            return array(
                'distribucion' => $distribucion,
             );
        }//fin if
        return array(
            'errores' => $errores,
        );
    }
}

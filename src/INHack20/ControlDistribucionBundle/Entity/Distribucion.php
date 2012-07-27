<?php

namespace INHack20\ControlDistribucionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * INHack20\ControlDistribucionBundle\Entity\Distribucion
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="INHack20\ControlDistribucionBundle\Repository\DistribucionRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Distribucion
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var datetime $creado
     *
     * @ORM\Column(name="creado", type="datetime")
     */
    protected $creado;

    /**
     * @var datetime $actualizado
     *
     * @ORM\Column(name="actualizado", type="datetime", nullable=true)
     */
    protected $actualizado;
    
    /**
     *
     * @var Tribunal
     * @ORM\ManyToOne(targetEntity="Tribunal",inversedBy="distribuciones")
     * @ORM\JoinColumn(name="tribunal_id",referencedColumnName="id")
     */
    protected $tribunal;
    
    /**
     *
     * @var Causa
     * @ORM\ManyToOne(targetEntity="Causa")
     * @ORM\JoinColumn(name="causa_id",referencedColumnName="id")
     */
    protected $causa;
    
    private $em;
    public function __construct($em = null){
        $this->em = $em;
    }
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set creado
     *
     * @param datetime $creado
     * @ORM\PrePersist
     */
    public function setCreado()
    {
        $this->creado = new \DateTime();
    }

    /**
     * Get creado
     *
     * @return datetime 
     */
    public function getCreado()
    {
        return $this->creado;
    }

    /**
     * Set actualizado
     *
     * @param datetime $actualizado
     * @ORM\preUpdate
     */
    public function setActualizado()
    {
        $this->actualizado = new \DateTime();
    }

    /**
     * Get actualizado
     *
     * @return datetime 
     */
    public function getActualizado()
    {
        return $this->actualizado;
    }

    /**
     * Set tribunal
     *
     * @param INHack20\ControlDistribucionBundle\Entity\Tribunal $tribunal
     */
    public function setTribunal(\INHack20\ControlDistribucionBundle\Entity\Tribunal $tribunal)
    {
        $this->tribunal = $tribunal;
    }

    /**
     * Get tribunal
     *
     * @return INHack20\ControlDistribucionBundle\Entity\Tribunal 
     */
    public function getTribunal()
    {
        return $this->tribunal;
    }

    /**
     * Set causa
     *
     * @param INHack20\ControlDistribucionBundle\Entity\Causa $causa
     */
    public function setCausa(\INHack20\ControlDistribucionBundle\Entity\Causa $causa)
    {
        $this->causa = $causa;
    }

    /**
     * Get causa
     *
     * @return INHack20\ControlDistribucionBundle\Entity\Causa 
     */
    public function getCausa()
    {
        return $this->causa;
    }
    
    private $errores;
    /**
     * Se encarga de realizar la distribucion equitativa de las causas en los tribunales de control.
     */
    public function distribuir($causa){
        $em = $this->em;
        //$em = $this->getDoctrine()->getEntityManager();
        /*
        $causa = new \INHack20\ControlDistribucionBundle\Entity\Causa;
        $causa =  $em->getRepository('INHack20ControlDistribucionBundle:Causa')->find($idCausa);
            if(!$causa)
            {
                throw $this->createNotFoundException('No se ha encontrado la entidad Causa');
            }
         * 
         */
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
        $diasCompletos = array (
            'Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'
        );
        //print_r($dias);   
        
        //echo '<br/>Cantidad de horarios = '.count($horarios).'<br/>';
        $diasHorasTrabajoOriginal = array();
        foreach ($horarios as $horario) {
            $diasConvertidos=$horario->getDias();
            
            foreach($dias as $key => $dia) {
                $diasConvertidos = str_replace($dia, $key, $diasConvertidos);
            }
            //echo $diasConvertidos;
            $diasHorasTrabajoOriginal[]  = array(
                'dias' => $diasConvertidos.",",
                'horaInicio' => $horario->getHoraInicio(),
                'horaFin' => $horario->getHoraFin(),
            );
            
        }
        //echo '<BR/>';
        
        $diasSeparados = '';
        
        //print_r($diasHorasTrabajoOriginal);
        //echo '<br/>';
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
        
        //echo 'Fecha de Hoy = '.$fechaHoy->format('d-m-Y h:i a  w').' <br/>';
        $diasAutorizados = array();
        foreach ($diasHorasTrabajoFiltrado as $key => $valor) {
            $diaLetra=$key;
            $diasAutorizados [] = $key;
            foreach($dias as $indice => $dia) {
                $diaLetra = str_replace($indice, $dia, $diaLetra);
            }
           // echo "Arreglo $key dia= ".$diaLetra.": ";
            /*
            foreach ($valor as $key => $value) {
                echo $key.'='.$valor[$key]->format('h:i a').' ';
            }
             * 
             */
            //print_r($valor);
            //echo '<br/>';
        }
        
        //echo 'dia hoy = '. $fechaHoy->format('w').'<br/>';
        
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
                 $errores [] = 'En esta hora  '.$fechaHoy->format('h:i a').', no se permite la insercion de la causa '.$causa->getNombre();
        }
        else
           $errores [] = 'Los dias '.$diasCompletos[$fechaHoy->format('w')].' no se permite la insercion de la causa '.$causa->getNombre();
        
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
            /**
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
             * 
             */
            /*** DEBUG *****/      
            
            $this->setCausa($causa);
            if(count($tribunalesSorteo) > 0)
                $this->setTribunal($tribunalesSorteo[$numAleatorio]);

                $limite = false;
                foreach ($tribunales as $datos) {
                    foreach ($datos as $key => $value) {
                        if(($key == 'valor' 
                                && ($value % $limiteAsignacion) == ($limiteAsignacion - 1))
                                && $datos['tribunal']->isHabilitado()
                                && $datos['tribunal']->isDespacho()
                                && $tribunalesSorteo[$numAleatorio]->getId() == $datos['tribunal']->getId()
                        ){
                                /*
                                echo '<br/>';
                                echo '<br/>';
                                echo ($value % $limiteAsignacion).'=='.($limiteAsignacion - 1);
                                echo '<br/>';
                                echo $datos['tribunal']->getDescripcion();
                                
                                echo 'LIMITEEEEE';
                                 * */
                                 //die();
                            $limite = true;
                        }
                    }
                }
                if($limite){
                    $tribunalesSorteo[$numAleatorio]->setHabilitado(false);
                    $em->persist($tribunalesSorteo[$numAleatorio]);
                }

            //$em->persist($this);
            $em->flush();
            return true;
        }//fin if
        
        $this->errores = $errores;
        return false;
    }
    public function getErrores() {
        return $this->errores;
    }
}
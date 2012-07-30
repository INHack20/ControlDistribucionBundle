<?php

namespace INHack20\ControlDistribucionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * INHack20\ControlDistribucionBundle\Entity\Tribunal
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Tribunal
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
     * @var integer $nro
     *
     * @ORM\Column(name="nro", type="integer")
     */
    private $nro;

    /**
     *
     * @var boolean $habilitado
     * @ORM\Column(name="habilitado", type="boolean")
     */
    private $habilitado;
    
    /**
     *
     * @var boolean $despacho
     * @ORM\Column(name="despacho", type="boolean") 
     */
    private $despacho;
    
    /**
     *
     * @var TribunalTipo
     * @ORM\ManyToOne(targetEntity="TribunalTipo", inversedBy="tribunales")
     * @ORM\JoinColumn(name="tribunalTipo_id",referencedColumnName="id")
     */
    protected $tribunalTipo;
    
    /**
     *
     * @var Distribucion
     * @ORM\OneToMany(targetEntity="Distribucion",mappedBy="tribunal")
     */
    protected $distribuciones;
    
    public function __construct(){
        $this->distribuciones = new ArrayCollection();
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
     * Set nro
     *
     * @param integer $nro
     */
    public function setNro($nro)
    {
        $this->nro = $nro;
    }

    /**
     * Get nro
     *
     * @return integer 
     */
    public function getNro()
    {
        return $this->nro;
    }

    /**
     * Set tribunalTipo
     *
     * @param INHack20\ControlDistribucionBundle\Entity\TribunalTipo $tribunalTipo
     */
    public function setTribunalTipo(\INHack20\ControlDistribucionBundle\Entity\TribunalTipo $tribunalTipo)
    {
        $this->tribunalTipo = $tribunalTipo;
    }

    /**
     * Get tribunalTipo
     *
     * @return INHack20\ControlDistribucionBundle\Entity\TribunalTipo 
     */
    public function getTribunalTipo()
    {
        return $this->tribunalTipo;
    }

    /**
     * Add distribuciones
     *
     * @param INHack20\ControlDistribucionBundle\Entity\Distribucion $distribuciones
     */
    public function addDistribucion(\INHack20\ControlDistribucionBundle\Entity\Distribucion $distribuciones)
    {
        $this->distribuciones[] = $distribuciones;
    }

    /**
     * Get distribuciones
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getDistribuciones()
    {
        return $this->distribuciones;
    }
    
    public function getDescripcion()
    {
        return $this->numeroToOrdinal($this->nro) . ' De ' . $this->tribunalTipo->getNombre();
    }

    /**
     * Set habilitado
     *
     * @param boolean $habilitado
     */
    public function setHabilitado($habilitado)
    {
        $this->habilitado = $habilitado;
    }

    /**
     * Get habilitado
     *
     * @return boolean 
     */
    public function isHabilitado()
    {
        return $this->habilitado;
    }

    /**
     * Get habilitado
     *
     * @return boolean 
     */
    public function getHabilitado()
    {
        return $this->habilitado;
    }

    /**
     * Set despacho
     *
     * @param boolean $despacho
     */
    public function setDespacho($despacho)
    {
        $this->despacho = $despacho;
    }

    /**
     * Get despacho
     *
     * @return boolean 
     */
    public function isDespacho()
    {
        return $this->despacho;
    }

    /**
     * Get despacho
     *
     * @return boolean 
     */
    public function getDespacho()
    {
        return $this->despacho;
    }
    
    private function numeroToOrdinal($nro, $genero = 'M'){
        
        $l = 'o';
        if($genero == 'F')
            $l = 'a';
            
        $nrosOrdinalesFemeninos = array(
            0 => '',
            1 => 'primer'.$l,
            2 => 'segund'.$l,
            3 => 'tercer'.$l,
            4 => 'cuart'.$l,
            5 => 'quint'.$l,
            6 => 'sext'.$l,
            7 => 'septim'.$l,
            8 => 'octav'.$l,
            9 => 'noven'.$l,
            10 => 'decim'.$l,
            20 => 'vigesim'.$l,
            30 => 'trigesim'.$l,
            40 => 'cuadragesim'.$l,
            50 => 'quincuagesim'.$l,
            60 => 'sexagesim'.$l,
        );

        if($nro >= 0 && $nro<=10)
            {
                $nro = $nrosOrdinalesFemeninos[$nro];
            }
        elseif($nro >= 11 && $nro<=19){
                $nro = $nrosOrdinalesFemeninos[10] . ' ' . $nrosOrdinalesFemeninos[$nro - 10];
        }    
        elseif($nro >= 20 && $nro<=99){
                $resto = (floor($nro / 10)) * 10;
                $nro = $nrosOrdinalesFemeninos[$resto] . ' ' . $nrosOrdinalesFemeninos[$nro - $resto];
        }
        return $nro;
     }//fin funcion
}
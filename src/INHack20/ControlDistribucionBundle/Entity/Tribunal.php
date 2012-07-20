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
        return $this->nro . ' De ' . $this->tribunalTipo->getNombre();
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
}
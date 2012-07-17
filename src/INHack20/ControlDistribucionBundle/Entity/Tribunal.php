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
     * @var TribunalTipo
     * @ORM\ManyToOne(targetEntity="TribunalTipo", inversedBy="tribunales")
     * @ORM\JoinColumn(name="tribunalTipo_id",referencedColumnName="id")
     */
    protected $tribunalTipo;
    
    /**
     *
     * @var Hecho
     * @ORM\OneToMany(targetEntity="Hecho", mappedBy="tribunal")
     */
    protected $hechos;
    
    /**
     *
     * @var Distribucion
     * @ORM\OneToMany(targetEntity="Distribucion",mappedBy="tribunal")
     */
    protected $distribuciones;
    
    public function __construct(){
        $this->hechos = new ArrayCollection();
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
     * Add hechos
     *
     * @param INHack20\ControlDistribucionBundle\Entity\Hecho $hechos
     */
    public function addHecho(\INHack20\ControlDistribucionBundle\Entity\Hecho $hechos)
    {
        $this->hechos[] = $hechos;
    }

    /**
     * Get hechos
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getHechos()
    {
        return $this->hechos;
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
}
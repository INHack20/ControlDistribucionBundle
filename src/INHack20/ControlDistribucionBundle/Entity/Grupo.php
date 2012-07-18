<?php

namespace INHack20\ControlDistribucionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * INHack20\ControlDistribucionBundle\Entity\Grupo
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Grupo
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
     * @var string $nombre
     *
     * @ORM\Column(name="nombre", type="string", length=20)
     */
    private $nombre;

    /**
     *
     * @var Horario
     * @ORM\ManyToMany(targetEntity="Horario") 
     */
    protected $horarios;
    
    /**
     *
     * @var Causa
     * @ORM\OneToMany(targetEntity="Causa",mappedBy="grupo") 
     */
    protected $causas;
    
    public function __construct(){
        $this->horarios = new ArrayCollection();
        $this->causas = new ArrayCollection();
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
     * Set nombre
     *
     * @param string $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Add horarios
     *
     * @param INHack20\ControlDistribucionBundle\Entity\Horario $horarios
     */
    public function addHorario(\INHack20\ControlDistribucionBundle\Entity\Horario $horarios)
    {
        $this->horarios[] = $horarios;
    }

    /**
     * Get horarios
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getHorarios()
    {
        return $this->horarios;
    }

    /**
     * Add causas
     *
     * @param INHack20\ControlDistribucionBundle\Entity\Causa $causas
     */
    public function addCausa(\INHack20\ControlDistribucionBundle\Entity\Causa $causas)
    {
        $this->causas[] = $causas;
    }

    /**
     * Get causas
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getCausas()
    {
        return $this->causas;
    }
}
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
     * @ORM\ManyToMany(targetEntity="Horario", mappedBy="grupo") 
     */
    protected $horarios;
    
    /**
     *
     * @var Hecho
     * @ORM\OneToMany(targetEntity="Hecho",mappedBy="grupo") 
     */
    protected $hechos;
    
    public function __construct(){
        $this->horarios = new ArrayCollection();
        $this->hechos = new ArrayCollection();
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
}
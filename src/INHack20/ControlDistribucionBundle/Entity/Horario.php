<?php

namespace INHack20\ControlDistribucionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * INHack20\ControlDistribucionBundle\Entity\Horario
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Horario
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
     * @var string $dias
     *
     * @ORM\Column(name="dias", type="string", length=30)
     */
    private $dias;

    /**
     * @var datetime $horaInicio
     *
     * @ORM\Column(name="horaInicio", type="datetime")
     */
    private $horaInicio;

    /**
     * @var datetime $horaFin
     *
     * @ORM\Column(name="horaFin", type="datetime")
     */
    private $horaFin;

    /**
     * @var boolean $emite
     *
     * @ORM\Column(name="emite", type="boolean")
     */
    private $emite;
    
    /**
     *
     * @var GrupoHorario
     * @ORM\ManyToMany(targetEntity="Grupo")
     * @ORM\JoinTable(name="Horarios_Grupos")
     */
    protected $grupos;

    public function __construct()
    {
        $this->grupo = new ArrayCollection();
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
     * Set dias
     *
     * @param string $dias
     */
    public function setDias($dias)
    {
        $this->dias = $dias;
    }

    /**
     * Get dias
     *
     * @return string 
     */
    public function getDias()
    {
        return $this->dias;
    }

    /**
     * Set horaInicio
     *
     * @param datetime $horaInicio
     */
    public function setHoraInicio($horaInicio)
    {
        $this->horaInicio = $horaInicio;
    }

    /**
     * Get horaInicio
     *
     * @return datetime 
     */
    public function getHoraInicio()
    {
        return $this->horaInicio;
    }

    /**
     * Set horaFin
     *
     * @param datetime $horaFin
     */
    public function setHoraFin($horaFin)
    {
        $this->horaFin = $horaFin;
    }

    /**
     * Get horaFin
     *
     * @return datetime 
     */
    public function getHoraFin()
    {
        return $this->horaFin;
    }

    /**
     * Set emite
     *
     * @param boolean $emite
     */
    public function setEmite($emite)
    {
        $this->emite = $emite;
    }

    /**
     * Get emite
     *
     * @return boolean 
     */
    public function getEmite()
    {
        return $this->emite;
    }

    /**
     * Add grupos
     *
     * @param INHack20\ControlDistribucionBundle\Entity\Grupo $grupos
     */
    public function addGrupo(\INHack20\ControlDistribucionBundle\Entity\Grupo $grupos)
    {
        $this->grupos[] = $grupos;
    }

    /**
     * Get grupos
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getGrupos()
    {
        return $this->grupos;
    }
}
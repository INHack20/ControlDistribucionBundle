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

    public function getDescripcion(){
        return $this->dias . ' (' .
                $this->horaInicio->format('h:ia') . ' '.
                $this->horaFin->format('h:ia') . ')';
    }
}
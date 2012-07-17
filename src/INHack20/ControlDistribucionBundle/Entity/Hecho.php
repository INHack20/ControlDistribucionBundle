<?php

namespace INHack20\ControlDistribucionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * INHack20\ControlDistribucionBundle\Entity\Hecho
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Hecho
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
     * @ORM\Column(name="nombre", type="string", length=100)
     */
    private $nombre;

    /**
     *
     * @var Tribunal
     * @ORM\ManyToOne(targetEntity="Tribunal",inversedBy="hechos")
     * @ORM\JoinColumn(name="tribunal_id", referencedColumnName="id") 
     */
    protected $tribunal;
    
    /**
     *
     * @var Grupo
     * @ORM\ManyToOne(targetEntity="Grupo",inversedBy="hechos")
     * @ORM\JoinColumn(name="grupo_id",referencedColumnName="id") 
     */
    protected $grupo;

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
     * Set grupo
     *
     * @param INHack20\ControlDistribucionBundle\Entity\Grupo $grupo
     */
    public function setGrupo(\INHack20\ControlDistribucionBundle\Entity\Grupo $grupo)
    {
        $this->grupo = $grupo;
    }

    /**
     * Get grupo
     *
     * @return INHack20\ControlDistribucionBundle\Entity\Grupo 
     */
    public function getGrupo()
    {
        return $this->grupo;
    }
}
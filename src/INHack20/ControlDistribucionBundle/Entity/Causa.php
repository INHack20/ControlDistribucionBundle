<?php

namespace INHack20\ControlDistribucionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * INHack20\ControlDistribucionBundle\Entity\Causa
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Causa
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
     * @ORM\ManyToOne(targetEntity="TribunalTipo",inversedBy="causas")
     * @ORM\JoinColumn(name="tribunaltipo_id", referencedColumnName="id") 
     */
    protected $tribunalTipo;
    
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
    
    public function getDescripcion(){
        return $this->nombre . ' ['.$this->tribunalTipo->getNombre().']';
    }
}
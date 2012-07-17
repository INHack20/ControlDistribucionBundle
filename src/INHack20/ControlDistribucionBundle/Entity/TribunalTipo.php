<?php

namespace INHack20\ControlDistribucionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * INHack20\ControlDistribucionBundle\Entity\TribunalTipo
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class TribunalTipo
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
     * @ORM\OneToMany(targetEntity="Tribunal", mappedBy="tribunalTipo") 
     */
    protected $tribunales;

    public function __construct(){
        $this->tribunales = new ArrayCollection();
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
     * Add tribunales
     *
     * @param INHack20\ControlDistribucionBundle\Entity\Tribunal $tribunales
     */
    public function addTribunal(\INHack20\ControlDistribucionBundle\Entity\Tribunal $tribunales)
    {
        $this->tribunales[] = $tribunales;
    }

    /**
     * Get tribunales
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTribunales()
    {
        return $this->tribunales;
    }
}
<?php

namespace INHack20\ControlDistribucionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * INHack20\ControlDistribucionBundle\Entity\Distribucion
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class Distribucion
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
     * @var datetime $creado
     *
     * @ORM\Column(name="creado", type="datetime")
     */
    protected $creado;

    /**
     * @var datetime $actualizado
     *
     * @ORM\Column(name="actualizado", type="datetime", nullable=true)
     */
    protected $actualizado;
    
    /**
     *
     * @var Tribunal
     * @ORM\ManyToOne(targetEntity="Tribunal",inversedBy="distribuciones")
     * @ORM\JoinColumn(name="tribunal_id",referencedColumnName="id")
     */
    protected $tribunal;

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
     * Set creado
     *
     * @param datetime $creado
     * @ORM\PrePersist
     */
    public function setCreado()
    {
        $this->creado = new \DateTime();
    }

    /**
     * Get creado
     *
     * @return datetime 
     */
    public function getCreado()
    {
        return $this->creado;
    }

    /**
     * Set actualizado
     *
     * @param datetime $actualizado
     * @ORM\preUpdate
     */
    public function setActualizado()
    {
        $this->actualizado = new \DateTime();
    }

    /**
     * Get actualizado
     *
     * @return datetime 
     */
    public function getActualizado()
    {
        return $this->actualizado;
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
}
<?php

namespace INHack20\ControlDistribucionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * INHack20\ControlDistribucionBundle\Entity\Distribucion
 *
 * @ORM\Table()
 * @ORM\Entity
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
    private $creado;

    /**
     * @var datetime $actualizado
     *
     * @ORM\Column(name="actualizado", type="datetime")
     */
    private $actualizado;


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
     */
    public function setCreado($creado)
    {
        $this->creado = $creado;
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
     */
    public function setActualizado($actualizado)
    {
        $this->actualizado = $actualizado;
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
}
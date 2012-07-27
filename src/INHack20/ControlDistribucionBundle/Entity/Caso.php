<?php

namespace INHack20\ControlDistribucionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * INHack20\ControlDistribucionBundle\Entity\Caso
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class Caso
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
     * @var string $fiscalia
     *
     * @ORM\ManyToOne(targetEntity="Fiscalia")
     * @ORM\JoinColumn(name="fiscalia_id", referencedColumnName="id")
     */
    private $fiscalia;

    /**
     * @var string $nroAsuntoFiscal
     *
     * @ORM\Column(name="nroAsuntoFiscal", type="string", length=40)
     */
    private $nroAsuntoFiscal;

    /**
     * @var string $nroOficioFiscal
     *
     * @ORM\Column(name="nroOficioFiscal", type="string", length=40)
     */
    private $nroOficioFiscal;

    /**
     * @var string $nombreImputado
     *
     * @ORM\Column(name="nombreImputado", type="string", length=50)
     */
    private $nombreImputado;

    /**
     * @var string $nombreVictima
     *
     * @ORM\Column(name="nombreVictima", type="string", length=50)
     */
    private $nombreVictima;
    
    /**
     *
     * @var string $pieza
     * 
     * @ORM\Column(name="pieza", type="integer")
     */
    private $pieza;
    
    /**
     *
     * @var DateTime $creado
     * @ORM\Column(name="creado", type="datetime") 
     */
    protected $creado;
    /**
     *
     * @var DateTime $actualizado
     * @ORM\Column(name="actualizado", type="datetime", nullable=true) 
     */
    protected $actualizado;
    
    /**
     *
     * @var Distribucion $distribucion
     * @ORM\OneToOne(targetEntity="Distribucion", cascade={"persist","remove"}) 
     * @ORM\JoinColumn(name="distribucion_id", referencedColumnName="id")
     */
    protected $distribucion;
    
    /**
     *
     * @var Usuario $usuario
     * @ORM\ManyToOne(targetEntity="INHack20\UserBundle\Entity\User")
     * @0RM\JoinColumn(name="user_id",referencedColumnName="id")
     */
    protected $usuario;
    
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
     * Set nroOficioFiscal
     *
     * @param string $nroOficioFiscal
     */
    public function setNroOficioFiscal($nroOficioFiscal)
    {
        $this->nroOficioFiscal = $nroOficioFiscal;
    }

    /**
     * Get nroOficioFiscal
     *
     * @return string 
     */
    public function getNroOficioFiscal()
    {
        return $this->nroOficioFiscal;
    }

    /**
     * Set nombreImputado
     *
     * @param string $nombreImputado
     */
    public function setNombreImputado($nombreImputado)
    {
        $this->nombreImputado = $nombreImputado;
    }

    /**
     * Get nombreImputado
     *
     * @return string 
     */
    public function getNombreImputado()
    {
        return $this->nombreImputado;
    }

    /**
     * Set nombreVictima
     *
     * @param string $nombreVictima
     */
    public function setNombreVictima($nombreVictima)
    {
        $this->nombreVictima = $nombreVictima;
    }

    /**
     * Get nombreVictima
     *
     * @return string 
     */
    public function getNombreVictima()
    {
        return $this->nombreVictima;
    }

    /**
     * Set creado
     *
     * @param datetime $creado
     * @ORM\prePersist
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
     * Set distribucion
     *
     * @param INHack20\ControlDistribucionBundle\Entity\Distribucion $distribucion
     */
    public function setDistribucion(\INHack20\ControlDistribucionBundle\Entity\Distribucion $distribucion)
    {
        $this->distribucion = $distribucion;
    }

    /**
     * Get distribucion
     *
     * @return INHack20\ControlDistribucionBundle\Entity\Distribucion 
     */
    public function getDistribucion()
    {
        return $this->distribucion;
    }

    /**
     * Set pieza
     *
     * @param integer $pieza
     */
    public function setPieza($pieza)
    {
        $this->pieza = $pieza;
    }

    /**
     * Get pieza
     *
     * @return integer 
     */
    public function getPieza()
    {
        return $this->pieza;
    }

    /**
     * Set fiscalia
     *
     * @param INHack20\ControlDistribucionBundle\Entity\Fiscalia $fiscalia
     */
    public function setFiscalia(\INHack20\ControlDistribucionBundle\Entity\Fiscalia $fiscalia)
    {
        $this->fiscalia = $fiscalia;
    }

    /**
     * Get fiscalia
     *
     * @return INHack20\ControlDistribucionBundle\Entity\Fiscalia 
     */
    public function getFiscalia()
    {
        return $this->fiscalia;
    }
    

    /**
     * Set usuario
     *
     * @param INHack20\UserBundle\Entity\User $usuario
     */
    public function setUsuario(\INHack20\UserBundle\Entity\User $usuario)
    {
        $this->usuario = $usuario;
    }

    /**
     * Get usuario
     *
     * @return INHack20\UserBundle\Entity\User 
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Set nroAsuntoFiscal
     *
     * @param string $nroAsuntoFiscal
     */
    public function setNroAsuntoFiscal($nroAsuntoFiscal)
    {
        $this->nroAsuntoFiscal = $nroAsuntoFiscal;
    }

    /**
     * Get nroAsuntoFiscal
     *
     * @return string 
     */
    public function getNroAsuntoFiscal()
    {
        return $this->nroAsuntoFiscal;
    }
}
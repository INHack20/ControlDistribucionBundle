<?php

namespace INHack20\UserBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity
 * @ORM\Table(name="Usuario")
 * @ORM\HasLifecycleCallbacks()
 */
class User extends BaseUser
{
    private $roles_definidos = array('ROLE_SUPER_ADMIN','ROLE_USER','ROLE_SUPER_USER','ROLE_ADMIN');

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="nombre", type="string", length=100, nullable=true)
     */
    protected $nombre;

    /**
     * @ORM\Column(name="apellido", type="string", length=100, nullable=true)
     */
    protected $apellido;

    /**
     * @ORM\Column(name="cedula", type="string", length=40, nullable=true)
     */
    protected $cedula;

    /**
     * @ORM\Column(name="cargo", type="string", length=255, nullable=true)
     */
    protected $cargo;
    
    /**
     * @ORM\column(name="unidadAdministrativa", type="string", length=150, nullable=true)
     */
    private $unidadAdministrativa;
 
    /**
     *
     * @var Estado $estado
     * @ORM\ManyToOne(targetEntity="INHack20\ControlDistribucionBundle\Entity\Estado")
     * @ORM\JoinColumn(name="estado_id",referencedColumnName="id")
     */
    protected $estado;

    /**
     * Variable para asignar rol al usuario
     */
    private $role;

    public function __construct()
    {
        parent::__construct();
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
     * @return User
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
        return $this;
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
     * Set apellido
     *
     * @param string $apellido
     * @return User
     */
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;
        return $this;
    }

    /**
     * Get apellido
     *
     * @return string 
     */
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * Set cedula
     *
     * @param string $cedula
     * @return User
     */
    public function setCedula($cedula)
    {
        $this->cedula = $cedula;
        return $this;
    }

    /**
     * Get cedula
     *
     * @return string 
     */
    public function getCedula()
    {
        return $this->cedula;
    }

    /**
     * Set cargo
     *
     * @param string $cargo
     * @return User
     */
    public function setCargo($cargo)
    {
        $this->cargo = $cargo;
        return $this;
    }

    /**
     * Get cargo
     *
     * @return string 
     */
    public function getCargo()
    {
        return $this->cargo;
    }

    /**
     * Set unidadAdministrativa
     *
     * @param string $unidadAdministrativa
     * @return User
     */
    public function setUnidadAdministrativa($unidadAdministrativa)
    {
        $this->unidadAdministrativa = $unidadAdministrativa;
        return $this;
    }

    /**
     * Get unidadAdministrativa
     *
     * @return string 
     */
    public function getUnidadAdministrativa()
    {
        return $this->unidadAdministrativa;
    }

    public function getRole() {
        return $this->role;
    }

    public function setRole($role) {
        $this->role = $role;
        if($role!=NULL && $role!='')
            $this->updateRoleUser();
    }
    
    /**
     * Permite actualizar el rol seleccionado en el Formulario de UserType
     * ORM\preUpdate
     */
    public function updateRoleUser(){
        
        foreach($this->getRoles() as $rol)
            {
                if($this->hasRole($rol))
                    $this->removeRole ($rol);
            }
        if(!$this->hasRole($this->role))
        {
            $this->addRole($this->role);
        }
    }
    /**
     * setea el rol del usuario actual
     * @ORM\postLoad
     */
    public function setRoleUser()
    {
        if(count($this->getRoles())==1){
            $this->setRole(static::ROLE_DEFAULT);
        }
        else{
            foreach($this->getRoles() as $rol)
                {
                    if($this->hasRole($rol) && $rol!=static::ROLE_DEFAULT){
                        $this->setRole($rol);
                    }
                }
        }
        
    }

    /**
     * Set estado
     *
     * @param INHack20\\ControlDistribucionBundle\\Entity\\Estado $estado
     */
    public function setEstado(\INHack20\ControlDistribucionBundle\Entity\Estado $estado)
    {
        $this->estado = $estado;
    }

    /**
     * Get estado
     *
     * @return INHack20\\ControlDistribucionBundle\\Entity\\Estado 
     */
    public function getEstado()
    {
        return $this->estado;
    }
}
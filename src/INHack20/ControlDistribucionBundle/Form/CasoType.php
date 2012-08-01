<?php

namespace INHack20\ControlDistribucionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\EntityRepository;

class CasoType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $estado = $this->estado;
        $builder
            ->add('procedencia','choice',array(
                'property_path' => false,
                'choices' => array('fiscalia' => 'Fiscalia','tribunal' => 'Tribunal'),
                'empty_value' => 'Seleccione',
            ))
            ->add('estado','entity',array(
                'class' => 'INHack20\\ControlDistribucionBundle\\Entity\\Estado',
                'property' => 'nombre',
                'empty_value' => 'Seleccione',
                'property_path' => false,
                'data' => $estado,
            ))
            ->add('fiscalia','entity',array(
                'class' => 'INHack20\\ControlDistribucionBundle\\Entity\\Fiscalia',
                'property' => 'nombre',
                'empty_value' => 'Seleccione',
                'label' => 'Fiscal&iacute;a',
                'query_builder' => function (EntityRepository $er) use ($estado){
                    return $er->createQueryBuilder('f')
                            ->where('f.estado = :estado')
                            ->setParameter('estado', $estado)
                            ;
                  },
            ))
            ->add('procedenciaTribunal','entity',array(
                'label' => 'Tribunal',
                'class' => 'INHack20\\ControlDistribucionBundle\\Entity\\Tribunal',
                'property' => 'descripcion',
                'empty_value' => 'Seleccione',
            ))
            ->add('acusacionPrivada',null,array(
                'label' => '¿Acusaci&oacute;n Privada?',
                'required' => false,
            ))
            ->add('nroAsuntoFiscal',null,array(
                'label' => 'N&deg; Causa',
                'read_only' => $this->read_only,
            ))
            ->add('nroOficioDesconocido','checkbox',array(
                'label' => '¿Desconocido?',
                'property_path' => false,
                'required' => false,
            ))  
            ->add('nroOficioFiscal',null,array(
                'label' => 'N&deg; Oficio',
            ))
            ->add('nombreImputadoDesconocido','checkbox',array(
                'label' => '¿Desconocido?',
                'property_path' => false,
                'required' => false,
            )) 
            ->add('nombreImputado',null,array(
                'label' => 'Nombre del Imputado',
            ))
            ->add('nombreVictimaDesconocido','checkbox',array(
                'label' => '¿Desconocido?',
                'property_path' => false,
                'required' => false,
            ))
            ->add('nombreVictima',null,array(
                'label' => 'Nombre de la V&iacute;ctima',
                
            ))
            ->add('pieza',null,array(
                'label' => 'Pieza(s)'
            ))
          
        ;
    }
    
    private $estado;
    private $read_only;
    public function __construct($estado = null, $read_only = false){
        $this->estado = $estado;
        $this->read_only = $read_only;
    }
    
    public function getName()
    {
        return 'inhack20_controldistribucionbundle_casotype';
    }
}

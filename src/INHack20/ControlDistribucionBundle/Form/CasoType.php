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
                'query_builder' => function (EntityRepository $er) use ($estado){
                    return $er->createQueryBuilder('f')
                            ->where('f.estado = :estado')
                            ->setParameter('estado', $estado)
                            ;

                }
            ))
            ->add('nroAsuntoFiscal',null,array(
                'label' => 'N&deg; Asunto Fiscal',
            ))
            ->add('nroOficioDesconocido','checkbox',array(
                'label' => '¿Desconocido?',
                'property_path' => false,
                'required' => false,
            ))  
            ->add('nroOficioFiscal',null,array(
                'label' => 'N&deg; Oficio Fiscal',
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
                'label' => 'Nombre de la Victima',
            ))
            ->add('pieza',null,array(
                'label' => 'Pieza(s)'
            ))
          
        ;
    }
    
    private $estado;
    public function __construct($estado = null){
        $this->estado = $estado;
    }
    
    public function getName()
    {
        return 'inhack20_controldistribucionbundle_casotype';
    }
}

<?php

namespace INHack20\ControlDistribucionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class CasoType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('estado','entity',array(
                'class' => 'INHack20\\ControlDistribucionBundle\\Entity\\Estado',
                'property' => 'nombre',
                'empty_value' => 'Seleccione',
                'property_path' => false,
            ))
            ->add('fiscalia','entity',array(
                'class' => 'INHack20\\ControlDistribucionBundle\\Entity\\Fiscalia',
                'property' => 'nombre',
                'empty_value' => 'Seleccione',
            ))
            ->add('nroAsuntoFiscal',null,array(
                'label' => 'N&deg; Asunto Fiscal',
            ))
            ->add('nroOficioFiscal',null,array(
                'label' => 'N&deg; Oficio Fiscal',
            ))
               
            ->add('nombreImputado',null,array(
                'label' => 'Nombre del Imputado',
            ))
            ->add('nombreImputadoDesconocido','checkbox',array(
                'label' => '¿Desconocido?',
                'property_path' => false,
                'required' => false,
            )) 
            ->add('nombreVictima',null,array(
                'label' => 'Nombre de la Victima',
            ))
            ->add('nombreVictimaDesconocido','checkbox',array(
                'label' => '¿Desconocido?',
                'property_path' => false,
                'required' => false,
            )) 
            ->add('pieza',null,array(
                'label' => 'Pieza(s)'
            ))
          
        ;
    }

    public function getName()
    {
        return 'inhack20_controldistribucionbundle_casotype';
    }
}

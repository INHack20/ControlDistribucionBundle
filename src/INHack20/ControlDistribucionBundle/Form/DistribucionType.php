<?php

namespace INHack20\ControlDistribucionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class DistribucionType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('tribunal','entity',array(
                'class' => 'INHack20\\ControlDistribucionBundle\\Entity\\Tribunal',
                'property' => 'descripcion',
                'empty_value' => 'Seleccione'
            ))
            ->add('causa','entity',array(
                'class' => 'INHack20\\ControlDistribucionBundle\\Entity\\Causa',
                'property' => 'nombre',
                'empty_value' => 'Seleccione',
            ))
        ;
    }

    public function getName()
    {
        return 'inhack20_controldistribucionbundle_distribuciontype';
    }
}

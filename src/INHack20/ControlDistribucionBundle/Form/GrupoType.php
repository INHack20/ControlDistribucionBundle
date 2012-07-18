<?php

namespace INHack20\ControlDistribucionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class GrupoType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('horarios','entity',array(
                'class' => 'INHack20\\ControlDistribucionBundle\\Entity\\Horario',
                'property'=>'descripcion',
                'multiple' => true
            ))
        ;
    }

    public function getName()
    {
        return 'inhack20_controldistribucionbundle_grupotype';
    }
}

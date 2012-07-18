<?php

namespace INHack20\ControlDistribucionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class TribunalType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('nro',null,array(
                'label' => 'N&deg; Tribunal'
            ))
            ->add('tribunalTipo','entity',array(
                'class' => 'INHack20\\ControlDistribucionBundle\\Entity\\TribunalTipo',
                'property' => 'nombre',
                'label' => 'Tribunal de ',
                'empty_value' => 'Seleccione'
            ))
        ;
    }

    public function getName()
    {
        return 'inhack20_controldistribucionbundle_tribunaltype';
    }
}

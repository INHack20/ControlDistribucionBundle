<?php

namespace INHack20\ControlDistribucionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class CausaType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('tribunalTipo','entity',array(
                'class' => 'INHack20\\ControlDistribucionBundle\\Entity\\TribunalTipo',
                'property' => 'nombre',
                'empty_value' => 'Seleccione',
                'label' => 'Tribunal De ',
            ))
            ->add('grupo','entity',array(
                'class' => 'INHack20\\ControlDistribucionBundle\\Entity\\Grupo',
                'property' => 'nombre',
                'empty_value' => 'Selecione',
            ))
        ;
    }

    public function getName()
    {
        return 'inhack20_controldistribucionbundle_causatype';
    }
}

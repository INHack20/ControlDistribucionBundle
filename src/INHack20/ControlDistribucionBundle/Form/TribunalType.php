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
                'label' => 'N&deg; Tribunal',
                'invalid_message' => 'Debe ingresar un numero entero',
                'error_bubbling' => false,
            ))
            ->add('tribunalTipo','entity',array(
                'class' => 'INHack20\\ControlDistribucionBundle\\Entity\\TribunalTipo',
                'property' => 'nombre',
                'label' => 'Tribunal de ',
                'empty_value' => 'Seleccione'
            ))
            ->add('despacho',null,array(
                'required' => false,
                'label' => '¿Hay Despacho?'
            ))
            ->add('grupo','entity',array(
                'label' => 'Grupo de Horario',
                'class' => 'INHack20\\ControlDistribucionBundle\\Entity\\Grupo',
                'property' => 'nombre',
                'empty_value' => 'Seleccione',
            ))
        ;
    }

    public function getName()
    {
        return 'inhack20_controldistribucionbundle_tribunaltype';
    }
}

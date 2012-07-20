<?php

namespace INHack20\ControlDistribucionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class FiscaliaType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('estado','entity',array(
                'class' => 'INHack20\\ControlDistribucionBundle\\Entity\\Estado',
                'property' => 'nombre',
                'empty_value' => 'Seleccione',
            ))
        ;
    }

    public function getName()
    {
        return 'inhack20_controldistribucionbundle_fiscaliatype';
    }
}

<?php

namespace INHack20\ControlDistribucionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class TribunalTipoType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('limitecausas',null,array(
                'label' => 'Limite de Causas'
            ))
        ;
    }

    public function getName()
    {
        return 'inhack20_controldistribucionbundle_tribunaltipotype';
    }
}

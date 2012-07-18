<?php

namespace INHack20\ControlDistribucionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class HorarioType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('dias')
            ->add('horaInicio','time',array(
                'input' => 'datetime',
                'widget' => 'choice',
                'empty_value' => '<>',
                //'hours' => range(1, 12),
            ))
            ->add('horaFin','time',array(
                'input' => 'datetime',
                'widget' => 'choice',
                'empty_value' => '<>',
                //'hours' => range(1, 12),
            ))
        ;
    }

    public function getName()
    {
        return 'inhack20_controldistribucionbundle_horariotype';
    }
}

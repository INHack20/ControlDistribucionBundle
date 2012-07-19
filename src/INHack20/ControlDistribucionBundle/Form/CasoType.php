<?php

namespace INHack20\ControlDistribucionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class CasoType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('procedencia')
            ->add('nroCausaFiscal')
            ->add('nroOficioFiscal')
            ->add('nombreImputado')
            ->add('nombreVictima')
            ->add('pieza')
            ->add('creado')
            ->add('actualizado')
            ->add('distribucion')
            ->add('fiscalia')
        ;
    }

    public function getName()
    {
        return 'inhack20_controldistribucionbundle_casotype';
    }
}

<?php

namespace INHack20\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class UserType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('email')
            ->add('nombre')
            ->add('apellido')
            ->add('cedula')
            ->add('cargo')
            ->add('unidadAdministrativa')
            ->add('estado','entity',array(
                'class' => 'INHack20\ControlDistribucionBundle\Entity\Estado',
                    'property' => 'nombre',
                    'empty_value' => 'Seleccione',
            ))
            ->add('enabled',null,array(
                'required' => false,
            ))
            ->add('locked',null,array(
                'required' => false,
            ))
            ->add('role', 'choice' , array(
                'choices' => array(
                    '' => 'Seleccione',
                    'ROLE_USER' => 'USUARIO',
                    'ROLE_SUPER_USER' => 'SUPER USUARIO',
                    'ROLE_ADMIN' => 'ADMINISTRADOR',
                    'ROLE_SUPER_ADMIN' => 'SUPER ADMINISTRADOR',
                    ),
                ))
        ;
       
    }

    public function getName()
    {
        return 'inhack20_user_profile';
    }
}

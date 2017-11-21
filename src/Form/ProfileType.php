<?php
/**
 * Created by PhpStorm.
 * User: Xtrazyx
 * Date: 29/09/2017
 * Time: 16:16
 */

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->remove('password')
        ->add('avatar', AvatarType::class, array(
            'label' => '',
            'required' => false)
            )
        ;
    }

    public function getParent()
    {
        return RegisterType::class;
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: Xtrazyx
 * Date: 29/09/2017
 * Time: 16:16
 */

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content', TextType::class, array('label' => 'Message'))
        ;
    }
}
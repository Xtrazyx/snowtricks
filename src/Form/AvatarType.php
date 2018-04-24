<?php
/**
 * Created by PhpStorm.
 * User: Xtrazyx
 * Date: 29/09/2017
 * Time: 16:16
 */

namespace App\Form;

use App\Entity\Avatar;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class AvatarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fileName', FileType::class, array(
                'label' => 'Champ facultatif. Choisissez une image carrée. 150*150px maximum.',
                'constraints' => new Image(array(
                    'maxWidth' => 150,
                    'maxHeight' => 150,
                    'allowLandscape' => false,
                    'allowPortrait' => false
                )),
                'empty_data' => 'uploads/default_avatar.jpg'
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
           'data_class' => Avatar::class
        ));
    }
}

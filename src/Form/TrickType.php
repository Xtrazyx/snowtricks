<?php
/**
 * Created by PhpStorm.
 * User: Xtrazyx
 * Date: 29/09/2017
 * Time: 16:16
 */

namespace App\Form;

use App\Entity\Trick;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrickType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'label' => 'Nom de la figure'
            ))
            ->add('description', TextareaType::class, array(
                'label' => 'Description',
                'attr' => array(
                    'rows' => 10
                )
            ))
            ->add('group', ChoiceType::class, array(
                'label' => 'Groupe',
                'choices' => $options['groups'],
                'choice_label' => 'name'
            ))
            ->add('trickImages', CollectionType::class, array(
                'label' => false,
                'required' => false,
                'entry_type' => TrickImageType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'entry_options' => array(
                    'label' => false,
                    'attr'=>array(
                        'class'=>'img-form')),
                'by_reference' => false
            ))
            ->add('videos', CollectionType::class, array(
                'label' => 'Vidéos : copiez l\'identifiant à la fin de l\'url de la vidéo. YouTube ou DailyMotion.',
                'entry_type' => VideoType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'entry_options' => array('label' => false, 'attr'=>array('class'=>'video-form')),
                'by_reference' => false
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Trick::class,
            'groups' => null
        ));
    }
}

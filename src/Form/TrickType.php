<?php
/**
 * Created by PhpStorm.
 * User: Xtrazyx
 * Date: 29/09/2017
 * Time: 16:16
 */

namespace App\Form;

use App\Entity\Group;
use App\Entity\Trick;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrickType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array('label' => 'Nom de la figure'))
            ->add('description', TextareaType::class, array('label' => 'Description'))
            ->add('group', ChoiceType::class, array(
                'label' => 'Groupe',
                'choices' => array(
                    'group1',
                    'group2'
                ) // TODO Get the choices from BDD
            ))
            ->add('trickImages', CollectionType::class, array(
                'entry_type' => FileType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'delete_empty' => true,
                'entry_options' => array(
                    'label' => 'Ajouter une image',
                    'empty_data' => NULL
                )
            ))
            ->add('videos', CollectionType::class, array(
                'entry_type' => FileType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'delete_empty' => true,
                'entry_options' => array(
                    'label' => 'Ajouter une vidéo',
                    'empty_data' => NULL
                )
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Trick::class
        ));
    }
}
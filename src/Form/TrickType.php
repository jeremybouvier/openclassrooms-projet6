<?php

namespace App\Form;

use App\Entity\Group;
use App\Entity\Trick;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
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
            ->add('name', TextType::class)
            ->add('description', TextareaType::class)
            ->add('group', EntityType::class, ['class' => Group::class, 'choice_label' => 'name'])
            ->add('videos', CollectionType::class, [
                "entry_type" =>VideoType::class,
                "allow_add" => true,
                "allow_delete" =>true,
                "by_reference" => false
            ])
            ->add('pictures', CollectionType::class, [
                "entry_type" =>PictureType::class,
                "allow_add" => true,
                "allow_delete" =>true,
                "by_reference" => false,

            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Trick::class,
            'translation_domain' => 'forms',
            'cascade_validation' => true
        ]);
    }
}

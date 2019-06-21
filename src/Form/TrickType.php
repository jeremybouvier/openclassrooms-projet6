<?php

namespace App\Form;

use App\Entity\File;
use App\Entity\Group;
use App\Entity\Trick;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
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
            ->add('name',TextType::class)
            ->add('description', TextareaType::class)
            ->add('groups', EntityType::class, ['class' => Group::class, 'choice_label' => 'name'])
            ->add('uploadedFiles', FileType::class,[
                'multiple'=>true,
                'label'=> "ajouter un fichier",
                'data_class'=> null,
                'required'=>false,
                'attr'=>['class'=>'fileSelect']])
        ;
        $builder
            ->add('medias', CollectionType::class, [
                "entry_type" => MediaType::class,
                "allow_add" => true,
                "allow_delete" =>true,
                "by_reference" => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Trick::class,
            'translation_domain' => 'forms'
        ]);
    }
}

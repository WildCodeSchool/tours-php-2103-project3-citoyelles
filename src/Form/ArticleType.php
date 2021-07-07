<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Image;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', ChoiceType::class, [
                'label' => 'Type d\'article :',
                'choices' => [
                    'Festiv\'Elles' => Article::TYPES[0],
                    'Citoy\'Elles' => Article::TYPES[1],
                    'Portr\'Elles' => Article::TYPES[2]
                ],
                'expanded' => true,
                'multiple' => false
            ])
            ->add('title', TextType::class, [
                'label' => 'Titre : '
            ])
            ->add('image', FileType::class, [
                'label' => 'Image (GIF, JPG, JPEG, PNG) : ',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new Image([
                        'maxSize' => '1024k',
                    ])
                ]
            ])
            ->add('youTubeLink', TextType::class, [
                'required' => false,
                'label' => 'Lien vidéo YouTube : ',
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Texte : '
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}

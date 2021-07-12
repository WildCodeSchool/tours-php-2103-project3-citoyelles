<?php

namespace App\Form;

use App\Entity\Calendar;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CalendarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', ChoiceType::class, [
                'label' => "Type d'évènement : ",
                'choices' => [
                    "Festiv'Elles" => Calendar::TYPES[0],
                    "Rencontres" => Calendar::TYPES[1],
                    "Citoy'Elles" => Calendar::TYPES[2]
                ],
                'expanded' => true,
                'multiple' => false
            ])
            ->add('title', TextType::class, [
                'label' => 'Titre : ',
                'attr' => ['placeholder' => 'Saisissez le titre.']
            ])
            ->add('date', DateTimeType::class, [
                'label' => 'Date : ',
                'date_widget' => 'single_text'
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Texte : ',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Le texte est optionnel.',
                    'rows' => 12,
                    'cols' => 26
                    ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Calendar::class,
        ]);
    }
}

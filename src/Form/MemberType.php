<?php

namespace App\Form;

use App\Entity\Member;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MemberType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom : '
            ])
            ->add('title', TextType::class, [
                'label' => 'Intitulé : '
            ])
            ->add('mission', TextType::class, [
                'label' => 'Mission : ',
                'required' => false
            ])
            ->add('phoneNumber', TextType::class, [
                'label' => 'Numéro de téléphone : ',
                'required' => false
            ])
            ->add('email', TextType::class, [
                'label' => 'E-mail : ',
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Member::class,
        ]);
    }
}

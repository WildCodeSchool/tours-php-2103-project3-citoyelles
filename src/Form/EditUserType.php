<?php

namespace App\Form;

use App\Service\UserService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class EditUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('oldUsername', TextType::class, [
                'required' => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('newUsername', RepeatedType::class, [
                'type' => TextType::class,
                'first_options' => [
                    'label' => 'Nouveau nom d\'utilisateur',
                ],
                'second_options' => [
                    'label' => 'Valider votre nom d\'utilisateur'
                ],
                'invalid_message' => 'Les deux noms d\'utilisateur doivent être identiques',
                'options' => [
                    'attr' => ['class' => 'form-control']
                ],
                'required' => false,

            ])
            ->add('oldPassword', PasswordType::class, [
                'required' => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('newPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'label' => 'Nouveau mot de passe',
                ],
                'second_options' => [
                    'label' => 'Valider votre mot de passe',
                ],
                'options' => [
                    'attr' => ['class' => 'form-control']
                ],
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserService::class,
        ]);
    }
}

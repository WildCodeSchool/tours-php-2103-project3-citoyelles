<?php

namespace App\Form;

use App\Entity\Membership;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class MembershipType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('year', DateType::class, [
                'widget' => 'choice',
                'html5' => false,
                'format' => 'dd / MM / yyyy',
                'required' => true
            ])
            ->add('pdf', FileType::class, [
                'label' => 'Bulletin d\'adhésion (PDF)',
                'mapped' => false,
                'required' => true,
                'constraints' => [
                    new File([
                        'maxSize' => '512k',
                        'mimeTypes' => [
                            'application/pdf'
                        ],
                        'mimeTypesMessage' => 'Veuillez enregistrer un PDF valide.',
                    ])
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Membership::class,
        ]);
    }
}

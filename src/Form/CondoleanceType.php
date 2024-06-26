<?php

namespace App\Form;

use App\Entity\Condoleance;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CondoleanceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('texte', CKEditorType::class, [
            'constraints' => [
                new Assert\NotBlank(['message' => 'Le message de condoléance ne peut pas être vide']),
            ],
            // 'required' => false,
        ])
        // ->add('texte', TextareaType::class, [
        //     'constraints' => [
        //         new Assert\NotBlank(['message' => 'Le message de condoléance ne peut pas être vide']),
        //     ]
        // ])
        ->add('submit', SubmitType::class, [
            'label' => 'Soumettre',
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Condoleance::class,
        ]);
    }
}

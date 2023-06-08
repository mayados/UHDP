<?php

namespace App\Form;

use Assert\NotBlank;
use App\Entity\Refuge;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class RefugeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Le nom ne peut pas être vide']),
                    new Assert\Length(['min' => 2, 'max' => 50, 'minMessage' => 'Le nom doit faire au moins {{ limit }} caractères', 'maxMessage' => 'Le nom ne peut pas faire plus de {{ limit }} caractères'])
                ]
            ])
            ->add('numero', TextType::class, [
                'required' => false,
                'constraints' => [
                    new Assert\Length(['max' => 10,'maxMessage' => 'Le numéro ne peut pas faire plus de {{ limit }} caractères'])
                ]
            ])
            ->add('rue', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(['message' => 'La rue ne peut pas être vide']),
                    new Assert\Length(['min' => 2, 'max' => 255, 'minMessage' => 'La rue doit faire au moins {{ limit }} caractères', 'maxMessage' => 'La rue ne peut pas faire plus de {{ limit }} caractères'])

                ]
            ])
            ->add('ville', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(['message' => 'La ville ne peut pas être vide']),
                    new Assert\Length(['min' => 2, 'max' => 255, 'minMessage' => 'La ville doit faire au moins {{ limit }} caractères', 'maxMessage' => 'La ville ne peut pas faire plus de {{ limit }} caractères'])
                ]
            ])
            ->add('codePostal', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Le code postal ne peut pas être vide']),
                    new Assert\Length(['min' => 2, 'max' => 10, 'minMessage' => 'Le code postal doit faire au moins {{ limit }} caractères', 'maxMessage' => 'Le code postal ne peut pas faire plus de {{ limit }} caractères'])
                ]
            ])
            ->add('departement', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Le département ne peut pas être vide']),
                    new Assert\Length(['min' => 2, 'max' => 255, 'minMessage' => 'Le département doit faire au moins {{ limit }} caractères', 'maxMessage' => 'Le département ne peut pas faire plus de {{ limit }} caractères'])
                ]
            ])
            ->add('site', TextType::class, [
                'required' => false,
            ])
            ->add('latitude', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(['message' => 'La latitude ne peut pas être vide']),
                ]
            ])
            ->add('longitude', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(['message' => 'La longitude ne peut pas être vide']),
                ]
            ])         
            ->add('submit', SubmitType::class, [
                'label' => 'Soumettre'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Refuge::class,
        ]);
    }
}

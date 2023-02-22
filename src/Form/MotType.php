<?php

namespace App\Form;

use App\Entity\MotCommemoration;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class MotType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('mot', TextareaType::class, [
                'label' => 'Mot',
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Le mot ne peut pas être nul']),
                    new Assert\Length(['min' => 4, 'max' => 500, 'minMessage' => 'Le mot doit faire au moins {{ limit }} caractères', 'maxMessage' => 'Le mot ne peut pas faire plus de {{ limit }} caractères'])
                ]
            ])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MotCommemoration::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\CategorieAnimal;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CategorieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Le genre doit avoir un nom']),
                    new Assert\Length(['min' => 2, 'max' => 50, 'minMessage' => 'Le nom de genre doit faire au moins {{ limit }} caractères', 'maxMessage' => 'Le nom de genre ne peut pas faire plus de {{ limit }} caractères'])
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Créer',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CategorieAnimal::class,
        ]);
    }
}

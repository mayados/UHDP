<?php

namespace App\Form;

use App\Entity\GenreHistoire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class GenreHistoireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Le genre doit avoir un nom']),
                    new Assert\Length(['min' => 2, 'max' => 50, 'minMessage' => 'Le genre doit faire au moins {{ limit }} caractères', 'maxMessage' => 'Le genre ne peut pas faire plus de {{ limit }} caractères'])
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
            'data_class' => GenreHistoire::class,
        ]);
    }
}

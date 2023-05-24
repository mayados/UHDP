<?php

namespace App\Form;

use App\Entity\MotCommemoration;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class MotType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('mot', CKEditorType::class, [
                'label' => false,
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Le mot ne peut pas être nul']),
                    new Assert\Length(['min' => 10, 'minMessage' => 'Le mot doit faire au moins {{ limit }} caractères'])
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Valider',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MotCommemoration::class,
        ]);
    }
}

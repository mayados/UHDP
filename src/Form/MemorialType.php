<?php

namespace App\Form;

use App\Entity\AnimalMemorial;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MemorialType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('sexe')
            ->add('dateNaissance')
            ->add('dateDeces')
            ->add('lieu')
            ->add('photo')
            ->add('presentation')
            ->add('chosesAimees')
            ->add('chosesDetestees')
            ->add('histoire')
            ->add('categorieAnimal')
            ->add('auteur')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AnimalMemorial::class,
        ]);
    }
}

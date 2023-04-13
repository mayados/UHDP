<?php

namespace App\Form;

use App\Data\SearchData;
use App\Entity\CategorieAnimal;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('q', TextType::class, [
                'label' => false,
                'required' => false,
                'empty_data' => '',
                'attr' => [
                'placeholder' => "Nom de l'animal" ,               
                ]
            ])
            ->add('categories', EntityType::class,[
                'label'=> false,
                'required' => false,
                'class' => CategorieAnimal::class,
                // Il faut mettre ce tag, car nous sommes dans le cas de checkboxes
                'expanded' => true,
                'multiple' => true,
            ])
            ->add('sexe', ChoiceType::class, [
                'choices' => [
                    'Male' => 'Male',
                    'Femelle' => 'Femelle',
                ],
                'expanded' => true,
                'multiple' => true,
                'label' => false,
            ])
            ->add('anneeDeces', ChoiceType::class, [
                'choices' => $this->buildYearChoices() ,
                'placeholder' => '',
                'required' => false,
                'label' => 'Année de décès ',
            ])
            ->add('moisDeces', ChoiceType::class, [
                'choices' => $this->buildMonthChoices(),
                'placeholder' => '',
                'required' => false,
                'label' => 'Mois de décès ',
            ])
            ->add('jourDeces',ChoiceType::class,[
                'choices' => range(0,31),
                'placeholder' => '',
                'required' => false,
                'label' => 'Jour de décès ',
            ])
            // ->add('submit', SubmitType::class)
        ;
    }

    public function buildYearChoices() {
        $distance = 30;
        $yearsBefore = date('Y', mktime(0, 0, 0, date("m"), date("d"), date("Y") - $distance));
        $yearsAfter = date('Y', mktime(0, 0, 0, date("m"), date("d"), date("Y")));
        return array_combine(range($yearsAfter, $yearsBefore), range($yearsAfter, $yearsBefore));
    }

    // public function buildMonthChoices() {
    //     $month = date('m', mktime(0, 0, 0, 1, 1, 2023));
    //     // dd($month);
    //     return array(range(date($month),12));
    // }

    public function buildMonthChoices() {

        $months = [
            'Janvier' => $this->monthToDate(1),
            'Février' => $this->monthToDate(2),
            'Mars' => $this->monthToDate(3),
            'Avril' => $this->monthToDate(4),
            'Mai' => $this->monthToDate(5),
            'Juin' => $this->monthToDate(6),
            'Juillet' => $this->monthToDate(7),
            'Aout' => $this->monthToDate(8),
            'Septembre' => $this->monthToDate(9),
            'Octobre' => $this->monthToDate(10),
            'Novembre' => $this->monthToDate(11),
            'Decembre' => $this->monthToDate(12)
        ];
        // $months = [
        //     'Janvier' => date('m', mktime(0, 0, 0, 1, 1, 2023)),
        //     'Février' => date('m', mktime(0, 0, 0, 2, 1, 2023)),
        //     'Mars' => date('m', mktime(0, 0, 0, 3, 1, 2023)),
        //     'Avril' => date('m', mktime(0, 0, 0, 4, 1, 2023)),
        //     'Mai' => date('m', mktime(0, 0, 0, 5, 1, 2023)),
        //     'Juin' => date('m', mktime(0, 0, 0, 6, 1, 2023)),
        //     'Juillet' => date('m', mktime(0, 0, 0, 7, 1, 2023)),
        //     'Aout' => date('m', mktime(0, 0, 0, 8, 1, 2023)),
        //     'Septembre' => date('m', mktime(0, 0, 0, 9, 1, 2023)),
        //     'Octobre' => date('m', mktime(0, 0, 0, 10, 1, 2023)),
        //     'Novembre' => date('m', mktime(0, 0, 0, 11, 1, 2023)),
        //     'Decembre' => date('m', mktime(0, 0, 0, 12, 1, 2023)),
        // ];
        
        // A revoir, car avec mktime les valeurs attribuées aux mois mois vont changées au cours du temps, sauf avec valeur fixe ?

        // dd($months);
       return $months;
    }

    public function monthToDate($month){
        return date('m', mktime(0, 0, 0, $month, 1, 2023));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Ici il ne s'agit pas d'une entité, mais d'une classe
            'data_class' => SearchData::class,
            'method' => 'GET',
            // Nous n'avons pas besoin d'un jetons CSRF car c'est du get
            'csrf_protection' => false,
        ]);
    }
}

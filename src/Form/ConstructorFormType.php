<?php

namespace App\Form;

use App\Entity\Season;
use App\Entity\Category;
use App\Entity\Constructor;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class ConstructorFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fullName', TextType::class, [
                'label' => 'Nom du constructeur *',
                'required' => false
            ])
            ->add('seasonTotalPoint', NumberType::class, [
                'label' => 'Nombre total de point *',
                'required' => false
            ])
            ->add('category', EntityType::class, [
                'label' => 'Catégorie de du construteur *',
                'class' => Category::class,
                'choice_label' => 'name',
                'required' => false
            ])
            ->add('currentSeason', EntityType::class, [
                'label' => "Année de participation *",
                'class' => Season::class,
                'choice_label' => 'years',
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Constructor::class,
        ]);
    }
}

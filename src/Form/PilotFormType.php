<?php

namespace App\Form;

use App\Entity\Pilot;
use App\Entity\Season;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class PilotFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fullName', TextType::class, [
                'label' => 'Nom du pilote *',
                'required' => false
            ])
            ->add('seasonTotalPoint', NumberType::class, [
                'label' => 'Nombre total de point *',
                'required' => false
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'label' => "Catégorie du pilote *",
                'required' => false
            ])
            ->add('currentSeason', EntityType::class, [
                'class' => Season::class,
                'choice_label' => 'years',
                'label' => "Année de l'évènement *",
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pilot::class,
        ]);
    }
}

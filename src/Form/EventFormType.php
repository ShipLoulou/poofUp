<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\Season;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class EventFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => "Nom de l'évènement *",
                'required' => false
            ])
            ->add('imageFile', VichImageType::class, [
                'label' => "Image de l'évènement *",
                'row_attr' => [
                    'class' => 'divVich'
                ],
                'required' => false
            ])
            ->add('startDate', DateType::class, [
                'widget' => 'single_text',
                'label' => "Début de l'évènement",
                'required' => false
            ])
            ->add('endDate', DateType::class, [
                'widget' => 'single_text',
                'label' => "Fin de l'évènement",
                'required' => false
            ])
            ->add('raceDate', DateType::class, [
                'widget' => 'single_text',
                'label' => "Date de la course *",
                'required' => false
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'label' => "Catégorie de l'évènement *",
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
            'data_class' => Event::class,
        ]);
    }
}

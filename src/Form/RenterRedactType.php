<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\MapPlace;
use App\Entity\Renter;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Tetranz\Select2EntityBundle\Form\Type\Select2EntityType;

class RenterRedactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('floor')
            ->add('categories',EntityType::class,[
                'class' => Category::class,
                'choice_label' => 'name',
                'multiple'=>true,
                'attr' => ['class' => 'form-control select2'],
            ])
            ->add('mapPlace',EntityType::class,[
                'class' => mapPlace::class,
                'choice_label' => 'id',
                'attr' => ['class' => 'form-control select2']
            ])
            ->add('description',TextareaType::class)
            ->add('logo_upload',FileType::class, ['data_class' => null,'required' => false])
            ->add('logo_grey_upload',FileType::class, ['data_class' => null,'required' => false])
            ->add('image_upload',FileType::class, ['data_class' => null,'required' => false])
            ->add('link')
            ->add('sort')
            ->add('active', CheckboxType::class,['empty_data'=>false,'required' => false])
            ->add('instagram')
            ->add('vk')
            ->add('facebook')
        ;


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Renter::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Action;
use App\Entity\Renter;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActionRedactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {


        $builder
            ->add('name')
            ->add('description',TextareaType::class)
            ->add('date_start',TextType::class)
            ->add('date_finish',TextType::class)
            ->add('link')
            ->add('photo_big_upload',FileType::class, ['data_class' => null,'required' => false])
            ->add('photo_small_upload',FileType::class, ['data_class' => null,'required' => false])
            ->add('instagram')
            ->add('vk')
            ->add('renters',EntityType::class,[
                'class' => Renter::class,
                'choice_label' => 'name',
                'multiple'=>true,
                'attr' => ['class' => 'form-control select2']
            ])
            ->add('facebook')
            ->add('sort')
            ->add('active', CheckboxType::class)
        ;
        $builder->get('date_start')
            ->addModelTransformer(new CallbackTransformer(
                function ($date_object) {
                    // преобразовать массив в строку
                    if (isset($date_object)) {
                        return $date_object->format('m/d/Y');
                    }
                },
                function ($date_str) {
                    // преобразовать строку обратно в массив
                    return \DateTime::createFromFormat('m/d/Y',$date_str);
                }
            ))
        ;
        $builder->get('date_finish')
            ->addModelTransformer(new CallbackTransformer(
                function ($date_object) {
                    // преобразовать массив в строку
                    if (isset($date_object)) {
                        return $date_object->format('m/d/Y');
                    }
                },
                function ($date_str) {
                    // преобразовать строку обратно в массив
                    return \DateTime::createFromFormat('m/d/Y',$date_str);
                }
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Action::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Feedback;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FeedbackType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class)
            ->add('email',EmailType::class)
            ->add('phone',TextType::class,['data_class' => null,'required' => false])
            ->add('type',ChoiceType::class,[
                'choices' =>[
                  'Обратная связь'=>1,
                    'Реклама в ТЦ'=>2,
                    'Предложения сотрудничества'=>3,
                    'Забытые вещи'=>4,
                    'Аренда торговых площадей'=>5,
                    'Пресса и съемка в ТЦ'=>6,
                    'Работа в ТЦ'=>7,
                    'Другое'=>8
                ],

            ])
            ->add('text',TextareaType::class)
            ->add('file',FileType::class,['data_class' => null,'required' => false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Feedback::class,
        ]);
    }
}

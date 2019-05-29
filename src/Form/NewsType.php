<?php

namespace App\Form;

use App\Entity\News;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('name')
            ->add('description',TextareaType::class)
            ->add('date',TextType::class)
            ->add('preview',FileType::class)
            ->add('image',FileType::class)
            ->add('instagram')
            ->add('vk')
            ->add('facebook')
            ->add('active', CheckboxType::class,['required'=>false])
        ;
        $builder->get('date')
            ->addModelTransformer(new CallbackTransformer(
                function ($date_object) {
                    // преобразовать массив в строку
                    if (isset($date_object)) {
                        return $date_object->format('m/d/Y');
                    }
                    $now = new \DateTime('now');
                    return $now->format('m/d/Y');
                },
                function ($date_str) {
                    // преобразовать строку обратно в массив
                    return \DateTime::createFromFormat('m/d/Y',$date_str);
                }
            ))
        ;
//        $builder->get('image')
//            ->addModelTransformer(new CallbackTransformer(
//                function ($image_str) {
//
//                       return new File($this->getParameter('upload_file').'/'.$image_str);
//
//                },
//                function ($image_object) {
//                    // преобразовать строку обратно в массив
//                    return $image_object;
//                }
//            ))
//        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => News::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\County;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CountyForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',null,[
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a name',
                    ]),
                ],
            ])

            ->add('taxRate',NumberType::class,[
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a number',
                    ]),
                ],
            ])

            ->add('income',NumberType::class,[
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter an income',
                    ]),
                ],
            ])

            ->add('save', SubmitType::class
                ,array('label'=>'add','attr'=>array('class'=>'btn btn-primary mt-3')))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => County::class,
        ]);
    }
}

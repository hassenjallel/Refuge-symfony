<?php

namespace AssoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use blackknight467\StarRatingBundle\Form\RatingType;
class questionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('val',ChoiceType::class  , [
                'choices' =>[
                    1 => 1 ,
                    2 => 2 ,
                    3 => 3 ,
                    4 => 4,
                    5 => 5 ,
                ],
                'expanded' => true,
                'multiple' => false,
            ]     )
          /*  ->add('save', SubmitType::class, [
                'attr' => ['class' => 'save'],
            ])*/
      ;

    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AssoBundle\Entity\question'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'assobundle_question';
    }


}

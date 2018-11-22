<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\Client;

class ClientFormType extends AbstractType{

    /**TODO move to the DB
     */
    private $titles = ['mr', 'ms', 'mrs', 'dr', 'mx'];

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $data['titles'] = $this->titles;
        $choices = array();
        foreach ($data['titles'] as $titleLabel) {
            $choices[$titleLabel] = $titleLabel;
        }

        $builder
            ->add('name', TextType::class , ['label' => 'Create','attr' => [ 'class' => 'medium-4  columns'] ])
            ->add('last_name', TextType::class,['attr' => [ 'class' => 'medium-4  columns'] ])
            ->add('title', ChoiceType::class, [
                'choices' => $choices
            ])
            ->add('address', TextType::class,['attr' => [ 'class' => 'medium-8  columns'] ])
            ->add('zip_code', IntegerType::class,['attr' => [ 'class' => 'medium-4  columns'] ])
            ->add('city', TextType::class,['attr' => [ 'class' => 'medium-4  columns'] ])
            ->add('state', TextType::class,['attr' => [ 'class' => 'medium-4  columns'] ])
            ->add('email', EmailType::class,['attr' => [ 'class' => 'medium-4  columns'] ])
            ->add('save', SubmitType::class, [ 'attr' => array('class' => 'button success hollow')])
            ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Client::class,
        ));
    }
}
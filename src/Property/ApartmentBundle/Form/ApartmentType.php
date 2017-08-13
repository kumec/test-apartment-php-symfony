<?php

namespace Property\ApartmentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ApartmentType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('countRooms')
            ->add('countBathrooms')
            ->add('square')
            ->add('hasParking')
            ->add('comment')
            ->add('unit')
            ->add('building')
            ->add('street')
            ->add('city')
            ->add('region')
            ->add('country')
            ->add('zipCode');

        if($options['method'] == 'POST'){
            $builder->add('ownerEmail');
        }


    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'        => 'Property\ApartmentBundle\Entity\Apartment',
            'csrf_protection'   => false,
            'allow_extra_fields' => true,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'property_apartmentbundle_apartment';
    }


}

<?php

namespace App\Form\Types;

use App\Entity\PostalAddress;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

/**
 * Class PostalAddressType
 *
 * @package App\Form\Type
 */
class PostalAddressType extends AbstractType
{

    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('name', TextType::class, array(
                'label'      => 'Nombre:',
                'required'   => TRUE,
                'help'       => '* Nombre identificativo de la dirección postal.',
            ))
            ->add('address', TextType::class, array(
                'label'      => 'Dirección:',
                'required'   => TRUE,
                'help'       => '* Dirección perteneciente a la dirección postal.',
            ))
            ->add('neighborhood', TextType::class, array(
                'label'      => 'Barrio:',
                'required'   => FALSE,
                'help'       => '* (Opcional) Barrio perteneciente a la dirección postal.',
            ))
            ->add('postalCode', IntegerType::class, array(
                'label'      => 'Código Postal:',
                'required'   => TRUE,
                'help'       => '* Código Postal perteneciente a la dirección postal.',
            ))
            ->add('population', TextType::class, array(
                'label'      => 'Población:',
                'required'   => TRUE,
                'help'       => '* Población perteneciente a la dirección postal.',
            ))
            ->add('province', TextType::class, array(
                'label'      => 'Provincia:',
                'required'   => TRUE,
                'help'       => '* Provincia perteneciente a la dirección postal.',
            ))
            ->add('state', TextType::class, array(
                'label'      => 'País o Estado:',
                'required'   => TRUE,
                'help'       => '* País o Estado perteneciente a la dirección postal.',
            ));

    }

    /**
     * @inheritDoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('data_class', PostalAddress::class)
            ->setDefault('class', NULL)
            ->setDefault('query_builder', NULL);
    }

}
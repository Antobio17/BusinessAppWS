<?php

namespace App\Form\Types;

use App\Entity\PostalAddress;
use App\Entity\Shift;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Class ShiftType
 *
 * @package App\Form\Type
 */
class ShiftType extends AbstractType
{

    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('weekDay', ChoiceType::class, array(
                'label' => 'Día:',
                'required' => TRUE,
                'disabled' => TRUE,
                'choices' => Shift::getDaysChoices(),
                'help' => '* Día para el turno de hora.',
            ))
            ->add('opensAt', TextType::class, array(
                'label' => 'Apertura:',
                'required' => TRUE,
                'disabled' => TRUE,
                'help' => '* Hora de apertura del turno (Formato: 09:00:00).',
            ))
            ->add('closesAt', TextType::class, array(
                'label' => 'Cierre:',
                'required' => TRUE,
                'disabled' => TRUE,
                'help' => '* Hora de cierre del turno (Formato: 14:00:00).',
            ));

    }

    /**
     * @inheritDoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('data_class', Shift::class)
            ->setDefault('class', NULL)
            ->setDefault('allow_add', NULL)
            ->setDefault('allow_delete', NULL)
            ->setDefault('delete_empty', NULL)
            ->setDefault('entry_options', NULL)
            ->setDefault('query_builder', NULL);
    }

}
<?php

namespace IDCI\Bundle\GroupActionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use IDCI\Bundle\GroupActionBundle\Action\GroupActionInterface;

class GroupActionType extends AbstractType
{
    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $groupAction = $options['group_action'];

        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
            $event->getForm()->add('ids');
        });

        $choices = array_combine($groupAction->getActions(), $groupAction->getActions());

        // Translate choice value
        foreach ($choices as $key => $value) {
            $choices[$key] = $this->translator->trans($value, array(), 'messages', 'fr');
        }

        $builder
            ->add('groupActionAlias', HiddenType::class, array(
                'data' => $groupAction->getAlias()
            ))
            ->add('actions', ChoiceType::class, array(
                'choices' => $choices,
            ))
            ->add('execute', SubmitType::class);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setRequired(array(
                'group_action'
            ))
            ->setAllowedTypes(array(
                'group_action' => array(GroupActionInterface::class)
            ))
            ->setDefaults(array(
                'translation_domain' => 'IDCIGroupActionBundle'
            ));
    }
}

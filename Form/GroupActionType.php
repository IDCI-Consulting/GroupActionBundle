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
use IDCI\Bundle\GroupActionBundle\Action\GroupActionRegistryInterface;

class GroupActionType extends AbstractType
{
    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var GroupActionRegistryInterface
     */
    private $registry;

    public function __construct(TranslatorInterface $translator, GroupActionRegistryInterface $registry)
    {
        $this->translator = $translator;
        $this->registry = $registry;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
            $event->getForm()->add('data');
        });

        foreach ($options['group_action_aliases'] as $alias) {
            $groupAction = $this->registry->getGroupAction($alias);
            $translatedGroupAction = $this->translator->trans(
                $groupAction,
                array(),
                $options['translation_domain'],
                $options['translation_locale']
            );

            $builder->add($alias, SubmitType::class, array_replace_recursive(
                array(
                    'label' => $translatedGroupAction,
                    'attr' => array('value' => $alias)
                ),
                $options['submit_button_options']
            ));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setRequired(array(
                'group_action_aliases',
            ))
            ->setDefined(array('submit_button_options', 'translation_locale'))
            ->setAllowedTypes(array(
                'group_action_aliases' => array('array'),
                'submit_button_options' => array('array'),
                'translation_locale' => array('string'),
            ))
            ->setDefaults(array(
                'allow_extra_fields' => true,
                'submit_button_options' => array(),
                'translation_domain' => 'IDCIGroupActionBundle',
                'translation_locale' => 'fr',
            ))
        ;
    }
}

<?php

namespace IDCI\Bundle\GroupActionBundle\Form;

use IDCI\Bundle\GroupActionBundle\Action\GroupActionRegistryInterface;
use IDCI\Bundle\GroupActionBundle\Guesser\GroupActionGuesserInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Validator\Constraints as Assert;

class GroupActionType extends AbstractType
{
    const QUERY_STRING_PARAMETER_NAME = 'idci_group_action';
    const CHECKBOX_FORM_ITEM_NAME = 'data';
    const CHOICE_FORM_NAME = 'grouped_actions';

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var GroupActionRegistryInterface
     */
    private $registry;

    /**
     * @var GroupActionGuesserInterface
     */
    private $groupActionGuesser;

    /**
     * @var bool
     */
    private $confirmationEnabled;

    public function __construct(
        TranslatorInterface          $translator,
        GroupActionRegistryInterface $registry,
        GroupActionGuesserInterface  $groupActionGuesser,
                                     $confirmationEnabled
    ) {
        $this->translator = $translator;
        $this->registry = $registry;
        $this->groupActionGuesser = $groupActionGuesser;
        $this->confirmationEnabled = $confirmationEnabled;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setMethod(Request::METHOD_POST)
            ->add(self::CHECKBOX_FORM_ITEM_NAME, ChoiceType::class, array(
                'choices' => $options['data'],
                'multiple' => true,
                'expanded' => true,
                'label' => false,
                'choice_label' => false,
                'constraints' => new Assert\NotBlank(),
            ))
        ;

        foreach ($options['actions'] as $action) {
            $builder
                ->add($action['action_alias'], SubmitType::class, array_replace_recursive(
                    array(
                        'attr' => array(
                            'value' => $action['action_alias'],
                        ),
                        'label' => $action['display_label'],
                    ),
                    $options['submit_button_options']
                ))
            ;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults(array(
                'actions' => array(),
                'data' => array(),
                'enable_confirmation' => $this->confirmationEnabled,
                'form_options' => array(),
                'namespace' => null,
                'submit_button_options' => array(),
                'csrf_protection' => false,
            ))
            ->setAllowedTypes('actions', array('array'))
            ->setAllowedTypes('data', array('array'))
            ->setAllowedTypes('enable_confirmation', array('bool'))
            ->setAllowedTypes('form_options', array('array'))
            ->setAllowedTypes('namespace', array('null', 'string'))
            ->setAllowedTypes('submit_button_options', array('array'))
            ->setNormalizer('actions', function (Options $options, $value) {
                if (null !== $options['namespace']) {
                    $value = array_merge(
                        $this->groupActionGuesser->guess($options['namespace']),
                        $value
                    );
                }

                return $value;
            })
            ->setNormalizer('form_options', function (Options $options, $value) {
                if ($options['enable_confirmation']) {
                    $value = array_replace_recursive(
                        array('attr' => array(
                            'data-confirm-action' => $this->translator->trans('group_action.confirm_action'),
                            'data-confirm-message' => $this->translator->trans('group_action.confirm_message'),
                        )),
                        $value
                    );
                }

                return $value;
            })
        ;
    }


    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'idci_group_action';
    }
}

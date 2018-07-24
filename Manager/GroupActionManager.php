<?php

namespace IDCI\Bundle\GroupActionBundle\Manager;

use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\TranslatorInterface;
use IDCI\Bundle\GroupActionBundle\Action\GroupActionRegistryInterface;
use IDCI\Bundle\GroupActionBundle\Form\GroupActionType;
use IDCI\Bundle\GroupActionBundle\Guesser\GroupActionGuesserInterface;

class GroupActionManager
{
    const QUERY_STRING_PARAMETER_NAME = 'idci_group_action';
    const CHECKBOX_FORM_ITEM_NAME = 'data';

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var GroupActionRegistryInterface
     */
    private $groupActionRegistry;

    /**
     * @var GroupActionGuesserInterface
     */
    private $groupActionGuesser;

    /**
     * @var bool
     */
    private $confirmationEnabled;

    /**
     * Constructor
     *
     * @param TranslatorInterface          $translator,
     * @param FormFactoryInterface         $formFactory,
     * @param GroupActionRegistryInterface $groupActionRegistry,
     * @param GroupActionGuesserInterface  $groupActionGuesser,
     * @param bool                         $confirmationEnabled
     */
    public function __construct(
        TranslatorInterface          $translator,
        FormFactoryInterface         $formFactory,
        GroupActionRegistryInterface $groupActionRegistry,
        GroupActionGuesserInterface  $groupActionGuesser,
                                     $confirmationEnabled
    ) {
        $this->translator = $translator;
        $this->formFactory = $formFactory;
        $this->groupActionRegistry = $groupActionRegistry;
        $this->groupActionGuesser = $groupActionGuesser;
        $this->confirmationEnabled = $confirmationEnabled;
    }

    /**
     * Gets the group action form identified by given alias.
     *
     * @param array $aliases The group action aliases.
     *
     * @return Symfony\Component\Form\FormInterface
     */
    public function createForm(array $options)
    {
        $resolver = new OptionsResolver();
        $this->configureOptions($resolver);
        $resolvedOptions = $resolver->resolve($options);

        $formBuilder = $this->formFactory->createNamedBuilder(
            self::QUERY_STRING_PARAMETER_NAME,
            FormType::class,
            null,
            $resolvedOptions['form_options']
        );

        $formBuilder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
            $event->getForm()->add(self::CHECKBOX_FORM_ITEM_NAME);
        });

        foreach ($resolvedOptions['actions'] as $actionAlias) {
            $groupAction = $this->groupActionRegistry->getAction($actionAlias);

            $formBuilder->add($actionAlias, SubmitType::class, array_replace_recursive(
                array(
                    'attr' => array(
                        'value' => $actionAlias
                    ),
                    'label' => $actionAlias,
                ),
                $resolvedOptions['submit_button_options']
            ));
        }

        $formBuilder->setMethod(Request::METHOD_POST);

        return $formBuilder->getForm();
    }

    protected function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults(array(
                'actions' => array(),
                'enable_confirmation' => $this->confirmationEnabled,
                'form_options' => array(),
                'namespace' => null,
                'submit_button_options' => array(),
            ))
            ->setAllowedTypes('actions', array('array'))
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
     * Returns whether the given request has action to execute.
     *
     * @param Request $request
     *
     * @return bool
     */
    public function hasAction(Request $request)
    {
        return $request->request->has(self::QUERY_STRING_PARAMETER_NAME);
    }

    /**
     * Executes group actions with given data.
     *
     * @param Request $request
     * @param Form    $form
     * @param array   $data
     *
     * @return mixed
     */
    public function execute(Request $request, Form $form, array $data)
    {
        if (!$request->isMethod(Request::METHOD_POST)) {
            throw new MethodNotAllowedException(array(Request::METHOD_POST));
        }

        $form->handleRequest($request);
        if ($form->isValid()) {
            $groupAction = $this
                ->groupActionRegistry
                ->getAction($form->getClickedButton()->getName())
            ;

            $selectedData = is_array($form->get('data')->getData()) ? $form->get('data')->getData() : array();
            $data = $this->filterData($data, $selectedData);

            return $groupAction->execute($data);
        }

        return false;
    }

    /**
     * Filter data with given indexes.
     *
     * @param array $data
     * @param array $indexes
     *
     * @return array
     */
    private function filterData(array $data, array $indexes)
    {
        $i = 1;
        $filteredData = array();

        foreach ($data as $datum) {
            if (in_array($i, $indexes)) {
                $filteredData[] = $datum;
            }

            ++$i;
        }

        return $filteredData;
    }
}

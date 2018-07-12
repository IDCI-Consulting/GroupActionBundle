<?php

namespace IDCI\Bundle\GroupActionBundle\Manager;

use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use IDCI\Bundle\GroupActionBundle\Action\GroupActionRegistryInterface;
use IDCI\Bundle\GroupActionBundle\Form\GroupActionType;

class GroupActionManager
{
    const GROUP_ACTION = 'group_action';

    /**
     * @var GroupActionRegistryInterface
     */
    private $registry;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var Request
     */
    private $request;

    /**
     * Constructor
     *
     * @param GroupActionRegistryInterface $registry
     * @param FormFactoryInterface         $formFactory
     */
    public function __construct(
        GroupActionRegistryInterface $registry,
        FormFactoryInterface $formFactory,
        RequestStack $requestStack
    ) {
        $this->registry = $registry;
        $this->formFactory = $formFactory;
        $this->request = $requestStack->getCurrentRequest();
    }

    /**
     * Gets the group action form identified by given alias.
     *
     * @param array $aliases The group action aliases.
     *
     * @return Symfony\Component\Form\FormInterface
     */
    public function getForm(array $aliases, array $options = array())
    {
        $options = array_merge(
            $options,
            array(
                'group_action_aliases' => $aliases
            )
        );

        $formBuilder = $this
            ->formFactory
            ->createBuilder(GroupActionType::class, null, $options)
        ;

        $formBuilder->setMethod(Request::METHOD_POST);

        return $formBuilder->getForm();
    }

    /**
     * Builds the group action form with given request
     *
     * @param Request $request The http request.
     *
     * @return Symfony\Component\Form\FormInterface
     */
    public function buildForm(Request $request)
    {
        $data = $request->request->get('group_action');
        foreach($data as $key => $value) {
            if (!in_array($key, array('data', '_token')) && $this->registry->hasGroupAction($value)) {
                return $this->getForm(array($value));
            }
        }

        return false;
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
        return $request->request->has(self::GROUP_ACTION);
    }

    /**
     * Executes group actions with given data.
     *
     * @param Request $request
     * @param array   $data
     *
     * @return mixed
     */
    public function execute(Request $request, array $data)
    {
        if (!$request->isMethod(Request::METHOD_POST)) {
            throw new MethodNotAllowedException(array(Request::METHOD_POST));
        }

        $form = $this->buildForm($request);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $groupAction = $this
                ->registry
                ->getGroupAction($form->getClickedButton()->getName())
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

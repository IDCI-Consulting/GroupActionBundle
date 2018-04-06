<?php

namespace IDCI\Bundle\GroupActionBundle\Manager;

use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use IDCI\Bundle\GroupActionBundle\Action\GroupActionRegistryInterface;

class GroupActionManager
{
    /**
     * @var GroupActionRegistryInterface
     */
    private $registry;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var Router
     */
    private $router;

    /**
     * Constructor
     *
     * @param GroupActionRegistryInterface $registry
     * @param FormFactoryInterface         $formFactory
     * @param Router                       $router
     */
    public function __construct(
        GroupActionRegistryInterface $registry,
        FormFactoryInterface $formFactory,
        Router $router
    ) {
        $this->registry = $registry;
        $this->formFactory = $formFactory;
        $this->router = $router;
    }

    /**
     * Gets the group action form identified by given alias.
     *
     * @param string $alias The group action alias.
     *
     * @return Symfony\Component\Form\FormInterface
     */
    public function getForm($alias)
    {
        $formBuilder = $this
            ->formFactory
            ->createBuilder('group_action', null, array(
                'group_action' => $this->registry->getGroupAction($alias)
            ));

        $formBuilder
            ->setAction($this->router->generate('execute_group_action'))
            ->setMethod('POST');

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
        $alias = $data['groupActionAlias'];

        return $this->getForm($alias);
    }
}

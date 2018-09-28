<?php

namespace IDCI\Bundle\GroupActionBundle\Manager;

use IDCI\Bundle\GroupActionBundle\Action\GroupActionRegistryInterface;
use IDCI\Bundle\GroupActionBundle\Guesser\GroupActionGuesserInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Translation\TranslatorInterface;

class GroupActionManager
{
    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var GroupActionRegistryInterface
     */
    private $groupActionRegistry;

    /**
     * Constructor.
     *
     * @param RequestStack                 $requestStack,
     * @param GroupActionRegistryInterface $groupActionRegistry,
     */
    public function __construct(RequestStack $requestStack, GroupActionRegistryInterface $groupActionRegistry)
    {
        $this->requestStack = $requestStack;
        $this->groupActionRegistry = $groupActionRegistry;
    }

    /**
     * Returns whether the current request has action to execute.
     *
     * @return bool
     */
    public function hasAction()
    {
        return $this->requestStack->getCurrentRequest()->has(self::QUERY_STRING_PARAMETER_NAME);
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
    public function execute(Form $form)
    {
        if (!$this->requestStack->getCurrentRequest()->isMethod(Request::METHOD_POST)) {
            throw new MethodNotAllowedException(array(Request::METHOD_POST));
        }

        if ($form->isValid()) {
            $groupAction = $this
                ->groupActionRegistry
                ->getAction($form->getClickedButton()->getName())
            ;

            return $groupAction->execute($form->get('data')->getData());
        }

        return false;
    }
}

<?php

namespace IDCI\Bundle\GroupActionBundle\Manager;

use IDCI\Bundle\GroupActionBundle\Action\GroupActionRegistryInterface;
use IDCI\Bundle\GroupActionBundle\Form\GroupActionType;
use IDCI\Bundle\GroupActionBundle\Guesser\GroupActionGuesserInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Contracts\Translation\TranslatorInterface;

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
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * Constructor.
     *
     * @param RequestStack                 $requestStack,
     * @param GroupActionRegistryInterface $groupActionRegistry,
     */
    public function __construct(
        RequestStack $requestStack,
        GroupActionRegistryInterface $groupActionRegistry,
        TranslatorInterface $translator
    ) {
        $this->requestStack = $requestStack;
        $this->groupActionRegistry = $groupActionRegistry;
        $this->translator = $translator;
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
            $groupActionName = null;

            if (null !== $form->getClickedButton()) {
                $groupActionName = $form->getClickedButton()->getName();
            }

            if ($form->has(GroupActionType::CHOICE_FORM_NAME)) {
                $groupActionName = $form->get(GroupActionType::CHOICE_FORM_NAME)->getData();
            }

            $groupAction = $this
                ->groupActionRegistry
                ->getAction($groupActionName)
            ;

            return $groupAction->execute($form->get('data')->getData());
        }

        return false;
    }

    public function executeGroupAction(Request $request, Form $groupActionForm)
    {
        $groupActionForm->handleRequest($request);

        if ($groupActionForm->isSubmitted()) {
            if ($groupActionForm->isValid()) {
                try {
                    return $this->execute($groupActionForm);
                } catch (\Exception $e) {
                    $this->requestStack->getSession()->getFlashBag()->add('error', $e->getMessage());

                    return;
                }
            }

            $this->requestStack->getSession()->getFlashBag()->add('error', $this->translator->trans('error.no_items_checked'));
        }
    }
}

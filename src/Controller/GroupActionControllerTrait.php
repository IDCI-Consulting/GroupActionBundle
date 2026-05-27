<?php

namespace IDCI\Bundle\GroupActionBundle\Controller;

use IDCI\Bundle\GroupActionBundle\Manager\GroupActionManager;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Translation\TranslatorInterface;

trait GroupActionControllerTrait
{
    private $manager;
    private $translator;

    public function __construct(GroupActionManager $manager, TranslatorInterface $translator)
    {
        $this->manager = $manager;
        $this->translator = $translator;
    }

    public function executeGroupAction(Request $request, Form $groupActionForm)
    {
        $groupActionForm->handleRequest($request);

        if ($groupActionForm->isSubmitted()) {
            if ($groupActionForm->isValid()) {
                try {
                    return $this->manager->execute($groupActionForm);
                } catch (\Exception $e) {
                    $this->addFlash('error', $e->getMessage());

                    return;
                }
            }

            $this->addFlash('error', $this->translator->trans('error.no_items_checked'));
        }
    }
}

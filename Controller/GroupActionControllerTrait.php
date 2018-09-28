<?php

namespace IDCI\Bundle\GroupActionBundle\Controller;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

trait GroupActionControllerTrait
{
    public function executeGroupAction(Request $request, Form $groupActionForm)
    {
        $groupActionForm->handleRequest($request);
        if ($groupActionForm->isSubmitted()) {
            if ($groupActionForm->isValid()) {
                $result = $this->container->get('idci.group_action.manager')->execute($groupActionForm);

                return $result;
            }

            $this->addFlash('error', 'flash.invalid_form');
        }
    }
}

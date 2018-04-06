<?php

namespace IDCI\Bundle\GroupActionBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class GroupActionController extends Controller
{
    /**
     * @Route("/execute_group_action", name="execute_group_action")
     * @Method({"POST"})
     */
    public function executeGroupAction(Request $request)
    {
        $form = $this->get('idci.group_action.manager')->buildForm($request);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $groupAction = $this
                ->get('idci.group_action.registry')
                ->getGroupAction($form->get('groupActionAlias')->getData());

            $ids = is_array($form->get('ids')->getData()) ? $form->get('ids')->getData() : array();

            // TODO: put the following code into a try & catch
            call_user_func_array(
                array(
                    $groupAction,
                    sprintf('%s%s', 'execute', $form->get('actions')->getData())
                ),
                array($ids)
            );
        }

        // Redirect to previous URL
        return $this->redirect($request->headers->get('referer'));
    }
}

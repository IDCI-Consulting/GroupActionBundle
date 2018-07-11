<?php

namespace IDCI\Bundle\GroupActionBundle\Twig;

use Twig\Extension\AbstractExtension;
use Symfony\Component\Form\FormRenderer;
use IDCI\Bundle\GroupActionBundle\Manager\GroupActionManager;

class GroupActionExtension extends AbstractExtension
{
    /**
     * @var GroupActionManager
     */
    private $groupActionManager;

    /**
     * @var FormRenderer
     */
    private $renderer;

    public function __construct(GroupActionManager $groupActionManager, FormRenderer $renderer)
    {
        $this->groupActionManager = $groupActionManager;
        $this->renderer = $renderer;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction(
                'group_action_form_start',
                array($this, 'groupActionFormStart'),
                array('is_safe' => array('html'))
            ),
            new \Twig_SimpleFunction(
                'group_action_form_end',
                array($this, 'groupActionFormEnd'),
                array('is_safe' => array('html'))
        ),
    );
    }

    public function groupActionFormStart(array $aliases, array $options = array())
    {
        $form = $this->groupActionManager->getForm($aliases, $options);

        return $this->renderer->renderBlock($form->createView(), 'form_start');
    }

    public function groupActionFormEnd(array $aliases, array $options = array())
    {
        $form = $this->groupActionManager->getForm($aliases, $options);

        return $this->renderer->renderBlock($form->createView(), 'form_end');
    }
}

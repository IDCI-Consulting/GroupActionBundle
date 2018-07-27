<?php

namespace IDCI\Bundle\GroupActionBundle\Twig;

use Twig\Extension\AbstractExtension;
use Symfony\Component\Form\FormRenderer;
use Symfony\Component\Form\FormView;
use IDCI\Bundle\GroupActionBundle\Manager\GroupActionManager;

class GroupActionExtension extends AbstractExtension
{
    /**
     * @var \Twig_Environment
     */
    private $twig;

    public function __construct(\Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction(
                'add_group_action_checkbox',
                array($this, 'addGroupActionCheckBox'),
                array('is_safe' => array('html'))
            ),
            new \Twig_SimpleFunction(
                'add_group_action_handler',
                array($this, 'addGroupActionHandler'),
                array('is_safe' => array('html'))
            ),
        );
    }

    /**
     * Add a checkbox to the given FormView.
     *
     * @param mixed $index
     */
    public function addGroupActionCheckBox($index)
    {
        print $this->twig->render('IDCIGroupActionBundle:Form:group_action_checkbox.html.twig', array(
            'index' => $index,
        ));
    }

    /**
     * Add a checkbox to the given FormView.
     */
    public function addGroupActionHandler()
    {
        print $this->twig->render('IDCIGroupActionBundle:Form:group_action_handler.html.twig');
    }
}

<?php

namespace IDCI\Bundle\GroupActionBundle\Twig;

use Twig\Extension\AbstractExtension;

class GroupActionExtension extends AbstractExtension
{
    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction(
                'add_group_action_checkbox',
                array($this, 'addGroupActionCheckBox'),
                array(
                    'is_safe' => array('html'),
                    'needs_environment' => true,
                )
            ),
            new \Twig_SimpleFunction(
                'add_group_action_handler',
                array($this, 'addGroupActionHandler'),
                array(
                    'is_safe' => array('html'),
                    'needs_environment' => true,
                )
            ),
        );
    }

    /**
     * Add a checkbox to the given FormView.
     *
     * @param \Twig_Environment $twig
     * @param mixed             $index
     */
    public function addGroupActionCheckBox(\Twig_Environment $twig, $index)
    {
        echo $twig->render('IDCIGroupActionBundle:Form:group_action_checkbox.html.twig', array(
            'index' => $index,
        ));
    }

    /**
     * Add a checkbox to the given FormView.
     *
     * @param \Twig_Environment $twig
     */
    public function addGroupActionHandler(\Twig_Environment $twig)
    {
        echo $twig->render('IDCIGroupActionBundle:Form:group_action_handler.html.twig');
    }
}

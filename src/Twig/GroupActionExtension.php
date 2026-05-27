<?php

namespace IDCI\Bundle\GroupActionBundle\Twig;

use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class GroupActionExtension extends AbstractExtension
{
    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            new TwigFunction(
                'add_group_action_checkbox',
                array($this, 'addGroupActionCheckBox'),
                array(
                    'is_safe' => array('html'),
                    'needs_environment' => true,
                )
            ),
            new TwigFunction(
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
     * @param Environment $twig
     * @param mixed             $index
     */
    public function addGroupActionCheckBox(Environment $twig, $index)
    {
        echo $twig->render('IDCIGroupActionBundle:Form:group_action_checkbox.html.twig', array(
            'index' => $index,
        ));
    }

    /**
     * Add a checkbox to the given FormView.
     *
     * @param Environment $twig
     */
    public function addGroupActionHandler(Environment $twig)
    {
        echo $twig->render('IDCIGroupActionBundle:Form:group_action_handler.html.twig');
    }
}

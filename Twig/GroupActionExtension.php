<?php

namespace IDCI\Bundle\GroupActionBundle\Twig;

use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class GroupActionExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction(
                'add_group_action_checkbox',
                [$this, 'addGroupActionCheckBox'],
                [
                    'is_safe' => ['html'],
                    'needs_environment' => true,
                ]
            ),
            new TwigFunction(
                'add_group_action_handler',
                [$this, 'addGroupActionHandler'],
                [
                    'is_safe' => ['html'],
                    'needs_environment' => true,
                ]
            ),
        ];
    }

    /**
     * Add a checkbox to the given FormView.
     */
    public function addGroupActionCheckBox(Environment $twig, $index)
    {
        echo $twig->render('IDCIGroupActionBundle:Form:group_action_checkbox.html.twig', [
            'index' => $index,
        ]);
    }

    /**
     * Add a checkbox to the given FormView.
     */
    public function addGroupActionHandler(Environment $twig)
    {
        echo $twig->render('IDCIGroupActionBundle:Form:group_action_handler.html.twig');
    }
}

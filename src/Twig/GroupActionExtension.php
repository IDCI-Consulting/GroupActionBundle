<?php

namespace IDCI\Bundle\GroupActionBundle\Twig;

use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class GroupActionExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction(
                'add_group_action_checkbox',
                [
                    $this,
                    'addGroupActionCheckBox'
                ],
                [
                    'is_safe' => ['html'],
                    'needs_environment' => true,
                ]
            ),
            new TwigFunction(
                'add_group_action_handler',
                [
                    $this,
                    'addGroupActionHandler'
                ],
                [
                    'is_safe' => ['html'],
                    'needs_environment' => true,
                ]
            ),
        ];
    }

    public function addGroupActionCheckBox(Environment $twig, mixed $index): void
    {
        echo $twig->render('IDCIGroupActionBundle:Form:group_action_checkbox.html.twig', array(
            'index' => $index,
        ));
    }

    public function addGroupActionHandler(Environment $twig): void
    {
        echo $twig->render('IDCIGroupActionBundle:Form:group_action_handler.html.twig');
    }
}

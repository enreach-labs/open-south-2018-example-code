<?php

/**
 * This file is part of the EasyImpress package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller;

use Orbitale\Bundle\EasyImpressBundle\Impress\EasyImpress;
use Orbitale\Bundle\EasyImpressBundle\Model\Presentation;
use Twig\Environment;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class PresentationController
{
    /**
     * @var EasyImpress
     */
    private $impress;

    /**
     * @var Environment
     */
    private $twig;

    /**
     * @var string
     */
    private $layout;

    public function __construct($layout, EasyImpress $impress, Environment $twig)
    {
        $this->impress = $impress;
        $this->twig = $twig;
        $this->layout = $layout;
    }

    /**
     * @Route("/presentations/{presentationName}")
     */
    public function presentation($presentationName)
    {
        /** @var Presentation $presentation */
        $presentation = $this->impress->getPresentation($presentationName);

        if (!$presentation) {
            throw new NotFoundHttpException('Presentation "'.$presentationName.'" not found.');
        }

        return new Response($this->twig->render('impress/presentation.html.twig', [
            'layout'       => $this->layout,
            'presentation' => $presentation,
        ]));
    }
}

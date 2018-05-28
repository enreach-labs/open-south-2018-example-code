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
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Twig\Environment;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class PresentationController extends Controller
{

    /**
     * @Route("/presentation")
     */
    public function presentation()
    {

        return $this->render("impress/presentation.html.twig", [
            'layout'       => "impress/layout.html.twig",
            'slides' => 2,
        ]);
    }
}

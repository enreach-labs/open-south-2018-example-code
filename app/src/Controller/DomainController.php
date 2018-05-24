<?php
namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controller used to test domains.
 *
 * @Route("/domain")
 *
 */
class DomainController extends Controller
{
    /**
     * @Route("/", name="domain_index", host="example.com")
     */
    public function domainAction()
    {
        return Response::create('DOMAIN example.com');
    }

    /**
     * @Route("/", name="subdomain_index", host="{subdomain}.example.com")
     */
    public function subdomainAction($subdomain)
    {
        return Response::create('SUBDOMAIN '.$subdomain);
    }

}

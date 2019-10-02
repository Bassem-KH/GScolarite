<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }


    /**
     * @Route("/user/test", name="testroleuser")
     */
    public function testRoleUserAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $listeClasses = $em->createQuery(" SELECT p FROM AppBundle:Classe p ORDER BY p.cursus")->getResult();
        $listeCursus = $em->createQuery(" SELECT p FROM AppBundle:Cursus p ")->getResult();

        $this->denyAccessUnlessGranted('ROLE_USER');
        // replace this example code with whatever you need
        return $this->render('Exemple_Role/user.twig.html',array('classes'=>$listeClasses,'cursus'=>$listeCursus));

    }

    /**
     * @Route("/admin/test", name="testroleadmin")
     */
    public function testRoleAdminAction(Request $request)
    {
        {
            $this->denyAccessUnlessGranted('ROLE_ADMIN');

            // replace this example code with whatever you need
            return $this->render('Exemple_Role/admin.twig.html');

        }
    }
}

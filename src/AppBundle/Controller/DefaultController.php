<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="step1")
     */
    public function step1Action(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render(
            'default/step1.html.twig',
            [
                'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
            ]
        );
    }
    
    /**
     * @Route("/step2", name="step2")
     */
    public function step2Action(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render(
            'default/step2.html.twig',
            [
                'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
            ]
        );
    }
    
    /**
     * @Route("/step3", name="step3")
     */
    public function step3Action(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render(
            'default/step1.html.twig',
            [
                'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
            ]
        );
    }
}

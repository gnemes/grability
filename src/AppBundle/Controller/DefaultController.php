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
        $breadcum = array(
            "step1" => "active",
            "step2" => "",
            "step3" => "",
            "step4" => "",
            "step5" => "",
        );
        
        return $this->render(
            'default/step1.html.twig',
            [
                'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
                'breadcum' => $breadcum,
            ]
        );
    }
    
    /**
     * @Route("/step2", name="step2")
     */
    public function step2Action(Request $request)
    {
        // Get test case object
        $testCases = $request->request->get('testCase');

        $breadcum = array(
            "step1" => "completed",
            "step2" => "active",
            "step3" => "",
            "step4" => "",
            "step5" => "",
        );
        
        return $this->render(
            'default/step2.html.twig',
            [
                'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
                'breadcum' => $breadcum,
                'testCases' => addslashes($testCases),
            ]
        );
    }
    
    /**
     * @Route("/step3", name="step3")
     */
    public function step3Action(Request $request)
    {
        // Get test case object
        $testCases = $request->request->get('testCase');
        
        $breadcum = array(
            "step1" => "completed",
            "step2" => "completed",
            "step3" => "active",
            "step4" => "",
            "step5" => "",
        );
        
        return $this->render(
            'default/step3.html.twig',
            [
                'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
                'breadcum' => $breadcum,
                'testCases' => addslashes($testCases),
            ]
        );
    }
    
   /**
     * @Route("/step4", name="step4")
     */
    public function step4Action(Request $request)
    {
        // Get test case object
        $testCases = $request->request->get('testCase');
        
        $breadcum = array(
            "step1" => "completed",
            "step2" => "completed",
            "step3" => "completed",
            "step4" => "active",
            "step5" => "",
        );
        
        return $this->render(
            'default/step4.html.twig',
            [
                'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
                'breadcum' => $breadcum,
                'testCases' => addslashes($testCases),
            ]
        );
    }    
}

<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;



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
        $session = $request->getSession();
        
        // Get test case object
        $testCases = $request->request->get('testCase');

        // Set test cases quantity into session
        $session->set("testCases", $testCases);
        
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
        $session = $request->getSession();
        
        // Get test cases quantity from request
        $matrixSizes = $request->request->get('matrixSizes');
        
        // Set test cases quantity into session
        $session->set("matrixSizes", $matrixSizes);
        
        // Get test cases quantity into session
        $testCases = $session->get("testCases");
        
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
                'testCases' => $testCases,
                'matrixSizes' => json_encode(array_reverse($matrixSizes)),
            ]
        );
    }
    
   /**
     * @Route("/step4", name="step4")
     */
    public function step4Action(Request $request)
    {
        $session = $request->getSession();
        
        // Get test cases quantity from request
        $matrixSizesOperations = $request->request->get('matrixSizesOperations');
        
        // Set test cases quantity into session
        $session->set("matrixSizesOperations", $matrixSizesOperations);
        
echo "Result:: ".var_export($matrixSizesOperations, true);        
        
        // Get test cases quantity into session
        $testCases = $session->get("testCases");
        
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
                'testCases' => $testCases,
                'matrixSizes' => json_encode(array_reverse($matrixSizes)),
            ]
        );
    }    
}

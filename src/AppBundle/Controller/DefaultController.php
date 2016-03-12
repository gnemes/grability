<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

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
    
    /**
     * @Route("/step5", name="step5")
     */
    public function step5Action(Request $request)
    {
        // Get test case object
        $testCases = $request->request->get('testCase');
        
        $breadcum = array(
            "step1" => "completed",
            "step2" => "completed",
            "step3" => "completed",
            "step4" => "completed",
            "step5" => "active",
        );
        
        // JSON decode
        $testCasesDecoded = json_decode($testCases);
        
        // Matrices container
        $matrices = array();
        while (!is_null($matrixData = array_shift($testCasesDecoded->matrices))) {
            // Create matrix
            $matrixService = $this->get("Matrix");
            
        }
        
        $testCases = json_encode($testCasesDecoded);
        
        return $this->render(
            'default/step4.html.twig',
            [
                'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
                'breadcum' => $breadcum,
                'testCases' => addslashes($testCases),
            ]
        );
    }
    
    /**
     * @Route("/validate/operations", name="validateOperations")
     */
    public function validateOperationsAction(Request $request)
    {
        $commands = $request->request->get('commands');
        $size = $request->request->get('size');
        $operations = $request->request->get('operations');
        
        $matrix = $this->get("Matrix");
        
        $result = $matrix->parseOperations($commands, $size, $operations);

        $response = new JsonResponse();
        $response->setData($result);
        
        return $response;
    }
}

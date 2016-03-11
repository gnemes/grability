<?php

namespace AppBundle\Tests\Matrix;

use AppBundle\Matrix\Matrix;

class MatrixTest extends \PHPUnit_Framework_TestCase
{
    public function testInvalidMoreOperationsQuantity()
    {
        // Matrix instance
        $matrix = new Matrix();

        $commands = "UPDATE 1 1 1 4\n"
                . "UPDATE 2 1 2 5\n"
                . "QUERY 1 1 1 2 2 2\n";
        
        $expected = array(
            "errorCode" => 1, 
            "errorString" => "Expected 2 commands, but 3 commands found.",
            "data" => array()
        );
        
        $this->assertEquals($expected, $matrix->parseOperations($commands, 2, 2));
    }
    
    public function testInvalidLessOperationsQuantity()
    {
        // Matrix instance
        $matrix = new Matrix();

        $commands = "UPDATE 1 1 1 4\n"
                . "UPDATE 2 1 2 5\n"
                . "QUERY 1 1 1 2 2 2\n";
        
        $expected = array(
            "errorCode" => 1, 
            "errorString" => "Expected 4 commands, but 3 commands found.",
            "data" => array()
        );
        
        $this->assertEquals($expected, $matrix->parseOperations($commands, 2, 4));
    }
    
    public function testInvalidOperationNameQuantity()
    {
        // Matrix instance
        $matrix = new Matrix();

        $commands = "UPDATE 1 1 1 4\n"
                . "INVALID 2 1 2 5\n"
                . "QUERY 1 1 1 2 2 2\n";
        
        $expected = array(
            "errorCode" => 2, 
            "errorString" => "Error in operation 2: Unknown operation.",
            "data" => array()
        );
        
        $this->assertEquals($expected, $matrix->parseOperations($commands, 2, 3));
    }
    
    public function testMoreUpdateArgumentsQuantity()
    {
        // Matrix instance
        $matrix = new Matrix();

        $commands = "UPDATE 1 1 1 4 5\n"
                . "UPDATE 2 1 2 5\n"
                . "QUERY 1 1 1 2 2 2\n";
        
        $expected = array(
            "errorCode" => 3, 
            "errorString" => "Invalid arguments quantity for UPDATE command. 4 expected but found 5 arguments",
            "data" => array()
        );
        
        $this->assertEquals($expected, $matrix->parseOperations($commands, 2, 3));
    }
    
    public function testLessUpdateArgumentsQuantity()
    {
        // Matrix instance
        $matrix = new Matrix();

        $commands = "UPDATE 1 1 1\n"
                . "UPDATE 2 1 2 5\n"
                . "QUERY 1 1 1 2 2 2\n";
        
        $expected = array(
            "errorCode" => 3, 
            "errorString" => "Invalid arguments quantity for UPDATE command. 4 expected but found 3 arguments",
            "data" => array()
        );
        
        $this->assertEquals($expected, $matrix->parseOperations($commands, 2, 3));
    }
    
    public function testUpdateInvalidPosition()
    {
        // Matrix instance
        $matrix = new Matrix();

        $commands = "UPDATE a 1 c 10\n"
                . "UPDATE 2 1 2 5\n"
                . "QUERY 1 1 1 2 2 2\n";
        
        $expected = array(
            "errorCode" => 4, 
            "errorString" => "Invalid arguments for UPDATE command. Expected a position in the matrix but (A, 1, C) not is a valid position.",
            "data" => array()
        );
        
        $this->assertEquals($expected, $matrix->parseOperations($commands, 2, 3));
    }
    
    public function testUpdateInvalidValue()
    {
        // Matrix instance
        $matrix = new Matrix();

        $commands = "UPDATE 1 1 1 a\n"
                . "UPDATE 2 1 2 5\n"
                . "QUERY 1 1 1 2 2 2\n";
        
        $expected = array(
            "errorCode" => 5, 
            "errorString" => "Invalid arguments for UPDATE command. Expected an integer value to set. The value A is invalid.",
            "data" => array()
        );
        
        $this->assertEquals($expected, $matrix->parseOperations($commands, 2, 3));
    }
    
    /**
     * @dataProvider updateInvalidPositionOutOfRangeProvider
     */
    public function testUpdateInvalidPositionOutOfRange($x, $y, $z)
    {
        // Matrix instance
        $matrix = new Matrix();

        // Matrix size
        $size = 3;
        
        $commands = "UPDATE ".$x." ".$y." ".$z." 10\n";
        
        $expected = array(
            "errorCode" => 4, 
            "errorString" => "Invalid arguments for UPDATE command. Expected a position in the matrix but (".$x.", ".$y.", ".$z.") not is a valid position.",
            "data" => array()
        );
        
        $this->assertEquals($expected, $matrix->parseOperations($commands, 1, $size));
    }
    
    public function updateInvalidPositionOutOfRangeProvider()
    {
        return array(
            array(4, 1, 1),
            array(1, 4, 1),
            array(1, 1, 4)
        );
    }
}

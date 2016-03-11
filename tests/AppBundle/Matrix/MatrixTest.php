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
        
        $this->assertEquals($expected, $matrix->parseOperations($commands, $size, 1));
    }
    
    public function updateInvalidPositionOutOfRangeProvider()
    {
        return array(
            array(4, 1, 1),
            array(1, 4, 1),
            array(1, 1, 4),
            array(0, 0, 0),
            array(0, 1, 1),
            array(1, 0, 1),
            array(1, 1, 0)
        );
    }
    
    public function testUpdateCommandsSuccess()
    {
        // Matrix instance
        $matrix = new Matrix();

        $commands = "UPDATE 1 1 1 10\n"
                . "UPDATE 2 2 1 5\n"
                . "UPDATE 3 2 1 2\n"
                . "UPDATE 1 3 1 3\n";
        
        $data = array(
            array(
                "type" => "UPDATE",
                "x" => 1,
                "y" => 1,
                "z" => 1,
                "value" => 10
            ),
            array(
                "type" => "UPDATE",
                "x" => 2,
                "y" => 2,
                "z" => 1,
                "value" => 5
            ),
            array(
                "type" => "UPDATE",
                "x" => 3,
                "y" => 2,
                "z" => 1,
                "value" => 2
            ),
            array(
                "type" => "UPDATE",
                "x" => 1,
                "y" => 3,
                "z" => 1,
                "value" => 3
            ),
        );
        
        $expected = array(
            "errorCode" => 0, 
            "errorString" => "success",
            "data" => $data
        );
        
        $this->assertEquals($expected, $matrix->parseOperations($commands, 3, 4));
    }
    
    public function testMoreQueryArgumentsQuantity()
    {
        // Matrix instance
        $matrix = new Matrix();

        $commands = "QUERY 1 1 1 2 2 2 2\n";
        
        $expected = array(
            "errorCode" => 6, 
            "errorString" => "Invalid arguments quantity for QUERY command. 6 expected but found 7 arguments",
            "data" => array()
        );
        
        $this->assertEquals($expected, $matrix->parseOperations($commands, 2, 1));
    }
    
    public function testLessQueryArgumentsQuantity()
    {
        // Matrix instance
        $matrix = new Matrix();

        $commands = "QUERY 1 1 1 2\n";
        
        $expected = array(
            "errorCode" => 6, 
            "errorString" => "Invalid arguments quantity for QUERY command. 6 expected but found 4 arguments",
            "data" => array()
        );
        
        $this->assertEquals($expected, $matrix->parseOperations($commands, 2, 1));
    }
    
    /**
     * @dataProvider queryInvalidPositionArgumentsProvider
     */
    public function testQueryInvalidPositionArguments($x1, $y1, $z1, $x2, $y2, $z2, $size)
    {
        // Matrix instance
        $matrix = new Matrix();

        $commands = "QUERY ".$x1." ".$y1." ".$z1." ".$x2." ".$y2." ".$z2."\n";
        
        $expected = array(
            "errorCode" => 7, 
            "errorString" => "Invalid arguments for QUERY command. Expected a position in the matrix but (".$x1.", ".$y1.", ".$z1.") or (".$x2.", ".$y2.", ".$z2.") not is a valid position.",
            "data" => array()
        );
        
        $this->assertEquals($expected, $matrix->parseOperations($commands, $size, 1));
    }
    
    public function queryInvalidPositionArgumentsProvider()
    {
        return array(
            array(4, 1, 1, 1, 1, 1, 3),
            array(1, 4, 1, 1, 1, 1, 3),
            array(1, 1, 4, 1, 1, 1, 3),
            array(1, 1, 1, 4, 1, 1, 3),
            array(1, 1, 1, 1, 4, 1, 3),
            array(1, 1, 1, 1, 1, 4, 3),
            array('A', 1, 1, 1, 1, 1, 3),
            array(1, 'A', 1, 1, 1, 1, 3),
            array(1, 1, 'A', 1, 1, 1, 3),
            array(1, 1, 1, 'A', 1, 1, 3),
            array(1, 1, 1, 1, 'A', 1, 3),
            array(1, 1, 1, 1, 1, 'A', 3),
        );
    }
    
    /**
     * @dataProvider queryBreakConstraintPositionArgumentsProvider
     */
    public function testQueryBreakConstraintPositionArguments($x1, $y1, $z1, $x2, $y2, $z2, $size)
    {
        // Matrix instance
        $matrix = new Matrix();

        $commands = "QUERY ".$x1." ".$y1." ".$z1." ".$x2." ".$y2." ".$z2."\n";
        
        $expected = array(
            "errorCode" => 8, 
            "errorString" => "Invalid arguments for QUERY command. The constraints are: x1 <= x2, y1 <= y2, z1 <= z2, but (".$x1.", ".$y1.", ".$z1.") and (".$x2.", ".$y2.", ".$z2.") break this rule.",
            "data" => array()
        );
        
        $this->assertEquals($expected, $matrix->parseOperations($commands, $size, 1));
    }
    
    public function queryBreakConstraintPositionArgumentsProvider()
    {
        return array(
            array(3, 1, 1, 1, 1, 1, 3),
            array(1, 3, 1, 1, 1, 1, 3),
            array(1, 1, 3, 1, 1, 1, 3),
        );
    }

    public function testQueryCommandsSuccess()
    {
        // Matrix instance
        $matrix = new Matrix();

        $commands = "QUERY 1 1 1 3 3 3\n"
                . "QUERY 2 2 2 3 3 3\n"
                . "QUERY 1 2 1 2 3 1\n"
                . "QUERY 3 2 1 3 3 3\n";
        
        $data = array(
            array(
                "type" => "QUERY",
                "x1" => 1,
                "y1" => 1,
                "z1" => 1,
                "x2" => 3,
                "y2" => 3,
                "z2" => 3,
            ),
            array(
                "type" => "QUERY",
                "x1" => 2,
                "y1" => 2,
                "z1" => 2,
                "x2" => 3,
                "y2" => 3,
                "z2" => 3,
            ),
            array(
                "type" => "QUERY",
                "x1" => 1,
                "y1" => 2,
                "z1" => 1,
                "x2" => 2,
                "y2" => 3,
                "z2" => 1,
            ),
            array(
                "type" => "QUERY",
                "x1" => 3,
                "y1" => 2,
                "z1" => 1,
                "x2" => 3,
                "y2" => 3,
                "z2" => 3,
            ),
        );
        
        $expected = array(
            "errorCode" => 0, 
            "errorString" => "success",
            "data" => $data
        );
        
        $this->assertEquals($expected, $matrix->parseOperations($commands, 3, 4));
    }
}

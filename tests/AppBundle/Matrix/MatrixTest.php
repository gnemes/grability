<?php

namespace AppBundle\Tests\Matrix;

use AppBundle\Matrix\Matrix;

class MatrixTest extends \PHPUnit_Framework_TestCase
{
    public function testInvalidOperationsQuantity()
    {
        // Matrix instance
        $matrix = new Matrix();

        $commands = "UPDATE 1 1 1 4\n"
                . "UPDATE 2 1 2 5\n"
                . "QUERY 1 1 1 2 2 2\n";
                
        $expected = "Expected 2 commands, but 3 commands found.";
        
        $this->assertEquals(json_encode($expected), $matrix->parseOperations($commands, 2, 2));
    }
}

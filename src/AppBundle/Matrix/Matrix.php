<?php

namespace AppBundle\Matrix;

class Matrix
{
    /**
     * Matrix size
     *
     * @var integer
     */
    protected $size = 0;
    
    /**
     * Number of operations to be performed in this matrix
     *
     * @var integer
     */
    protected $operations = 0;
    
    /**
     * Commands or operations for this matrix
     *
     * @var array
     */
    protected $commands = array();
    
    /**
     * Parse operations and validate them
     * 
     * @param string  $commands   Operations in string format
     * @param integer $size       Matrix size
     * @param integer $operations Operations quantity
     * 
     * @return JSON
     */
    public function parseOperations($commands, $size, $operations)
    {
        // Fill vars
        $this->size = $size;
        $this->operations = $operations;
        
        // Result init
        $result = array();
        $result["errorCode"] = 0; 
        $result["errorString"] = "success";
        $result["data"] = array();
        
        // Explode commands by end of line delimiter
        $ops = explode("\n", trim($commands));
        
        $opsQty = count($ops);
        if (($opsQty < $this->operations) || ($opsQty > $this->operations)) {
            $result["errorCode"] = 1; 
            $result["errorString"] = "Expected ".$this->operations." commands, but ".$opsQty." commands found.";
        } else {
            for ($i = 0; ($i < $opsQty && $result["errorCode"] == 0); $i++) {
                $explodedOp = explode(" ", strtoupper($ops[$i]));

                switch ($explodedOp[0]) {
                    case "UPDATE":
                        // Update operation
                        break;
                    case "QUERY":
                        // Query operation
                        break;
                    default:
                        $result["errorCode"] = 1; 
                        $result["errorString"] = "Error in operation ".($i+1).": Unknown operation.";
                        break;
                }
            }
        }
        
        error_log("In the service :: ".var_export($ops, true)."\n", 3, "/tmp/german.log");
        
        return $result;
    }
}
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
                        $update = $this->_parseUpdateCommand($explodedOp);
                        if ($update["errorCode"] != 0) {
                            $result["errorCode"] = $update["errorCode"]; 
                            $result["errorString"] = $update["errorString"];
                        }
                        break;
                    case "QUERY":
                        // Query operation
                        break;
                    default:
                        $result["errorCode"] = 2; 
                        $result["errorString"] = "Error in operation ".($i+1).": Unknown operation.";
                        break;
                }
            }
        }
        
        error_log("In the service :: ".var_export($ops, true)."\n", 3, "/tmp/german.log");
        
        return $result;
    }
    
    private function _parseUpdateCommand($command)
    {
        $result = array();
        $result["errorCode"] = 0;
        $result["errorString"] = 'success';
        
        // Remove the UPDATE from the command arguments
        $commandQty = count($command) - 1;
        if ($commandQty != 4) {
            $result["errorCode"] = 3;
            $result["errorString"] = 'Invalid arguments quantity for UPDATE command. 4 expected but found '.$commandQty.' arguments';
        } else {
            $update = array();
            $update["x"] = $command[1];
            $update["y"] = $command[2];
            $update["z"] = $command[3];
            
            if (!is_int($update["x"]) || !is_int($update["y"]) || !is_int($update["z"])) {
                $result["errorCode"] = 4;
                $result["errorString"] = 'Invalid arguments for UPDATE command. ';
                $result["errorString"] .= 'Expected a position in the matrix but ('.$update["x"].', '.$update["y"].', '.$update["z"].') not is a valid position.';
            }
        }
        
        return $result;
    }
}
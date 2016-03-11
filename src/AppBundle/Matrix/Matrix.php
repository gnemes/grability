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
                        $result["errorCode"] = $update["errorCode"]; 
                        $result["errorString"] = $update["errorString"];
                        
                        if ($result["errorCode"] == 0) {
                            array_push($result["data"], $update["data"]);
                        } else {
                            $result["data"] = array();
                        }
                        break;
                    case "QUERY":
                        // Query operation
                        break;
                    default:
                        $result["errorCode"] = 2; 
                        $result["errorString"] = "Error in operation ".($i+1).": Unknown operation.";
                        if ($result["errorCode"] != 0) {
                            $result["data"] = array();
                        }
                        break;
                }
            }
        }
        error_log(var_export($result, true)."\n", 3, "/tmp/german.log");        
        return $result;
    }
    
    private function _parseUpdateCommand($command)
    {
        $result = array();
        $result["errorCode"] = 0;
        $result["errorString"] = 'success';
        $result["data"] = array();
        
        // Remove the UPDATE from the command arguments
        $commandQty = count($command) - 1;
        if ($commandQty != 4) {
            $result["errorCode"] = 3;
            $result["errorString"] = 'Invalid arguments quantity for UPDATE command. 4 expected but found '.$commandQty.' arguments';
        } else {
            $update = array();
            $update["type"] = 'UPDATE';
            $update["x"] = (int) $command[1];
            $update["y"] = (int) $command[2];
            $update["z"] = (int) $command[3];
            $update["value"] = (int) $command[4];
            
            // Validations
            if (
                $update["x"] == 0 || 
                $update["y"] == 0 || 
                $update["z"] == 0 ||
                $update["x"] > $this->size || 
                $update["y"] > $this->size || 
                $update["z"]  > $this->size     
            ) {
                $result["errorCode"] = 4;
                $result["errorString"] = 'Invalid arguments for UPDATE command. ';
                $result["errorString"] .= 'Expected a position in the matrix but ('.$command[1].', '.$command[2].', '.$command[3].') not is a valid position.';
            } else if ($update["value"] == 0 && trim($command[4]) != "0") {
                $result["errorCode"] = 5;
                $result["errorString"] = 'Invalid arguments for UPDATE command. ';
                $result["errorString"] .= 'Expected an integer value to set. The value '.$command[4].' is invalid.';
            } else {
                // Everything is ok!
                $result["data"] = $update;
            }
        }
        
        return $result;
    }
}
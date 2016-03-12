<?php

namespace AppBundle\Matrix;

class Matrix
{
    /**
     * Actual matrix
     *
     * @var Matrix 
     */
    protected $matrix = array();
    
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
     * Output history
     *
     * @var array
     */
    protected $outputHistory = array();
    
    /**
     * Init matrix filling the vector to 0 in all the positions
     * 
     * @return void
     */
    private function _initMatrix()
    {
        $positions = ($this->size * $this->size * $this->size);
        $this->matrix = array_fill(0, $positions, 0);
    }
    
    /**
     * Returns the vectorized matrix
     * 
     * @return array
     */
    public function getVectorizedMatrix()
    {
        return $this->matrix;
    }
    
    /**
     * Set matrix size
     * 
     * @param integer $size Matrix size
     * 
     * @return void
     */
    public function setSize($size)
    {
        $this->size = $size;
        
        // Empty matrix
        $this->_initMatrix();
        
        // Clear history
        $this->outputHistory = array();
    }
    
    /**
     * The index calculation its done by the next formula:
     * 
     * (x-1) . n^2 + (y-1) . n^1 + (z-1) . n^0
     * 
     * Being n the size of the N x N matrix
     * 
     * @param integer $x X position
     * @param integer $y Y position
     * @param integer $z Z position
     * 
     * @return integer
     */
    private function _getIndex($x, $y, $z)
    {
        if (($x > $this->size) || ($y > $this->size) || ($z > $this->size)) {
            $index = false;
        } else {
            $index = ($x-1) * pow($this->size, 2);
            $index += ($y-1) * $this->size;
            $index += ($z-1);
        }
        
        return $index;
    }
    
    /**
     * Get output history
     * 
     * @return array
     */
    public function getOutputHistory()
    {
        return $this->outputHistory;
    }
    
    /**
     * In this test, because we want to query for elements
     * between positions, it's so much easy vectorizing the matrix.
     * 
     * See: https://en.wikipedia.org/wiki/Vectorization_(mathematics)
     * 
     * @param integer $x     X position
     * @param integer $y     Y position
     * @param integer $z     Z position
     * @param integer $value Position value
     * 
     * @return integer
     */
    public function update($x, $y, $z, $value)
    {
        $index = $this->_getIndex($x, $y, $z);
        
        if ($index !== false) {
            $this->matrix[$index] = $value;

            array_push($this->outputHistory, "UPDATE ".$x." ".$y." ".$z." ".$value);
            array_push($this->outputHistory, $value);
        } else {
            $value = false;
        }
        
        return $value;
    }
    
    /**
     * Query the sum of index from (x1,y1,z1) to (x2,y2,z2)
     * 
     * @param integer $x1 X1 position
     * @param integer $y1 Y1 position
     * @param integer $z1 Z1 position
     * @param integer $x2 X2 position
     * @param integer $y2 Y2 position
     * @param integer $z2 Z2 position
     * 
     * @return mixed
     */
    public function query($x1, $y1, $z1, $x2, $y2, $z2)
    {
        $startIndex = $this->_getIndex($x1, $y1, $z1);
        $endIndex = $this->_getIndex($x2, $y2, $z2);
error_log("QUERY :: ".$x1.",". $y1.",".$z1.",". $x2.",". $y2.",". $z2.",".$startIndex.",".$endIndex."\n",3,"/tmp/german.log");        
        if (($startIndex === false) || ($endIndex === false)) {
            // Invalid positions
            return false;
        } else if ($startIndex > $endIndex) {
            // Start greater than end
            return false;
        } else {
            // + 1 to contemplate the inclusion of the last position
            $positions = ($endIndex - $startIndex + 1);
            $query = array_slice ($this->matrix, $startIndex, $positions, true);
            $sum = array_sum($query);
            
            return $sum;
        }
    }
    
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
                        $query = $this->_parseQueryCommand($explodedOp);
                        $result["errorCode"] = $query["errorCode"]; 
                        $result["errorString"] = $query["errorString"];
                        
                        if ($result["errorCode"] == 0) {
                            array_push($result["data"], $query["data"]);
                        } else {
                            $result["data"] = array();
                        }
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
               
        return $result;
    }
    
    /**
     * Parse query command
     * 
     * @param array $command Command
     * 
     * @return array
     */
    private function _parseQueryCommand($command)
    {
        $result = array();
        $result["errorCode"] = 0;
        $result["errorString"] = 'success';
        $result["data"] = array();
        
        // Remove the UPDATE from the command arguments
        $commandQty = count($command) - 1;
        if ($commandQty != 6) {
            $result["errorCode"] = 6;
            $result["errorString"] = 'Invalid arguments quantity for QUERY command. 6 expected but found '.$commandQty.' arguments';
        } else {
            $query = array();
            $query["type"] = 'QUERY';
            $query["x1"] = (int) $command[1];
            $query["y1"] = (int) $command[2];
            $query["z1"] = (int) $command[3];
            $query["x2"] = (int) $command[4];
            $query["y2"] = (int) $command[5];
            $query["z2"] = (int) $command[6];
            
            // Validations
            if (
                $query["x1"] == 0 || 
                $query["y1"] == 0 || 
                $query["z1"] == 0 ||
                $query["x1"] > $this->size || 
                $query["y1"] > $this->size || 
                $query["z1"] > $this->size ||
                $query["x2"] == 0 || 
                $query["y2"] == 0 || 
                $query["z2"] == 0 ||
                $query["x2"] > $this->size || 
                $query["y2"] > $this->size || 
                $query["z2"] > $this->size    
            ) {
                $result["errorCode"] = 7;
                $result["errorString"] = 'Invalid arguments for QUERY command. ';
                $result["errorString"] .= 'Expected a position in the matrix but ('.$command[1].', '.$command[2].', '.$command[3].') or ('.$command[4].', '.$command[5].', '.$command[6].') not is a valid position.';
            } else if (
                $query["x1"] > $query["x2"] || 
                $query["y1"] > $query["y2"] || 
                $query["z1"] > $query["z2"]  
            ) { 
                $result["errorCode"] = 8;
                $result["errorString"] = 'Invalid arguments for QUERY command. ';
                $result["errorString"] .= 'The constraints are: x1 <= x2, y1 <= y2, z1 <= z2, but ('.$command[1].', '.$command[2].', '.$command[3].') and ('.$command[4].', '.$command[5].', '.$command[6].') break this rule.';
            } else {
                // Everything is ok!
                $result["data"] = $query;
            }
        }
        
        return $result;
    }
    
    /**
     * Parse update command
     * 
     * @param array $command Command
     * 
     * @return array
     */
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
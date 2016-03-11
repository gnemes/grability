<?php

namespace AppBundle\Matrix;

class Matrix
{
    public function parseOperations($commands, $size, $operations)
    {
        $result = array();
        $result["errorCode"] = 0; 
        $result["errorString"] = "success";
        $result["data"] = array();
        
        $ops = explode("\n", $commands);
        
        $data = array();
        $opsQty = count($ops);
        
        if (($opsQty < $operations) || ($opsQty > $operations)) {
            $result["errorCode"] = 1; 
            $result["errorString"] = "Expected ".$operations." commands, but ".$opsQty." commands found.";
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
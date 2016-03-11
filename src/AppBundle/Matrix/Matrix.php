<?php

namespace AppBundle\Matrix;

class Matrix
{
    public function parseOperations($operations)
    {
        $result = array();
        $result["status"] = "success";
        $result["data"] = array();
        
        $ops = explode("\n", $operations);
        
        error_log("In the service :: ".var_export($ops, true)."\n", 3, "/tmp/german.log");
        
        return $result;
    }
}
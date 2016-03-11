<?php

namespace AppBundle\Matrix;

class Matrix
{
    public function parseOperations($operations)
    {
        error_log("In the service :: ".var_export($operations, true)."\n", 3, "/tmp/german.log");
    }
}
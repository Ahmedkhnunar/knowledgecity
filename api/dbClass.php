<?php

/**
 * Author Name: Ahmed Khan
 * Description: A database resusable class, It makes easier your work, because any time you use the same class methods and parameters.
 */
class dbClass
{
    private $idCon;

    // *************************
    // ** CONSTRUCTOR METHODS **
    // *************************
    function __construct($varHost, $varUser, $varPassword, $varDB)
    {
        ini_set('memory_limit', '-1');
        $this->Open($varHost, $varUser, $varPassword, $varDB);
    }

    // **********************
    // ** STANDARD METHODS **
    // **********************
    
    ////////////////////////////
    // Open Server Connection //
    ////////////////////////////
    function Open($varHost, $username = "", $password = "", $database = "")
    {
        try {
            
            $idCon = new mysqli($varHost, $username, $password, $database);
            if ($idCon->connect_errno)
                die(json_encode(["code" => 300, "message" => "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error]));

            $this->idCon = $idCon;
            return $idCon;
        } catch (Exception $e) {
            die($this->ShowGeneralError());
        }
    }

    /////////////////////////////////////////////
    // Send Query to Currently Active Database //
    /////////////////////////////////////////////
    function Query($query)
    {
        $r = $this->idCon->query($query) or die($this->ShowGeneralError());
        return $r;
    }

    //////////////////////////////////
    // Get Number of Rows in Result //
    //////////////////////////////////
    function RowsNumber($result)
    {
        return $result->num_rows;
    }

    //////////////////////////////////////////////////////////////////////////////
    // fetch row as array (you can using the field names as keys - msssq, mysql //
    // only for pg you can use RowNumber and ResultType)                        //
    //////////////////////////////////////////////////////////////////////////////
    Function FetchArray($result)
    {
        return $result->fetch_assoc();
    }

    ////////////////////////////////////////////////////////
    // returns the contents of one cell from a result set //
    ////////////////////////////////////////////////////////
    Function Result($result, $RowNumber, $FieldName)
    {
        if($result->num_rows == 0) return('');

        $result->data_seek($RowNumber);
        $ceva = $result->fetch_assoc();
        $r = $ceva[$FieldName];
        
        if (!array_key_exists($FieldName, $ceva))
        {
            die($this->ShowGeneralError());
        }

        return $r;
    }

    ////////////////////////
    // Escape Real String //
    ////////////////////////
    function RealEscapeString($str)
    {
        return($this->idCon->real_escape_string($str));
    }

    /////////////////////////////
    // Close Server Connection //
    /////////////////////////////
    Function Close()
    {
        $r = $this->idCon->close();
        return $r;
    }

    //////////////////////////
    // Show General Message //
    //////////////////////////
    function ShowGeneralError()
    {
        return(json_encode(["code" => 300, "message" => "sorry! something went wrong."]));
    }
}

?>
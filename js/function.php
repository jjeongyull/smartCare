<?php
    function fn_EscapeString($param, $mysqli){
        $param = htmlentities($param, ENT_QUOTES); 
        $param = mysqli_real_escape_string($mysqli, $param);               
        return $param;
    }

    function fn_URIString($param, $ptype, $pdefault){
        if ($ptype == "string"){
            $tmpStr = isset($_POST[$param]) ? $_POST[$param] : $pdefault;           
            if ($tmpStr == ""){
                $tmpStr = isset($_GET[$param]) ? $_GET[$param] : $pdefault;         
            }     
        }   
        elseif ($ptype == "int"){
            $tmpStr = isset($_POST[$param]) ? $_POST[$param] : $pdefault;           
            if ($tmpStr == ""){
                $tmpStr = isset($_GET[$param]) ? $_GET[$param] : $pdefault;         
            }        
        }
        return$tmpStr;
    }

    function fn_getHash(){

    }
?>
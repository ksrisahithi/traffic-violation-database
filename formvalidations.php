<?php
    //id validation
    function id_validation($id){
        if (!preg_match ("/^[0-9]*$/", $id) ){  
            return false;
        } else {  
            return true; 
        } 
    }

    //name validation
    function name_validation($name){
        if (!preg_match ("/^[A-Za-z][A-Za-z\'\-]+([\ A-Za-z][A-Za-z\'\-]+)*/",$name)) {  
            return false;
        } else {  
            return true;
        } 
    }

    //aadhar validation
    function aadhar($aadharno){
        if($string = ""){
            return;
        }
        else{
            $temp = $aadharno;
            $temp = strval($temp);
            $temp = str_replace(" ", "", $temp);
            //$temp = intval($temp);
            return $temp;
        }
    }

    function aadhar_validation($aadharno){
        $aadharno = aadhar($aadharno);
        if (!preg_match ("/(^[0-9]{4}[0-9]{4}[0-9]{4}$)|(^[0-9]{4}\s[0-9]{4}\s[0-9]{4}$)/", $aadharno) ){  
            return false;
        } else {  
            return true; 
        } 
    }
?>
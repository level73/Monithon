<?php
/** Translator **/
function t_report($string, $print = true){
    if($print === true){

        echo ucfirst($string);
    }
    else {

        return ucfirst($string);
    }
}
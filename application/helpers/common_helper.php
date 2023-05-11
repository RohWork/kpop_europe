<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
function confirm_mobile(){
    
    $mobile_agent = "/(iPod|iPhone|Android|BlackBerry|SymbianOS|SCH-M\d+|Opera Mini|Windows CE|Nokia|SonyEricsson|webOS|PalmOS)/";

        if(preg_match($mobile_agent, $_SERVER['HTTP_USER_AGENT'])){
            return true;
        }else{
            return false;
        }
    
}

function get_langueage_list(){
    
    $lang_array = array(
        "English",
        "한국어",
        "Deutsch"
    );
    
    return $lang_array;
}


?>
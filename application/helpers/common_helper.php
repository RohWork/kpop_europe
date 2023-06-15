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
        array(
            "id"    =>  "en",
            "val"   =>  "English"
        ),
        array(
            "id"    =>  "ko",
            "val"   =>  "한국어",
        ),
        array(
            "id"    => "de",
            "val"   => "Deutsch"
        )
        
    );
    
    return $lang_array;
}

function get_state($state, $content){
    switch($state){
        case 1:
            return $content;
            break;
        case 2 :
            return $this->lang->line('blind1');
            break;
        case 3 :
            return $this->lang->line('blind2');
            break;
        case 4 :
            return $this->lang->line('blind4');
            break;
    }
    
    
    
}

?>
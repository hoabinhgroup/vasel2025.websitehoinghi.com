<?php


if (!function_exists("checkMemberSignedIn")) {
    function checkMemberSignedIn()
    {
        if(auth()->guard('member')->check()){
            return true;
        }else{
            return false;
        }
     }
    }
    
    if (!function_exists("getMemberSignedIn")) {
    function getMemberSignedIn()
    {
        if(auth()->guard('member')->check()){
            return auth()->guard('member')->user();
        }	
        return null;
     }
    }
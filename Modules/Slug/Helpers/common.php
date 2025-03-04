<?php

if (!function_exists('get_permalink')) {
function get_permalink($object) {
	
	if($object) {
		return '/' . $object->slug->key . '.html';
	}

 }
}
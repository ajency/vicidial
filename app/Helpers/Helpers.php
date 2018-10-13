<?php

function val_integer($object,$values){
	if (empty($object)|| empty($values)) return false;
	foreach ($values as $value) {
		if(!isset($object[$value]) || !(ctype_digit($object[$value]) || is_integer($object[$value]) )) return false;
	}
	return true;
}
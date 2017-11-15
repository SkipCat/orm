<?php

namespace src;

class Translator
{
	public function objectToArray($object)
	{
		$array = (array) $object;
		foreach ($array as $key => $value) {
			$newkey = str_replace('*', '', $key);
			$array[$newkey] = $array[$key];
			unset($array[$key]);
		}
		array_splice($array, 0, 1);
		
		return $array;
	}
	
	public function arrayToObject($array)
	{
		$object = (object) $array;
		return $object;
	}
	
}

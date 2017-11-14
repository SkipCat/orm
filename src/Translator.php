<?php

namespace src;

class Translator
{
	public function objectToArray($object)
	{
		$array = (array) $object;
		
		foreach ($array as $key => $value) {
			$newkey = str_replace('*', '', $key);
			$newkey = $this->camelToSnake($newkey);
			
			$array[$newkey] = $array[$key];
			unset($array[$key]);
			
			unset($array['id']);
			unset($array['src_connection_dbh']); // if (!property_exists($object, $key))
		}
		
		return $array;
	}
	
	private function camelToSnake($input) {
		preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches);
		$ret = $matches[0];
		
		foreach ($ret as &$match) {
			$match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
		}
		
		return implode('_', $ret);
	}
	
}
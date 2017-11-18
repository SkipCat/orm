<?php

namespace src;

class Log
{
	public function writeRequestLog($request = [], $params = null)
	{
		$file = fopen('app/logs/request.log', 'a');
		$time = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"];
		$params = $this->checkParams($params);
		
		$log =
			date('d-m-Y H:i:s') . "\r\n"
			. '___ REQUEST: ' . $request . "\r\n"
			. '___ PARAMETERS: ' . $params . "\r\n"
			. '___ REQUEST TIME: ' . $time . ' s' . "\r\n \r\n"
		;
		
		fwrite($file, $log);
		fclose($file);
	}
	
	public function writeErrorLog($request, $params, $error)
	{
		var_dump($request, $params, $error);
		
		$file = fopen('app/logs/error.log', 'a');
		$params = $this->checkParams($params);
		$error = $this->writeError($error);
		
		$log =
			date('d-m-Y H:i:s') . "\r\n"
			. '___ REQUEST: ' . $request . "\r\n"
			. '___ PARAMETERS: ' . $params . "\r\n"
			. '___ ERROR: ' . $error . "\r\n \r\n"
		;
		
		fwrite($file, $log);
		fclose($file);
	}
	
	public function checkParams($data)
	{
		if (null == $data) {
			$data = '[]';
		} else {
			$data = $this->writeParams($data);
		}
		
		return $data;
	}
	
	public function writeParams($data)
	{
		if (gettype($data) == 'string') {
			$data = '[' . $data;
			$data .= ']';
			return $data;
		}
		
		$params = '[';
		foreach ($data as $key => $value) {
			$params .= $key . ' => ' . $value . ', ';
		}
		$params = substr($params, 0, -2); // remove last ','
		$params .= ']';
		
		return $params;
	}
	
	public function writeError($data)
	{
		if (gettype($data) == 'string') {
			return $data;
		}
		
		// set key names
		$data['SQLSTATE code'] = $data[0];
		$data['Driver code'] = $data[1];
		$data['Driver message'] = $data[2];
		unset($data[0], $data[1], $data[2]);
		
		// set error message
		$error = '[';
		foreach ($data as $key => $value) {
			$error .= $key . ' => ' . $value . ', ';
		}
		$error = substr($error, 0, -2); // remove last ','
		$error .= ']';
		
		return $error;
	}
}

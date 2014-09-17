<?php
/**
 * YMLP API
 * @see http://www.ymlp.com/app/api.php
 */

class Ymlp
{
	protected $_method = '';
	protected $_params = array();

	protected function execute()
	{
		if (empty($this->_method) )
		{
			throw new Exception('YMLP method is not set');
		}

		if (empty($this->_params) )
		{
			throw new Exception('YMLP parameters is not set');
		}

		$config = require dirname(__FILE__).'/../configs/ymlp.php';

		$params = array_merge($this->_params, $config);

		$params_value = '';

		foreach ($params as $key => &$value)
		{
			$params_value .= '&'.urlencode($key).'='.urlencode($value);
		}

		$ch = curl_init('https://www.ymlp.com/api/'.$this->_method);

		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params_value);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

		$response = curl_exec($ch);

		if (FALSE === $response)
		{
			throw new Exception('cURL return errno: '.curl_errno($ch) );
		}

		curl_close($ch);

		if ('PHP' == $params['Output'])
		{
			$response = unserialize($response);
		}
		elseif ('JSON' == $params['Output'])
		{
			$response = json_decode($response, TRUE);
		}

		return $response;
	}
};

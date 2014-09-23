<?php

function Subscribe($id, $email)
{
	$params = array('YMP0' => $email);
	$url    = 'http://ymlp.com/subscribe.php?id=' . $id;

	$ch = curl_init($url);
	 
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	 
	echo curl_exec($ch);

	curl_close($ch);
}

$request_method = isset($_SERVER['REQUEST_METHOD']) ? strtolower($_SERVER['REQUEST_METHOD']) : '';

if ('post' === $request_method)
{
	if (isset($_REQUEST['lang']) && isset($_REQUEST['email']))
	{
		switch ($_REQUEST['lang'])
		{
		case 'en': $id = Subscribe('ghswmqmgmgw', $_REQUEST['email']); break;
		case 'ru': $id = Subscribe('ghswmqmgmgq', $_REQUEST['email']); break;
		default: header('HTTP/1.1 400 Bad Request');
		}
	}
	else
	{
		header('HTTP/1.1 400 Bad Request');
	}
}
else
{
	header('HTTP/1.1 405 Method Not Allowed');
}

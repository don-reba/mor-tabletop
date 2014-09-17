<?php

ini_set('display_errors', 1);

require_once 'classes/Model/Ymlp/Contacts.php';

function method_post()
{
	if (FALSE === isset($_POST['email']) )
	{
		header('HTTP/1.1 400 Bad Request');

		sleep(1);

		return '<h1>Email not set in request data</h1>';
	}

	$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

	if (FALSE === $email)
	{
		header('HTTP/1.1 400 Bad Request');

		sleep(1);

		return '<h1>Email invalid format</h1>';
	}

	if (FALSE === isset($_SERVER['HTTP_REFERER']) )
	{
		header('HTTP/1.1 400 Bad Request');

		sleep(1);

		return '<h1>Referer is not set in headers</h1>';
	}

	$referer = $_SERVER['HTTP_REFERER'];

	$pos = mb_strpos($referer, '//', 0, 'UTF-8');

	if (FALSE !== $pos)
	{
		$referer = mb_substr($referer, $pos + 2, mb_strlen($referer, 'UTF-8'), 'UTF-8');
	}

	$pos = mb_strpos($referer, '/', 0, 'UTF-8');

	if (FALSE === $pos)
	{
		header('HTTP/1.1 400 Bad Request');

		sleep(1);

		return '<h1>Invalid Referer</h1>';
	}

	$referer = mb_substr($referer, $pos, mb_strlen($referer, 'UTF-8'), 'UTF-8');

	$groups = array(
			'en' => 'tabletop.pathologic.en',
			'ru' => 'tabletop.pathologic.ru',
		);

	if (FALSE === isset($groups[$referer]) )
	{
		header('HTTP/1.1 400 Bad Request');

		sleep(1);

		return '<h1>Invalid Referer</h1>';
	}

	$group_id = $groups[$lang];

	$myc = new Model_Ymlp_Contacts;
	$result = $myc->add($email, $group_id);

	sleep(1);

	header('HTTP/1.1 200 OK');
	header('Location: '.$referer);
}

$request_method = isset($_SERVER['REQUEST_METHOD']) ? strtolower($_SERVER['REQUEST_METHOD']) : '';

if ('post' === $request_method)
{
	return print method_post();
}
else
{
	header('HTTP/1.1 405 Method Not Allowed');
} 

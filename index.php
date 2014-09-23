<?php

function method_get()
{
	$language = 'en'; // Default language

	if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) )
	{
		$str_langs = strtolower($_SERVER['HTTP_ACCEPT_LANGUAGE']);

		if ($str_langs)
		{
			// Available languages (ISO 639-1 Code)
			$available_langs = array('en' => 0, 'ru' => 0);

			// Related languages
			$related_langs = array(
				'ru' => array('ru-ru', 'be', 'uk', 'ky', 'ab', 'mo', 'et', 'lv'),
			);

			$browser_langs = explode(',', $str_langs);

			$langs = array();

			foreach ($browser_langs as &$lang)
			{
				$pos = strpos($lang, ';q=');

				if ($pos)
				{
					$langs[substr($lang, 0, $pos)] = (float) substr($lang, $pos + 3);
				}
				else
				{
					$langs[$lang] = 1.0;
				}
			}

			foreach ($related_langs as $key => &$list)
			{
				foreach ($list as &$value)
				{
					if (isset($langs[$value]) )
					{
						if (FALSE === isset($langs[$key]) || $langs[$value] > $langs[$key])
						{
							$langs[$key] = $langs[$value];
						}

						unset($langs[$value]);
					}
				}
			}

			$langs = array_intersect_key($langs, $available_langs);

			if (FALSE === empty($langs) )
			{
				arsort($langs, SORT_NUMERIC);

				$language = key($langs);
			}
		}
	}

	header('HTTP/1.1 302 Found');
	header('Location: '.$language.'/');
}

$request_method = isset($_SERVER['REQUEST_METHOD']) ? strtolower($_SERVER['REQUEST_METHOD']) : '';

if ('get' === $request_method)
{
	return method_get();
}
else
{
	header('HTTP/1.1 405 Method Not Allowed');
}

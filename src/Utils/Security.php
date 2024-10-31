<?php
namespace Easymailing\App\Utils;

class Security
{

	/**
	 * @param string $message
	 * @param string $key
	 *
	 * @return string
	 */
	public static function safeEncrypt(string $message, string $key): string
	{
		return openssl_encrypt($message,"AES-128-ECB",$key);
	}

	/**
	 * @param string $encrypted
	 * @param string $key
	 *
	 * @return string
	 */
	public static function safeDecrypt(string $encrypted, string $key): string
	{
		return openssl_decrypt($encrypted,"AES-128-ECB",$key);
	}


}

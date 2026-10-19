<?php

/**
 * _error
 * 
 * @return void
 */
function __($key)
{
	global $_ADMINLANG;
	if (isset($_ADMINLANG[$key])) {
		return $_ADMINLANG[$key];
	} else {
		return $key;
	}
}
if (!function_exists('makeIM')) {
	function makeIM($icon, $text = null, $class = '', $attr = '')
	{
		return makeIconMaterial($icon, $text, $class, $attr);
	}
}
if (!function_exists('makeIcon')) {
	function makeIcon($icon, $text = null, $class = '', $attr = '')
	{
		if (empty($text)) {
			return sprintf('<i class="fa fa-%s %s" %s aria-hidden="true"></i>', $icon, $class, $attr);
		} else {
			return sprintf('<i class="fa fa-%s %s" %s aria-hidden="true"></i> %s', $icon, $class, $attr, $text);
		}
	}
}
if (!function_exists('makeIconMaterial')) {
	function makeIconMaterial($icon, $text = null, $class = '', $attr = '')
	{
		if (empty($text)) {
			return sprintf('<i class="material-icons %s" %s>%s</i>', $class, $attr, $icon);
		} else {
			return sprintf('<i class="material-icons %s" %s>%s</i> %s', $class, $attr, $icon, $text);
		}
	}
}
if (!function_exists('makeIconMaterialOutline')) {
	function makeIconMaterialOutline($icon, $text = null, $class = '', $attr = '')
	{
		if (empty($text)) {
			return sprintf('<i class="material-icons-outlined %s" %s>%s</i>', $class, $attr, $icon);
		} else {
			return sprintf('<i style="transform: translateY(5px);" class="material-icons-outlined %s" %s>%s</i> %s', $class, $attr, $icon, $text);
		}
	}
}
if (!function_exists('makeIMO')) {
	function makeIMO($icon, $text = null, $class = '', $attr = '')
	{
		return makeIconMaterialOutline($icon, $text, $class, $attr);
	}
}

if (!function_exists('makeIM23')) {
	function makeIM23($icon, $text = null, $class = '', $attr = '')
	{
		return makeIconMaterial($icon, $text, $class, $attr);
	}
}

function toArray($d)
{
	if (is_object($d)) {
		// Gets the properties of the given object
		// with get_object_vars function
		$d = get_object_vars($d);
	}
	if (is_array($d)) {
		/*
		* Return array converted to object
		* Using __FUNCTION__ (Magic constant)
		* for recursive call
		*/
		return array_map(__FUNCTION__, $d);
	} else {
		// Return array
		return $d;
	}
}
function decrypt($string)
{
	global $cc_encryption_hash;
	$key = md5(md5($cc_encryption_hash)) . md5($cc_encryption_hash);
	$hash_key = _hash($key);
	$hash_length = strlen($hash_key);
	$string = base64_decode($string);
	$tmp_iv = substr($string, 0, $hash_length);
	$string = substr($string, $hash_length, strlen($string) - $hash_length);
	$iv = '';
	$out = '';

	$c = 0;
	while ($c < $hash_length) {
		$ivValue = (isset($tmp_iv[$c]) ? $tmp_iv[$c] : '');
		$hashValue = (isset($hash_key[$c]) ? $hash_key[$c] : '');
		$iv .= chr(ord($ivValue) ^ ord($hashValue));
		++$c;
	}

	$key = $iv;
	$c = 0;
	while ($c < strlen($string)) {
		if (($c != 0) && (($c % $hash_length) == 0)) {
			$key = _hash($key . substr($out, $c - $hash_length, $hash_length));
		}

		$out .= chr(ord($key[$c % $hash_length]) ^ ord($string[$c]));
		++$c;
	}
	return $out;
}
function _hash($string)
{
	if (function_exists('sha1')) {
		$hash = sha1($string);
	} else {
		$hash = md5($string);
	}

	$out = '';
	$c = 0;
	while ($c < strlen($hash)) {
		$out .= chr(hexdec($hash[$c] . $hash[$c + 1]));
		$c += 2;
	}
	return $out;
}
function _generate_iv()
{
	global $cc_encryption_hash;
	srand((float) microtime() * 1000000);
	$iv = md5(strrev(substr($cc_encryption_hash, 13)) . substr($cc_encryption_hash, 0, 13));
	$iv .= rand(0, getrandmax());
	$iv .= serialize(array('key' => md5(md5($cc_encryption_hash)) . md5($cc_encryption_hash)));
	return _hash($iv);
}
function _debug()
{
	ini_set('display_error', 1);
	error_reporting(E_ALL);
}

<?php

function redirect($path) {
	header("Location: http://" . $_SERVER['HTTP_HOST'] . "/$path");
}

/**
 * Get either a Gravatar URL or complete image tag for a specified email address.
 *
 * @param string $email The email address
 * @param string $s Size in pixels, defaults to 80px [ 1 - 512 ]
 * @param string $d Default imageset to use [ 404 | mm | identicon | monsterid | wavatar ]
 * @param string $r Maximum rating (inclusive) [ g | pg | r | x ]
 * @param boole $img True to return a complete IMG tag False for just the URL
 * @param array $atts Optional, additional key/value attributes to include in the IMG tag
 * @return String containing either just a URL or a complete image tag
 * @source http://gravatar.com/site/implement/images/php/
 */

function get_gravatar( $email, $s = 128, $d = 'identicon', $r = 'g', $img = false, $atts = array() ) {
	$url = 'http://www.gravatar.com/avatar/';
	$url .= md5( strtolower( trim( $email ) ) );
	$url .= "?s=$s&d=$d&r=$r";
	if ( $img ) {
		$url = '<img src="' . $url . '"';
		foreach ( $atts as $key => $val )
			$url .= ' ' . $key . '="' . $val . '"';
		$url .= ' />';
	}
	return $url;
}

function urlencode_array($arr) {
	$str = "?";
	$keys = array(
		'namePerson/friendly'     => 'nickname',
		'contact/email'           => 'email',
		'namePerson'              => 'fullname',
		'birthDate'               => 'dob',
		'person/gender'           => 'gender',
		'contact/postalCode/home' => 'postcode',
		'contact/country/home'    => 'country',
		'pref/language'           => 'language',
		'pref/timezone'           => 'timezone',
		);
	foreach($arr as $k => $v) {
		$str .= !array_key_exists($k, $keys)?$k:$keys[$k] .'=' . urlencode($v) .'&';
	}
	return substr($str, 0, strlen($str)-1);
}

function is_ajax() {
	if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' )
	{
		return true; 
	}	
	else
	{
		return false;
	}
	
}

function cleaninput($data) {
	// http://svn.bitflux.ch/repos/public/popoon/trunk/classes/externalinput.php
	// +----------------------------------------------------------------------+
	// | Copyright (c) 2001-2006 Bitflux GmbH                                 |
	// +----------------------------------------------------------------------+
	// | Licensed under the Apache License, Version 2.0 (the "License");      |
	// | you may not use this file except in compliance with the License.     |
	// | You may obtain a copy of the License at                              |
	// | http://www.apache.org/licenses/LICENSE-2.0                           |
	// | Unless required by applicable law or agreed to in writing, software  |
	// | distributed under the License is distributed on an "AS IS" BASIS,    |
	// | WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or      |
	// | implied. See the License for the specific language governing         |
	// | permissions and limitations under the License.                       |
	// +----------------------------------------------------------------------+
	// | Author: Christian Stocker <chregu@bitflux.ch>                        |
	// +----------------------------------------------------------------------+
	//
	// Kohana Modifications:
	// * Changed double quotes to single quotes, changed indenting and spacing
	// * Removed magic_quotes stuff
	// * Increased regex readability:
	//   * Used delimeters that aren't found in the pattern
	//   * Removed all unneeded escapes
	//   * Deleted U modifiers and swapped greediness where needed
	// * Increased regex speed:
	//   * Made capturing parentheses non-capturing where possible
	//   * Removed parentheses where possible
	//   * Split up alternation alternatives
	//   * Made some quantifiers possessive

	// Fix &entity\n;
	$data = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $data);
	$data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
	$data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
	$data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');

	// Remove any attribute starting with "on" or xmlns
	$data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);

	// Remove javascript: and vbscript: protocols
	$data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
	$data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
	$data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);

	// Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
	$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
	$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
	$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);

	// Remove namespaced elements (we do not need them)
	$data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);

	do
	{
		// Remove really unwanted tags
		$old_data = $data;
		$data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
	}
	while ($old_data !== $data);

	return $data;
}

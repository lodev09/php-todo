<?php

// https://github.com/lodev09/php-util
use \Common\Util;

/**
 * Escape HTML strings
 *
 * @param  [type]  $str
 * @param  boolean $nl2br
 * @return [type]
 */
function escape($str, $nl2br = false) {
	return Util::escapeHtml($str, $nl2br);
}

/**
 * Extended echo
 *
 * @param  string  $msg
 * @param  boolean $newline
 * @param  array   $options
 * @param  boolean $return
 *
 * @return void|string
 */
function plog($msg = '', $newline = true, $options = [], $return = false) {
	$is_cli = Util::isCli();
    $is_ajax = Util::isAjax();
    $is_pjax = Util::isPjax();

    // if current header is json, return plain text
    $content_type = util::getHeader('Content-Type', headers_list());

    $is_html = !($is_cli || $is_ajax || $content_type === 'application/json') || $is_pjax;

	$result = Util::debug($msg, array_merge(['newline' => $newline], $options), true);
	$result = $is_html ? '<div class="debug">'.$result.'</div>' : $result;

	if ($return) return $result;
	else echo $result;
}

/**
 * Slugify
 *
 * @param  string  $name
 * @param  boolean $lowercase
 * @param  string  $skip_chars
 * @param  string  $replace
 *
 * @return string
 */
function slugify($name, $lowercase = true, $skip_chars = '', $replace = '-') {
    return Util::slugify($name, $lowercase, $skip_chars, $replace);
}

/**
 * Get
 *
 * @param  mixed $field
 * @param  mixed $data
 * @param  mixed $default
 * @param  array  $possible_values
 * @return mixed
 */
function get($field, $data = null, $default = null, $possible_values = []) {
    return Util::get($field, $data, $default, $possible_values);
}

/**
 * Get header
 *
 * @param  string $header
 * @param  array $headers
 * @return string
 */
function get_header($header, $headers = null) {
    return Util::getHeader($header, $headers);
}

/**
 * Test if string exist in a subject
 *
 * @param  string $string
 * @param  string $subject
 * @return boolean
 */
function in_string($string, $subject) {
    return Util::inString($string, $subject);
}

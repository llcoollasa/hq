<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! class_exists('CI_Driver')) get_instance()->load->library('driver');

define('MERCHANT_CONFIG_PATH', realpath(dirname(__FILE__).'/../config'));
define('MERCHANT_DRIVER_PATH', realpath(dirname(__FILE__).'/Vendor'));
define('MERCHANT_VENDOR_PATH', realpath(dirname(__FILE__).'/../vendor'));

class Vendor
{
	private $_driver;

	public function __construct($driver = NULL)
	{
		if ( ! empty($driver))
		{
			$this->load($driver);
		}
	}

	public function __call($function, $arguments)
	{
		if ( ! empty($this->_driver))
		{
			return call_user_func_array(array($this->_driver, $function), $arguments);
		}
	}

	public function load($driver)
	{
		$this->_driver = $this->_create_instance($driver);
		
		return $this->_driver !== FALSE;
	}

	private function _create_instance($driver)
	{
		if ( ! class_exists($driver))
		{

			// attempt to load driver file
			$driver_path = MERCHANT_DRIVER_PATH.'/'.strtolower($driver).'.php';
			
			if ( ! file_exists($driver_path)) return FALSE;
			require_once($driver_path);

			// did the driver file implement the class?
			if ( ! class_exists($driver)) return FALSE;
		}
 
		return new $driver();
	}
}

abstract class Vendor_driver
{
	protected $CI;

	protected $settings = array();


	public function __construct()
	{
		$this->CI =& get_instance(); 
		// initialize default settings  
	}
 
	public function settings($key)
	{
		return isset($this->settings[$key]) ? $this->settings[$key] : FALSE;
	} 

	// public function can_authorize()
	// {
	// 	$method = new ReflectionMethod($this, 'authorize');
	// 	return $method->getDeclaringClass()->name !== __CLASS__;
	// }

	// public function can_capture()
	// {
	// 	$method = new ReflectionMethod($this, 'capture');
	// 	return $method->getDeclaringClass()->name !== __CLASS__;
	// }

	// public function can_refund()
	// {
	// 	$method = new ReflectionMethod($this, 'refund');
	// 	return $method->getDeclaringClass()->name !== __CLASS__;
	// }

	// public function can_return()
	// {
	// 	$method = new ReflectionMethod($this, 'purchase_return');
	// 	if ($method->getDeclaringClass()->name !== __CLASS__) return TRUE;

	// 	// try calling deprecated process_return() method instead
	// 	if (method_exists($this, 'process_return')) return TRUE;
	// 	if (method_exists($this, '_process_return')) return TRUE;

	// 	return FALSE;
	// }

	// public function authorize()
	// {
	// 	throw new BadMethodCallException(lang('merchant_invalid_method'));
	// }

	// public function authorize_return()
	// {
	// 	throw new BadMethodCallException(lang('merchant_invalid_method'));
	// }

	// public function capture()
	// {
	// 	throw new BadMethodCallException(lang('merchant_invalid_method'));
	// }


	abstract public function purchase();

	// public function purchase()
	// {
	// 	// try calling deprecated process() method instead
	// 	if (method_exists($this, 'process'))
	// 	{
	// 		return $this->process($this->_params);
	// 	}

	// 	if (method_exists($this, '_process'))
	// 	{
	// 		return $this->_process($this->_params);
	// 	}

	// 	throw new BadMethodCallException(lang('merchant_invalid_method'));
	// }

	// public function purchase_return()
	// {
	// 	// try calling deprecated process_return() method instead
	// 	if (method_exists($this, 'process_return'))
	// 	{
	// 		return $this->process_return($this->_params);
	// 	}

	// 	if (method_exists($this, '_process_return'))
	// 	{
	// 		return $this->_process_return($this->_params);
	// 	}

	// 	throw new BadMethodCallException(lang('merchant_invalid_method'));
	// }

	// public function refund()
	// {
	// 	throw new BadMethodCallException(lang('merchant_invalid_method'));
	// }

	// public function param($name)
	// {
	// 	return isset($this->_params[$name]) ? $this->_params[$name] : FALSE;
	// }

	// public function set_params($params)
	// {
	// 	$this->_params = array_merge($this->_params, $params);
	// }

	// public function require_params()
	// {
	// 	$args = func_get_args();
	// 	if (empty($args)) return;

	// 	// also accept an array instead of multiple parameters
	// 	if (count($args) == 1 AND is_array($args[0])) $args = $args[0];

	// 	foreach ($args as $name)
	// 	{
	// 		if (empty($this->_params[$name]))
	// 		{
	// 			throw new Merchant_exception(str_replace('%s', lang("merchant_$name"), lang('merchant_required')));
	// 		}
	// 	}
	// }

	// public function validate_card()
	// {
	// 	// skip validation if card_no is empty
	// 	if (empty($this->_params['card_no'])) return;

	// 	if ( ! $this->secure_request())
	// 	{
	// 		throw new Merchant_exception(lang('merchant_insecure_connection'));
	// 	}

	// 	// strip any non-digits from card_no
	// 	$this->_params['card_no'] = preg_replace('/\D/', '', $this->_params['card_no']);

	// 	if ($this->validate_luhn($this->_params['card_no']) == FALSE)
	// 	{
	// 		throw new Merchant_exception(lang('merchant_invalid_card_no'));
	// 	}

	// 	if ($this->param('exp_month') AND $this->param('exp_year') AND
	// 		$this->validate_expiry($this->param('exp_month'), $this->param('exp_year')) == FALSE)
	// 	{
	// 		throw new Merchant_exception(lang('merchant_card_expired'));
	// 	}
	// }

	// /**
	//  * Luhn algorithm number checker - (c) 2005-2008 shaman - www.planzero.org
	//  * This code has been released into the public domain, however please
	//  * give credit to the original author where possible.
	//  *
	//  * @return boolean TRUE if the number is valid
	//  */
	// protected function validate_luhn($number)
	// {
	// 	// Set the string length and parity
	// 	$number_length = strlen($number);
	// 	$parity = $number_length % 2;

	// 	// Loop through each digit and do the maths
	// 	$total = 0;
	// 	for ($i = 0; $i < $number_length; $i++)
	// 	{
	// 		$digit = $number[$i];
	// 		// Multiply alternate digits by two
	// 		if ($i % 2 == $parity)
	// 		{
	// 			$digit *= 2;
	// 			// If the sum is two digits, add them together (in effect)
	// 			if ($digit > 9)
	// 			{
	// 				$digit -= 9;
	// 			}
	// 		}
	// 		// Total up the digits
	// 		$total += $digit;
	// 	}

	// 	// If the total mod 10 equals 0, the number is valid
	// 	return ($total % 10 == 0) ? TRUE : FALSE;
	// }

	// /**
	//  * Check whether an expiry date has already passed
	//  *
	//  * @return bool TRUE if the expiry date is valid
	//  */
	// protected function validate_expiry($month, $year)
	// {
	// 	// subtract 12 hours from current GMT time to avoid potential timezone issues
	// 	// in this rare case we will leave it up to the payment gateway to decide
	// 	$date = getdate(gmmktime() - 43200); // 12*60*60

	// 	if ($year < $date['year'])
	// 	{
	// 		return FALSE;
	// 	}

	// 	if ($year == $date['year'] AND $month < $date['mon'])
	// 	{
	// 		return FALSE;
	// 	}

	// 	return TRUE;
	// }

	// /**
	//  * Returns TRUE if the current request was made using HTTPS
	//  */
	// protected function secure_request()
	// {
	// 	if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) AND $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')
	// 	{
	// 		return TRUE;
	// 	}
	// 	if (empty($_SERVER['HTTPS']) OR strtolower($_SERVER['HTTPS']) == 'off')
	// 	{
	// 		return FALSE;
	// 	}

	// 	return TRUE;
	// }

	// protected function amount_dollars()
	// {
	// 	if (in_array($this->param('currency'), Merchant::$CURRENCIES_WITHOUT_DECIMALS))
	// 	{
	// 		return round($this->param('amount'));
	// 	}

	// 	return sprintf('%01.2f', $this->param('amount'));
	// }

	// protected function amount_cents()
	// {
	// 	if (in_array($this->param('currency'), Merchant::$CURRENCIES_WITHOUT_DECIMALS))
	// 	{
	// 		return round($this->param('amount'));
	// 	}

	// 	return round($this->param('amount') * 100);
	// }

	// protected function currency()
	// {
	// 	return $this->param('currency');
	// }

	// protected function currency_numeric()
	// {
	// 	$code = $this->param('currency');
	// 	return isset(Merchant::$NUMERIC_CURRENCY_CODES[$code]) ? Merchant::$NUMERIC_CURRENCY_CODES[$code] : 0;
	// }

	// /**
	//  * Make a standard HTTP GET request.
	//  * This method is only public to support the deprecated Merchant::curl_helper() method,
	//  * and will be marked as protected in a future version.
	//  *
	//  * @param string $url The URL to request
	//  * @param string $username
	//  * @param string $password
	//  * @param array $extra_headers
	//  */
	// public function get_request($url, $username = NULL, $password = NULL, $extra_headers = NULL)
	// {
	// 	$ch = curl_init($url);
	// 	return $this->_do_curl_request($ch, $username, $password, $extra_headers);
	// }

	// /**
	//  * Make a standard HTTP POST request.
	//  * This method is only public to support the deprecated Merchant::curl_helper() method,
	//  * and will be marked as protected in a future version.
	//  *
	//  * @param string $url The URL to request
	//  * @param mixed $data An optional string or array of form data which will be appended to the URL
	//  * @param string $username
	//  * @param string $password
	//  * @param array $extra_headers
	//  */
	// public function post_request($url, $data = NULL, $username = NULL, $password = NULL, $extra_headers = NULL)
	// {
	// 	$ch = curl_init($url);

	// 	if (is_array($data))
	// 	{
	// 		$data = http_build_query($data);
	// 	}

	// 	curl_setopt($ch, CURLOPT_POST, TRUE);
	// 	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

	// 	return $this->_do_curl_request($ch, $username, $password, $extra_headers);
	// }

	// private function _do_curl_request($ch, $username, $password, $extra_headers)
	// {
	// 	curl_setopt($ch, CURLOPT_HEADER, FALSE);
	// 	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	// 	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE);
	// 	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
	// 	curl_setopt($ch, CURLOPT_CAINFO, MERCHANT_CONFIG_PATH.'/cacert.pem');

	// 	if ($username !== NULL)
	// 	{
	// 		curl_setopt($ch, CURLOPT_USERPWD, $username.':'.$password);
	// 	}

	// 	if ( ! empty($extra_headers))
	// 	{
	// 		curl_setopt($ch, CURLOPT_HTTPHEADER, $extra_headers);
	// 	}

	// 	$response = curl_exec($ch);
	// 	$error = curl_error($ch);

	// 	if ( ! empty($error))
	// 	{
	// 		throw new Merchant_exception($error);
	// 	}

	// 	curl_close($ch);
	// 	return $response;
	// }

	// /**
	//  * Redirect the user's browser to a URL.
	//  */
	// protected function redirect($url)
	// {
	// 	return Merchant::redirect($url);
	// }

	// /**
	//  * Redirect the user's browser to a URL using a POST request.
	//  */
	// protected function post_redirect($url, $data, $message = NULL)
	// {
	// 	return Merchant::post_redirect($url, $data, $message);
	// }
}

class Merchant_exception extends Exception {}

class Merchant_response
{
	const AUTHORIZED = 'authorized';
	const COMPLETE = 'complete';
	const FAILED = 'failed';
	const REDIRECT = 'redirect';
	const REFUNDED = 'refunded';

	protected $_status;
	protected $_message;
	protected $_reference;
	protected $_data;
	protected $_redirect_url;
	protected $_redirect_method = 'GET';
	protected $_redirect_message;
	protected $_redirect_data;

	public function __construct($status, $message = NULL, $reference = NULL)
	{
		// support deprecated 'declined' status
		if ($status == 'declined') $status = self::FAILED;

		// always require a valid status
		if ( ! in_array($status, array(self::AUTHORIZED, self::COMPLETE, self::FAILED, self::REDIRECT, self::REFUNDED)))
		{
			throw new InvalidArgumentException(lang('merchant_invalid_status'));
		}

		$this->_status = $status;
		$this->_message = $message;
		$this->_reference = $reference;
	}

	/**
	 * The response status.
	 * One of self::AUTHORIZED, self::COMPLETE, self::FAILED, self::REDIRECT, or self::REFUNDED
	 */
	public function status()
	{
		return $this->_status;
	}

	/**
	 * Whether the request was successful.
	 */
	public function success()
	{
		return $this->_status !== self::FAILED;
	}

	/**
	 * A plain text message returned by the payment gateway.
	 */
	public function message()
	{
		return $this->_message;
	}

	/**
	 * A transaction reference generated by the payment gateway.
	 */
	public function reference()
	{
		return $this->_reference;
	}

	/**
	 * The raw response data returned by the payment gateway.
	 */
	public function data()
	{
		return $this->_data;
	}

	/**
	 * Does this response require a redirect?
	 */
	public function is_redirect()
	{
		return $this->_status === self::REDIRECT;
	}

	/**
	 * If this response requires a redirect, the URL which must be redirected to.
	 */
	public function redirect_url()
	{
		return $this->_redirect_url;
	}

	/**
	 * The HTTP redirect method required (either "GET" or "POST").
	 */
	public function redirect_method()
	{
		return $this->_redirect_method;
	}

	/**
	 * A message to display while redirecting using the POST method.
	 */
	public function redirect_message()
	{
		return $this->_redirect_message;
	}

	/**
	 * If this response requires a POST redirect, the HTTP form data which must be submitted.
	 */
	public function redirect_data()
	{
		return $this->_redirect_data;
	}

	/**
	 * Perform the required redirect. If no redirect is required, returns FALSE.
	 */
	public function redirect()
	{
		if ($this->is_redirect() == FALSE) return FALSE;

		if ('POST' == strtoupper($this->redirect_method()))
		{
			return Merchant::post_redirect($this->redirect_url(), $this->redirect_data(), $this->redirect_message());
		}

		return Merchant::redirect($this->redirect_url());
	}
}
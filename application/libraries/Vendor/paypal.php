<?php

$PP_path = __DIR__ . '/PayPal/vendor/autoload.php';
if(!file_exists($PP_path)) 
{
	echo "The 'vendor' folder is missing. You must run 'composer update' to resolve application dependencies.\nPlease see the README for more information.\n";
	exit(1);
}
else
{
	require_once($PP_path);
}


use PayPal\Common\PayPalModel;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential; 
use PayPal\Api\Address;
use PayPal\Api\CreditCard;
use PayPal\Api\FundingInstrument;
use PayPal\Api\Payer;
use PayPal\Api\Details; 
use PayPal\Api\Amount; 
use PayPal\Api\Transaction; 
use PayPal\Api\Payment; 
use PayPal\Api\PaymentExecution;

class Paypal extends Vendor_driver
{
	public function __construct()
	{  
		parent::__construct();
		
		$this->initialize();
	}

	private function initialize()
	{ 
		$settings = NULL;
		$settings = array(); 

		$PAYPAL_PATH = realpath(dirname(__FILE__).'/PayPal');	 

		$settings['lib_path'] = $PAYPAL_PATH;
		$settings['mode'] = $this->CI->config->config['pp_mode']; 
		$settings['client_id'] = $this->CI->config->config['pp_client_id']; 
		$settings['client_secret'] = $this->CI->config->config['pp_client_secret']; 

		$this->settings = $settings; 
	}

	public function purchase()
	{
		$oauthCredential = new OAuthTokenCredential($this->settings['client_id'], $this->settings['client_secret']);
		$accessToken     = $oauthCredential->getAccessToken(array('mode' => $this->settings['mode']));
		$apiContext = new ApiContext($oauthCredential); 
		
		$addr = new Address();
		$addr->setLine1('52 N Main ST');
		$addr->setCity('Johnstown');
		$addr->setCountryCode('US');
		$addr->setPostalCode('43210');
		$addr->setState('OH');

		$card = new CreditCard();
		$card->setNumber('4417119669820331');
		$card->setType('visa');
		$card->setExpireMonth('11');
		$card->setExpireYear('2018');
		$card->setCvv2('874');
		$card->setFirstName('Lasa');
		$card->setLastName('dfdfdfdfdfd');
		$card->setBillingAddress($addr);

		$fi = new FundingInstrument();
		$fi->setCreditCard($card);


		$payer = new Payer();
		$payer->setPaymentMethod('credit_card');
		$payer->setFundingInstruments(array($fi));

		$amountDetails = new Details();
		$amountDetails->setSubtotal('7.41');
		$amountDetails->setTax('0.03');
		$amountDetails->setShipping('0.03');

		$amount = new Amount();
		$amount->setCurrency('USD');
		$amount->setTotal('7.47');
		$amount->setDetails($amountDetails);

		$transaction = new Transaction();
		$transaction->setAmount($amount);
		$transaction->setDescription('This is the payment transaction description.');

		$payment = new Payment();
		$payment->setIntent('sale');
		$payment->setPayer($payer);
		$payment->setTransactions(array($transaction));

		$resss = $payment->create($apiContext);

		$payment = Payment::get('PAY-34629814WL663112AKEE3AWQ', $apiContext);

		$paymentExecution = new PaymentExecution();
		$paymentExecution->setPayer_id('PAY-5TC07842EF455884WKUIEBLA');

		$pay_exe = $payment->execute($paymentExecution, $apiContext);
		 
		//var_dump($resss);
		 
		echo $pay_exe;

	} 
}
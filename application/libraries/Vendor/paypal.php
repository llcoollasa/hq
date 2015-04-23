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

		$data = $this->get_params();

		$cc = $data["cc"];
		$cart = $data["checkout_data"];
		$products = $cart['cart_contents'];
		$sub_total = $products['cart_total'];
		$tax = 0;
		$shipping = 0;

		$oauthCredential = new OAuthTokenCredential($this->settings['client_id'], $this->settings['client_secret']);
		$accessToken     = $oauthCredential->getAccessToken(array('mode' => $this->settings['mode']));
		$apiContext = new ApiContext($oauthCredential); 
		 
                $apiContext->setConfig(
    array(
        'mode' => 'sandbox',
        'http.ConnectionTimeOut' => 30,
        'log.LogEnabled' => true,
        'log.FileName' => '/data2/www/hq/hq/PayPal.log',
        'log.LogLevel' => 'FINE',
        'validation.level' => 'log'
    )
);
                
		$addr = new Address();
		$addr->setLine1('52 N Main ST');
		$addr->setCity('Johnstown');
		$addr->setCountryCode('US');
		$addr->setPostalCode('43210');
		$addr->setState('OH');

		$card = new CreditCard();
		$card->setNumber($cc['cc_number']);
		$card->setType($cc['cc_type']);
		$card->setExpireMonth($cc['cc_exp_month']);
		$card->setExpireYear($cc['cc_exp_year']);
		$card->setCvv2($cc['cc_ccv']);
		$card->setFirstName($cc['cc_first_name']);
		$card->setLastName($cc['cc_last_name']);
		$card->setBillingAddress($addr);

		$fi = new FundingInstrument();
		$fi->setCreditCard($card);


		$payer = new Payer();
		$payer->setPaymentMethod('credit_card');
		$payer->setFundingInstruments(array($fi));


		$amountDetails = new Details();
		$amountDetails->setSubtotal($sub_total);
		$amountDetails->setTax($tax);
		$amountDetails->setShipping($shipping);

		$amount = new Amount();
		$amount->setCurrency($cart['cur']);
		$amount->setTotal($sub_total+$tax+$shipping);
		$amount->setDetails($amountDetails);

		$transaction = new Transaction();
		$transaction->setAmount($amount);
		$transaction->setDescription('This is the payment transaction description.');

		$payment = new Payment();
		$payment->setIntent('sale');
		$payment->setPayer($payer);
		$payment->setTransactions(array($transaction));


		$res = $payment->create($apiContext);

		$paymentsss = Payment::get($res->getId(), $apiContext);
 		 
                print_r($res);
		$paymentExecution = new PaymentExecution();
		$paymentExecution->setPayerId($res->getId());
 
		$pay_exe = $payment->execute($paymentExecution, $apiContext);
		 


		var_dump($pay_exe);
		 
		echo $pay_exe;

	} 
}
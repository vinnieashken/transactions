<?php
namespace App\Utils;

use App\Utils\Config;

class Mpesa
	{
		public $mpesa;
		public function __construct()
			{
				$this->mpesa =	new Config();
			}
		public function generatetoken($request)
			{
				$url 	= 	$this->mpesa->token_link;
				$curl 	= 	curl_init();
				curl_setopt($curl, CURLOPT_URL, $url);
				$credentials = base64_encode($request['consumerkey'].':'.$request['consumersecret']);
				curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Basic '.$credentials));
				curl_setopt($curl, CURLOPT_HEADER, false);
				curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				$curl_response = curl_exec($curl);
				return json_decode($curl_response)->access_token;
			}
		public function cert($plaintext)
			{
			    $cert   = base_path('app/Utills/cert/cert.cer');
				$fp=fopen($cert,"r");
				$publicKey = fread($fp,filesize($cert));
				fclose($fp);
				openssl_get_publickey($publicKey);
				openssl_public_encrypt($plaintext, $encrypted, $publicKey, OPENSSL_PKCS1_PADDING);
				return  base64_encode($encrypted);
			}
		public function getIdentifier($type)
			{
				$type=strtolower($type);
				switch($type)
					{
						case "msisdn":
						        $x = 1;
						        break;
						case "tillnumber":
								$x = 2;
								break;
						case "shortcode":
								$x = 4;
								break;
					}
				return $x;
			}
		public function checkout($request)
			{
				$url 	= $this->mpesa->checkout_processlink;
				$curl 	= curl_init();
				curl_setopt($curl, CURLOPT_URL, $url);
				curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$this->generatetoken($request)));
                $timestamp 	=	date('YmdHis');
                $password 	=	base64_encode($request['shortcode'].$this->mpesa->checkout_passkey.$timestamp);
				$curl_post_data = array(
										  	'BusinessShortCode' 	=> $request['shortcode'],
										  	'Password' 				=> $password,
										  	'Timestamp' 			=> $timestamp,
										  	'TransactionType' 		=> 'CustomerPayBillOnline',
										  	'Amount' 				=> $request['amount'],
										  	'PartyA' 				=> $request['msisdn'],
										  	'PartyB' 				=> $request['shortcode'],
										  	'PhoneNumber' 			=> $request['msisdn'],
										  	'CallBackURL' 			=> $this->mpesa->checkout_rcallbackurl,
										  	'AccountReference' 		=> $request['ref'],
										  	'TransactionDesc' 		=> $request['desc']
										);
				$data_string 	= 	json_encode($curl_post_data);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($curl, CURLOPT_POST, true);
				curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
				$curl_response 	= 	curl_exec($curl);
				$data 			=	(array)json_decode($curl_response);
				$data["refno"]	=	$curl_post_data['AccountReference'];
				return $curl_response;

			}
		public function checkout_query($request)
			{
				$url 	= $this->mpesa->checkout_querylink;
				$curl 	= curl_init();
				curl_setopt($curl, CURLOPT_URL, $url);
				curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$this->generatetoken($request))); //setting custom header
                $timestamp 		=	date('YmdHis');
                $password 		=	base64_encode($request['$shortcode'].$this->mpesa->checkout_passkey.$timestamp);
				$curl_post_data = array(
										  	'BusinessShortCode' 	=> $request['shortcode'],
										  	'Password' 				=> $password,
										  	'Timestamp'				=> $timestamp,
										  	'CheckoutRequestID' 	=> $request['CheckoutRequestID']
										);
				$data_string 	= json_encode($curl_post_data);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($curl, CURLOPT_POST, true);
				curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
				$curl_response = curl_exec($curl);
				return $curl_response;
			}
		public function reversal($request)
			{
				$url 	= $this->mpesa->reversal_link;
				$curl 	= curl_init();
				curl_setopt($curl, CURLOPT_URL, $url);
				curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$this->generatetoken($request)));
				$curl_post_data = array(
										  	'Initiator' 				=> $request['initiator'],
										  	'SecurityCredential' 		=> $this->cert($request['credential']),
										  	'CommandID' 				=> 'TransactionReversal',
										  	'TransactionID' 			=> $request['TransID'],
										  	'Amount' 					=> $request['amount'],
										  	'ReceiverParty' 			=> $request['receiver'],
										  	'RecieverIdentifierType' 	=> $this->getIdentifier($request['receiverType']),
										  	'ResultURL' 				=> $this->mpesa->reversal_resultUrl,
										  	'QueueTimeOutURL' 		    => $this->mpesa->reversal_timeoutURL,
										  	'Remarks' 				    => $request['remarks'],
										  	'Occasion' 				    => $request['ocassion']
										);

				$data_string = json_encode($curl_post_data);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($curl, CURLOPT_POST, true);
				curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
				$curl_response = curl_exec($curl);
				return $curl_response;
			}
		public function accountbalance($request)
			{
				$url 	= $this->mpesa->balance_link;
				$curl 	= curl_init();
				curl_setopt($curl, CURLOPT_URL, $url);
				curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$this->generatetoken($request)));

				$curl_post_data = array(
										   	'Initiator' 			=> $request['initiator'],
										  	'SecurityCredential' 	=> $this->cert($request['credential']),
										  	'CommandID' 			=> 'AccountBalance',
										  	'PartyA' 				=> $request['shortcode'],
										  	'IdentifierType' 		=> $this->getIdentifier("Shortcode"),
										  	'Remarks' 				=> $request['remark'],
										  	'QueueTimeOutURL' 		=> $this->mpesa->balance_timeoutUrl,
										  	'ResultURL' 			=> $this->mpesa->balance_resultUrl
										);
				$data_string = json_encode($curl_post_data);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($curl, CURLOPT_POST, true);
				curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
				$curl_response = curl_exec($curl);
				return $curl_response;
			}
		public function C2B_REGISTER($request,$status='Completed')
			{
				$url 	= 	$this->mpesa->c2b_regiterUrl;
				$curl 	= 	curl_init();
				curl_setopt($curl, CURLOPT_URL, $url);
				curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$this->generatetoken($request)));
				$curl_post_data = array(
										  	'ShortCode' 		=> $request['shortcode'],
										  	'ResponseType' 		=> $status,
										  	'ConfirmationURL' 	=> $this->mpesa->c2b_confirmationUrl,
										  	'ValidationURL' 	=> $this->mpesa->c2b_validationUrl
										);
				$data_string = json_encode($curl_post_data);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($curl, CURLOPT_POST, true);
				curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
				$curl_response = curl_exec($curl);
				return $curl_response;
			}
		public function C2B($request)
			{
				$url 	= $this->mpesa->c2b_transactionUrl;
				$curl 	= curl_init();
				curl_setopt($curl, CURLOPT_URL, $url);
				curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$this->generatetoken($request)));
				$curl_post_data = array(
										    "ShortCode"		=>	$request['shortcode'],
										    "CommandID"		=>	"CustomerPayBillOnline",
										    "Amount"		=> 	$request['amount'],
										    "Msisdn"		=>	$request['msisdn'],
										    "BillRefNumber"	=>	$request['ref']
										);
				$data_string = json_encode($curl_post_data);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($curl, CURLOPT_POST, true);
				curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
				$curl_response = curl_exec($curl);
				return $curl_response;
			}
		public function B2B($request)
			{
				$url 	= 	$this->mpesa->b2b_link;
				$curl 	= 	curl_init();
				curl_setopt($curl, CURLOPT_URL, $url);
				curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$this->generatetoken($request)));
				$curl_post_data = array(
										  	'Initiator' 				=> $request['initiator'],
										  	'SecurityCredential' 		=> $this->cert($request['credential']),
										  	'CommandID' 				=> $request['CommandID'],
										  	'SenderIdentifierType' 		=> $this->getIdentifier("shortcode"),
										  	'RecieverIdentifierType' 	=> $this->getIdentifier("shortcode"),
										  	'Amount' 					=> $request['amount'],
										  	'PartyA' 					=> $request['partyA_shortcode'],
										  	'PartyB' 					=> $request['partyB_shortcode'],
										  	'AccountReference' 			=> $request['accountref'],
										  	'Remarks' 					=> $request['remarks'],
										  	'QueueTimeOutURL' 			=> $this->mpesa->b2b_timeoutURL,
										  	'ResultURL' 				=> $this->mpesa->b2b_resultURL
										);
				$data_string = json_encode($curl_post_data);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($curl, CURLOPT_POST, true);
				curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
				$curl_response = curl_exec($curl);
				return $curl_response;
			}
		public function B2C($request)
			{
			    $url 	= $this->mpesa->b2c_link;
				$curl 	= curl_init();
				curl_setopt($curl, CURLOPT_URL, $url);
				curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$this->generatetoken($request)));
				$curl_post_data = array(
										  	'InitiatorName' 		=> 	$request['initiator'],
										  	'SecurityCredential' 	=> 	$this->cert($request['credential']),
										  	'CommandID' 			=> 	$request['CommandID'],
										  	'Amount' 				=> 	$request['amount'],
										  	'PartyA' 				=> 	$request['shortcode'],
										  	'PartyB' 				=> 	$request['msisdn'],
										  	'Remarks' 				=> 	$request['remarks'],
										  	'QueueTimeOutURL' 		=>  $this->mpesa->b2c_timeoutURL,
										  	'ResultURL' 			=> 	$this->mpesa->b2c_resultURL,
										  	'Occasion' 				=> 	$request['ocassion']
										);

				$data_string = json_encode($curl_post_data);

				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($curl, CURLOPT_POST, true);
				curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

				$curl_response = curl_exec($curl);
				print_r($curl_response);

				echo $curl_response;
			}
		public function transactionstatus($request)
			{
				$url 	=	$this->mpesa->transtat_link;
				$curl 	= 	curl_init();
				curl_setopt($curl, CURLOPT_URL, $url);
				curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$this->generatetoken($request)));
				$curl_post_data = array(
										  	'Initiator' 			=> $request['initiator'],
										  	'SecurityCredential' 	=> $this->cert($request['credential']),
										  	'CommandID' 			=> 'TransactionStatusQuery',
										  	'TransactionID' 		=> $request['transID'],
										  	'PartyA' 				=> $request['msisdn'],
										  	'IdentifierType' 		=> $this->getIdentifier($request['identifier']),
										  	'ResultURL' 			=> $this->mpesa->transtat_resultURL,
										  	'QueueTimeOutURL' 		=> $this->mpesa->transtat_timeoutURL,
										  	'Remarks' 				=> $request['remarks'],
										  	'Occasion' 				=> $request['ocassion'],
                                            'OriginalConversationID'=> $request['conversionID']
										);
				$data_string = json_encode($curl_post_data);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($curl, CURLOPT_POST, true);
				curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
				$curl_response = curl_exec($curl);
				return $curl_response;
			}

	}

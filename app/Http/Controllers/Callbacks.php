<?php

namespace App\Http\Controllers;

use App\Models\Shortcode;
use App\Models\Transaction;
use http\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Service;
use Illuminate\Support\Facades\Log;

class Callbacks
{
    public function processB2BRequestCallback()
    {
        $callbackJSONData 						=	file_get_contents('php://input');
        $callbackData 							=	json_decode($callbackJSONData)->Result;
        $resultCode 							=	$callbackData->ResultCode;
        $resultDesc 							=	$callbackData->ResultDesc;
        $originatorConversationID 				=	$callbackData->OriginatorConversationID;
        $conversationID 						=	$callbackData->ConversationID;
        $transactionID 							=	$callbackData->TransactionID;
        $transactionReceipt						=	$callbackData->ResultParameters->ResultParameter[0]->Value;
        $transactionAmount						=	$callbackData->ResultParameters->ResultParameter[1]->Value;
        $b2CWorkingAccountAvailableFunds		=	$callbackData->ResultParameters->ResultParameter[2]->Value;
        $b2CUtilityAccountAvailableFunds		=	$callbackData->ResultParameters->ResultParameter[3]->Value;
        $transactionCompletedDateTime			=	$callbackData->ResultParameters->ResultParameter[4]->Value;
        $receiverPartyPublicName				=	$callbackData->ResultParameters->ResultParameter[5]->Value;
        $B2CChargesPaidAccountAvailableFunds	=	$callbackData->ResultParameters->ResultParameter[6]->Value;
        $B2CRecipientIsRegisteredCustomer		=	$callbackData->ResultParameters->ResultParameter[7]->Value;

        $result=array(
            "resultCode"							=>	$resultCode,
            "resultDesc"							=>	$resultDesc,
            "originatorConversationID"				=>	$originatorConversationID,
            "conversationID"						=>	$conversationID,
            "transactionID"							=>	$transactionID,
            "transactionReceipt"					=>	$transactionReceipt,
            "transactionAmount"						=>	$transactionAmount,
            "b2CWorkingAccountAvailableFunds"		=>	$b2CWorkingAccountAvailableFunds,
            "b2CUtilityAccountAvailableFunds"		=>	$b2CUtilityAccountAvailableFunds,
            "transactionCompletedDateTime"			=>	$transactionCompletedDateTime,
            "receiverPartyPublicName"				=>	$receiverPartyPublicName,
            "B2CChargesPaidAccountAvailableFunds"	=>	$B2CChargesPaidAccountAvailableFunds,
            "B2CRecipientIsRegisteredCustomer"		=>	$B2CRecipientIsRegisteredCustomer
        );


    }
    public function processB2CRequestCallback()
    {
        $callbackJSONData	 				=	file_get_contents('php://input');
        $callbackData 						= 	json_decode($callbackJSONData);
        $resultCode 						=  	$callbackData->Result->ResultCode;
        $resultDesc 						=	$callbackData->Result->ResultDesc;
        $originatorConversationID 			= 	$callbackData->Result->OriginatorConversationID;
        $conversationID 					=	$callbackData->Result->ConversationID;
        $transactionID 						=	$callbackData->Result->TransactionID;
        $initiatorAccountCurrentBalance 	= 	$callbackData->Result->ResultParameters->ResultParameter[0]->Value;
        $debitAccountCurrentBalance 		=	$callbackData->Result->ResultParameters->ResultParameter[1]->Value;
        $amount 							=	$callbackData->Result->ResultParameters->ResultParameter[2]->Value;
        $debitPartyAffectedAccountBalance	=	$callbackData->Result->ResultParameters->ResultParameter[3]->Value;
        $transCompletedTime 				=	$callbackData->Result->ResultParameters->ResultParameter[4]->Value;
        $debitPartyCharges 					= 	$callbackData->Result->ResultParameters->ResultParameter[5]->Value;
        $receiverPartyPublicName 			= 	$callbackData->Result->ResultParameters->ResultParameter[6]->Value;
        $currency							=	$callbackData->Result->ResultParameters->ResultParameter[7]->Value;

        $result=array(
            "resultCode"						=>	$resultCode,
            "resultDesc"						=>	$resultDesc,
            "originatorConversationID"			=>	$originatorConversationID,
            "conversationID"					=>	$conversationID,
            "transactionID"						=>	$transactionID,
            "initiatorAccountCurrentBalance"	=>	$initiatorAccountCurrentBalance,
            "debitAccountCurrentBalance"		=>	$debitAccountCurrentBalance,
            "amount"							=>	$amount,
            "debitPartyAffectedAccountBalance"	=>	$debitPartyAffectedAccountBalance,
            "transCompletedTime"				=>	$transCompletedTime,
            "debitPartyCharges"					=>	$debitPartyCharges,
            "receiverPartyPublicName"			=>	$receiverPartyPublicName,
            "currency"							=>	$currency
        );



    }
    public function C2BRequestValidation()
    {

        $callbackJSONData 	=	file_get_contents('php://input');
        $callbackData 		=	json_decode($callbackJSONData);

        $transactionType 	=	$callbackData->TransactionType;
        $transID 			=	$callbackData->TransID;
        $transTime 			=	$callbackData->TransTime;
        $transAmount 		=	$callbackData->TransAmount;
        $businessShortCode 	=	$callbackData->BusinessShortCode;
        $billRefNumber 		=	$callbackData->BillRefNumber;
        $invoiceNumber 		=	$callbackData->InvoiceNumber;
        $orgAccountBalance 	= 	$callbackData->OrgAccountBalance;
        $thirdPartyTransID 	=	$callbackData->ThirdPartyTransID;
        $MSISDN 			=	$callbackData->MSISDN;
        $firstName 			=	$callbackData->FirstName;
        $middleName 		=	$callbackData->MiddleName;
        $lastName 			=	$callbackData->LastName;

        $result=array(
            "transTime"			=>	$transTime,
            "transAmount"		=>	$transAmount,
            "businessShortCode"	=>	$businessShortCode,
            "billRefNumber"		=>	$billRefNumber,
            "invoiceNumber"		=>	$invoiceNumber,
            "orgAccountBalance"	=>	$orgAccountBalance,
            "thirdPartyTransID"	=>	$thirdPartyTransID,
            "MSISDN"			=>	$MSISDN,
            "firstName"			=>	$firstName,
            "lastName"			=>	$lastName,
            "middleName"		=>	$middleName,
            "transID"			=>	$transID,
            "transactionType"	=>	$transactionType
        );

        $callback = Service::where('prefix',getprefix($result["billRefNumber"]) )
            ->where('shortcode',$result["businessShortCode"])
            ->first()
            ->validation_url;
        if($callback != TRUE)
        {
            return array("ResultCode"=>0,"ResultDesc"=>"Accepted");
        }
        else
        {
            $check = $this->curl_post($callback,['transcode'=>$result["billRefNumber"],"amount"=>$result["orgAccountBalance"]]);
            if($check->status)
            {
                return array("ResultCode"=>0,"ResultDesc"=>"Accepted");
            }
            else
            {
                return	array("ResultCode"=>'C2B00012',"ResultDesc"=>$check->message);
            }
        }


    }
    public function processC2BRequestConfirmation()
    {
        $callbackJSONData 	=	file_get_contents('php://input');

        $callbackData 		=	json_decode($callbackJSONData);
        $transactionType 	=	$callbackData->TransactionType;
        $transID 			= 	$callbackData->TransID;
        $transTime 			=	$callbackData->TransTime;
        $transAmount 		=	$callbackData->TransAmount;
        $businessShortCode 	=	$callbackData->BusinessShortCode;
        $billRefNumber 		=	$callbackData->BillRefNumber;
        $invoiceNumber 		=	$callbackData->InvoiceNumber;
        $orgAccountBalance 	=	$callbackData->OrgAccountBalance;
        $thirdPartyTransID 	=	$callbackData->ThirdPartyTransID;
        $MSISDN 			=	$callbackData->MSISDN;
        $firstName 			=	$callbackData->FirstName;
        $middleName 		= 	$callbackData->MiddleName;
        $lastName 			=	$callbackData->LastName;


                /*        $result=array(
                                            "transTime"			=>	$transTime,
                                            "transAmount"		=>	$transAmount,
                                            "businessShortCode"	=>	$businessShortCode,
                                            "billRefNumber"		=>	$billRefNumber,
                                            "invoiceNumber"		=>	$invoiceNumber,
                                            "orgAccountBalance"	=>	$orgAccountBalance,
                                            "thirdPartyTransID"	=>	$thirdPartyTransID,
                                            "MSISDN"			=>	$MSISDN,
                                            "firstName"			=>	$firstName,
                                            "lastName"			=>	$lastName,
                                            "middleName"		=>	$middleName,
                                            "transID"			=>	$transID,
                                            "transactionType"	=>	$transactionType
                                    );*/

        $this->epaper_integrate(
            [   'msisdn'        =>  $MSISDN,
                'ref'           =>  $transID,
                'amount'        =>  $transAmount,
                'account'       =>  $billRefNumber,
                'customer_name' =>  ucwords($firstName.' '.$middleName.' '.$lastName),
                'shortcode'     =>  $businessShortCode,
                'trans_type'    =>  $transactionType,
                'trans_time'    =>  date('Y-m-d H:i:s',strtotime($transTime))
            ]
        );
        /* $service_id = Service::where('prefix',getprefix($result["billRefNumber"]) )
                             ->where('shortcode',$result["businessShortCode"])
                             ->first()
                             ->id;
         return $result;*/
    }
    public function processAccountBalanceRequestCallback()
    {
        $callbackJSONData=file_get_contents('php://input');
        $callbackData=json_decode($callbackJSONData);
        $resultType=$callbackData->Result->ResultType;
        $resultCode=$callbackData->Result->ResultCode;
        $resultDesc=$callbackData->Result->ResultDesc;
        $originatorConversationID=$callbackData->Result->OriginatorConversationID;
        $conversationID=$callbackData->Result->ConversationID;
        $transactionID=$callbackData->Result->TransactionID;
        $accountBalance=$callbackData->Result->ResultParameters->ResultParameter[0]->Value;
        $BOCompletedTime=$callbackData->Result->ResultParameters->ResultParameter[1]->Value;

        $result=array(
            "resultDesc"                  =>$resultDesc,
            "resultCode"                  =>$resultCode,
            "originatorConversationID"    =>$originatorConversationID,
            "conversationID"              =>$conversationID,
            "transactionID"               =>$transactionID,
            "accountBalance"              =>$accountBalance,
            "BOCompletedTime"             =>$BOCompletedTime,
            "resultType"                  =>$resultType
        );




    }
    public function processReversalRequestCallBack()
    {

        $callbackJSONData=file_get_contents('php://input');

        $callbackData = json_decode($callbackJSONData);
        $resultType=$callbackData->Result->ResultType;
        $resultCode=$callbackData->Result->ResultCode;
        $resultDesc=$callbackData->Result->ResultDesc;
        $originatorConversationID=$callbackData->Result->OriginatorConversationID;
        $conversationID=$callbackData->Result->ConversationID;
        $transactionID=$callbackData->Result->TransactionID;

        $result=array(
            "resultType"                  =>$resultType,
            "resultCode"                  =>$resultCode,
            "resultDesc"                  =>$resultDesc,
            "conversationID"              =>$conversationID,
            "transactionID"               =>$transactionID,
            "originatorConversationID"    =>$originatorConversationID
        );


    }
    public function processSTKPushRequestCallback()
    {
        $callbackJSONData=file_get_contents('php://input');
        $callbackData=json_decode($callbackJSONData)->Body;
        $resultCode=$callbackData->stkCallback->ResultCode;
        $resultDesc=$callbackData->stkCallback->ResultDesc;
        $merchantRequestID=$callbackData->stkCallback->MerchantRequestID;
        $checkoutRequestID=$callbackData->stkCallback->CheckoutRequestID;
        $amount=$callbackData->stkCallback->CallbackMetadata->Item[0]->Value;
        $mpesaReceiptNumber=$callbackData->stkCallback->CallbackMetadata->Item[1]->Value;
        $balance=$callbackData->stkCallback->CallbackMetadata->Item[2]->Value;
        $transactionDate=$callbackData->stkCallback->CallbackMetadata->Item[3]->Value;
        $phoneNumber=$callbackData->stkCallback->CallbackMetadata->Item[4]->Value;

        $result = array(
            "resultDesc"=>$resultDesc,
            "resultCode"=>$resultCode,
            "merchantRequestID"=>$merchantRequestID,
            "checkoutRequestID"=>$checkoutRequestID,
            "amount"=>$amount,
            "mpesaReceiptNumber"=>$mpesaReceiptNumber,
            "balance"=>$balance,
            "transactionDate"=>$transactionDate,
            "phoneNumber"=>$phoneNumber
        );


    }
    public function processSTKPushQueryRequestCallback()
    {
        $callbackJSONData 		=	file_get_contents('php://input');
        $callbackData 			=	json_decode($callbackJSONData);
        $responseCode 			=	$callbackData->ResponseCode;
        $responseDescription 	=	$callbackData->ResponseDescription;
        $merchantRequestID 		=	$callbackData->MerchantRequestID;
        $checkoutRequestID 		=	$callbackData->CheckoutRequestID;
        $resultCode 			=	$callbackData->ResultCode;
        $resultDesc 			=	$callbackData->ResultDesc;

        $result=array(
            "resultCode" 			=>	$resultCode,
            "responseDescription" 	=>	$responseDescription,
            "responseCode" 			=>	$responseCode,
            "merchantRequestID" 	=>	$merchantRequestID,
            "checkoutRequestID" 	=> 	$checkoutRequestID,
            "resultDesc" 			=>	$resultDesc
        );


    }
    public function processTransactionStatusRequestCallback()
    {
        $callbackJSONData=file_get_contents('php://input');
        $callbackData=json_decode($callbackJSONData);
        $resultCode=$callbackData->Result->ResultCode;
        $resultDesc=$callbackData->Result->ResultDesc;
        $originatorConversationID=$callbackData->Result->OriginatorConversationID;
        $conversationID=$callbackData->Result->ConversationID;
        $transactionID=$callbackData->Result->TransactionID;
        $ReceiptNo=$callbackData->Result->ResultParameters->ResultParameter[0]->Value;
        $ConversationID=$callbackData->Result->ResultParameters->ResultParameter[1]->Value;
        $FinalisedTime=$callbackData->Result->ResultParameters->ResultParameter[2]->Value;
        $Amount=$callbackData->Result->ResultParameters->ResultParameter[3]->Value;
        $TransactionStatus=$callbackData->Result->ResultParameters->ResultParameter[4]->Value;
        $ReasonType=$callbackData->Result->ResultParameters->ResultParameter[5]->Value;
        $TransactionReason=$callbackData->Result->ResultParameters->ResultParameter[6]->Value;
        $DebitPartyCharges=$callbackData->Result->ResultParameters->ResultParameter[7]->Value;
        $DebitAccountType=$callbackData->Result->ResultParameters->ResultParameter[8]->Value;
        $InitiatedTime=$callbackData->Result->ResultParameters->ResultParameter[9]->Value;
        $OriginatorConversationID=$callbackData->Result->ResultParameters->ResultParameter[10]->Value;
        $CreditPartyName=$callbackData->Result->ResultParameters->ResultParameter[11]->Value;
        $DebitPartyName=$callbackData->Result->ResultParameters->ResultParameter[12]->Value;

        $result=array(
            "resultCode"=>$resultCode,
            "resultDesc"=>$resultDesc,
            "originatorConversationID"=>$originatorConversationID,
            "conversationID"=>$conversationID,
            "transactionID"=>$transactionID,
            "ReceiptNo"=>$ReceiptNo,
            "ConversationID"=>$ConversationID,
            "FinalisedTime"=>$FinalisedTime,
            "Amount"=>$Amount,
            "TransactionStatus"=>$TransactionStatus,
            "ReasonType"=>$ReasonType,
            "TransactionReason"=>$TransactionReason,
            "DebitPartyCharges"=>$DebitPartyCharges,
            "DebitAccountType"=>$DebitAccountType,
            "InitiatedTime"=>$InitiatedTime,
            "OriginatorConversationID"=>$OriginatorConversationID,
            "CreditPartyName"=>$CreditPartyName,
            "DebitPartyName"=>$DebitPartyName
        );

        return json_encode($result);
    }
    public function epaper_integrate($detail)
    {
        try {
                $moneyfromnumber    =   $detail['msisdn'];
                $ref                =   $detail['ref'];
                $amount             =   $detail['amount'];
                $account            =   $detail['account'];
                $userpass           =   '434345343!@@!663535!@dgd53';
                $channel            =   $detail['trans_type'];
                $ticket_hub         =   trim(substr($account, 0, 2));
                $ticket_hub         =   trim(strtoupper($ticket_hub));
                $ticket_hub         =   trim(strip_tags($ticket_hub));
                $msape              =   trim(substr($account, 0, 2));
                $msape              =   trim(strtoupper($msape));
                $msape              =   trim(strip_tags($msape));
                $epaper             =   trim(strip_tags($account));
                $epaper             =   trim(substr($epaper, 0, 3));
                $epaper             =   trim(strtoupper($epaper));
                $digger             =   trim(strip_tags($account));
                $digger             =   trim(substr($digger, 0, 1));
                $digger             =   trim(strtoupper($digger));
                $data               =   array(
                                                "shortcode_id"      =>  Shortcode::where('shortcode',$detail['shortcode'])->first()->id,
                                                "msisdn"            =>  $moneyfromnumber,
                                                "amount"            =>  $amount,
                                                "account"           =>  $account,
                                                "channel"           =>  $channel,
                                                "transaction_code"  =>  $ref,
                                                "trans_time"        =>  $detail["trans_time"]
                                            );

            if ($digger == "D")
            {
                $param  = array(
                    "type"          =>  $channel,
                    "msisdn"        =>  $moneyfromnumber,
                    "amount"        =>  $amount,
                    "transactionno" =>  $ref,
                    "timecomplete"  =>  $detail->TransTime,
                    "orderid"       =>  $account,
                    "status"        =>  "success"
                );
                $data['type']   =   'digger';
                $url            =   array("https://digger.co.ke/payment/mpesa/done");
            }
            if ($digger == "M")
            {
                $param          = array(
                    "GatewayType"   =>  "mPesa PayBill",
                    "Paymentstatus" =>  "Y",
                    "msisdn"        =>  $moneyfromnumber,
                    "PaidAmt"       =>  $amount,
                    "TransactionID" =>  $ref,
                    "timecomplete"  =>  $detail['trans_time'],
                    "Orderid"       =>  $account
                );
                $data['type']   =   'epaper';
                $url            =   array("https://newsstand.standardmedia.co.ke/frmstatus.aspx");
            }
            if ($ticket_hub == 'TK')
            {
                $param          =   array(
                    'sender_phone'   =>     $moneyfromnumber,
                    'amount'         =>     $amount,
                    'transaction'    =>     $account,
                    'type'           =>     $channel,
                    'mpesa_code'     =>     $ref,
                    'origin'         =>     'events'
                );
                $data['type']   =   'epaper';
                $url            =   array('https://www.tickethub.co.ke/transaction');
            }
            if ($ticket_hub == 'ET')
            {
                $param          =   array(
                    'sender_phone'   =>     $moneyfromnumber,
                    'amount'         =>     $amount,
                    'transaction'    =>     $account,
                    'type'           =>     $channel,
                    'mpesa_code'     =>     $ref,
                    'origin'         =>     'events'
                );
                $data['type']   =   'epaper';
                $param          =   json_encode($param);
                $url            =   array('https://vas.standardmedia.co.ke/api/paymentRequest/confirm','https://ktnkenya.com/msape/public/api/mobile/transact');
            }
            if ($ticket_hub == 'TN')
            {
                $param          =   array(
                    'sender_phone' => $moneyfromnumber,
                    'amount'       => $amount ,
                    'transaction'  => $account,
                    'type'         => $channel,
                    'mpesa_code'   => $ref
                );
                $data['type']   =   'nairobian';
                $url            =   array('https://www.thenairobian.ke/payments/mpesa/callback');
            }
            if ($msape == 'VS')
            {
                $param          =   array(
                    'sender_phone'  =>  $moneyfromnumber,
                    'amount'        =>  $amount ,
                    'transaction'   =>  $account,
                    'type'          =>  $channel,
                    'mpesa_code'    =>  $ref,
                    'origin'        => 'vas'
                );
//                $param          =   json_encode($param);
                $data['type']   =   'vas';
                $url            =   array('https://vas.standardmedia.co.ke/api/paymentRequest/confirm','https://ktnkenya.com/msape/public/api/mobile/transact');
            }
            if ($epaper == 'ELE')
            {
                $param          =   array(
                    'sender_phone'  =>  $moneyfromnumber,
                    'amount'        =>  $amount ,
                    'transaction'   =>  $account,
                    'type'          =>  $channel,
                    'mpesa_code'    =>  $ref,
                    'origin'        => 'E-learning'
                );
                $param          =   json_encode($param);
                $data['type']   =   'E-learning';
                $url            =   array('https://tutorsoma.standardmedia.co.ke/api/payments/mpesa/callback');
            }
            if ($msape == 'BD')
            {
                $param          =   array(
                    'sender_phone'  =>  $moneyfromnumber,
                    'amount'        =>  $amount ,
                    'transaction'   =>  $account,
                    'type'          =>  $channel,
                    'mpesa_code'    =>  $ref,
                    'origin'        => 'belva'
                );
                $param          =   json_encode($param);
                $data['type']   =   'Belva';
                $url            =   array('https://app.axis.africa/secure/standard_mpesa','https://posthere.io/dc5a-49b4-8585');
            }
            if ($epaper == 'EPK')
            {
                $param          =   array(
                    'sender_phone'   =>     $moneyfromnumber,
                    'amount'         =>     $amount,
                    'transaction'    =>     $account,
                    'type'           =>     $channel,
                    'mpesa_code'     =>     $ref,
                    'origin'         =>     'epaper'
                );
                $data['type']   =   'EPAPER';
                $url = array('https://www.standardmedia.co.ke/epaper_payment');
            }
            if ($epaper == 'PDS')
            {
                {
                    $param     = array(
                        'sender_phone'  => $moneyfromnumber,
                        'amount'        => $amount,
                        'transaction'   => $account,
                        'type'          => $channel,
                        'mpesa_code'    => $ref,
                        'origin'        => 'PDS'
                    );
                    $data['type']   = 'PDS';
                    $url = array('https://www.standardmedia.co.ke/pds_payment');
                }
            }
            if ($ticket_hub != 'TK' && $epaper != 'EPK'  && $epaper != 'PDS' && $digger != 'D' && $digger != 'M' && $msape != 'BD' && $msape != 'VS' && $ticket_hub != 'TN' && $epaper != 'ELE')
            {
                $account        =   'eaa' . $account;
                $param          =   array(
                    'userpass'  =>  $userpass,
                    'amount='   =>  $amount,
                    'account'   =>  $account,
                    'type'      =>  $channel,
                    'ref='      =>  $ref
                );
                $data['type']   =   'others';
                $url            =   array('https://www.standardmedia.co.ke/rss/standardpaper/handle_payments.php');

            }
            $trans                      =   new Transaction();
            $trans->shortcode_id        =   $data["shortcode_id"];
            $trans->msisdn              =   $data["msisdn"];
            $trans->amount              =   $data["amount"];
            $trans->account             =   $data["account"];
            $trans->channel             =   $data["channel"];
            $trans->transaction_code    =   $data["transaction_code"];
            $trans->trans_time          =   $data["trans_time"];
            $trans->type                =   $data["type"];
            $trans->source              =   "MPESA";
            $trans->customer_name       =   $detail["customer_name"];
            $trans->save();
            $this->emailnotify($detail);
            $this->curl_function($url,$param);
            Log::info($detail);
        }
        catch(Exception $e)
        {
            Log::info($e->getMessage());
        }

    }
    public function emailnotify($dt)
    {

        //For all payments done, please sent a notification with proper caption to onlineaccounts@standardmedia.co.ke
        $efrom      =   "online@standardmedia.co.ke";
        $eto        =   "onlineaccounts@standardmedia.co.ke";
        $ecc        =   " jkidambi@standardmedia.co.ke, cronoh@standardmedia.co.ke, dokuthe@standardmedia.co.ke, nmangala@standardmedia.co.ke, bsikuku@standardmedia.co.ke, hmadadi@standardmedia.co.ke,kanami@standardmedia.co.ke,dkiptugen@standardmedia.co.ke";
        $esub       =   "MPESA INSTANT PAYMENT NOTIFICATION - PAYBILL NUMBER 505604";
        $emsg       =   '<p> This is an email alert to inform you that we have received MPESA Payment</p>' .
            '<p> Transaction ID: ' . $dt['ref'] . '</p>
                                 <p> Sender Number: ' . $dt['msisdn'] . '</p>
                                 <p> Sender Name: ' . $dt['customer_name'] . '</p>
                                 <p> Amount: ' . $dt['amount'] . '</p>
                                 <p> MPESA account: ' .$dt['account'] . '</p>
                                 <p> MPESA Code: ' . $dt['ref'] . '</p>
                                 <p> Transaction Time: ' . $dt['trans_time'] . '</p>
                                 <p><br><br></p>
                                 <p>Thanks and best regards,</p>
                                 <p>Standard Digital</p>
                                ';
        /*Mail::to($eto)
            ->from($efrom)
            ->cc($ecc)
            ->subject($esub)
            ->send($emsg);*/
    }
    public function postdata($url,$data)
        {
            $client = new \GuzzleHttp\Client();
            foreach($url as $link)
                {
                    $request = $client->post($link,  ['form_params'=>$data]);

                }


        }
    public function curl_function($url, $param)
        {
            foreach($url as $link)
                {
                    $ch = curl_init($link);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
                    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
                    $result = curl_exec($ch);
                    curl_close($ch);
                    Log::debug($result);
                }
        }
}

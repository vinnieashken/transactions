<?php
namespace App\Utils;

class Config_dev
	{
        public $reversal_resultUrl;
        public $reversal_timeoutURL;
        public $checkout_rcallbackurl;
        public $checkout_qcallbackurl;
        public $balance_timeoutUrl;
        public $balance_resultUrl;
        public $c2b_confirmationUrl;
        public $c2b_validationUrl;
        public $transtat_resultURL;
        public $transtat_timeoutURL;
        public $b2b_timeoutURL;
        public $b2b_resultURL;
        public $b2c_timeoutURL;
        public $b2c_resultURL;
		public $token_link				=	'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
		public $checkout_processlink	=	'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
	    public $checkout_querylink		=	'https://sandbox.safaricom.co.ke/mpesa/stkpushquery/v1/query';
		public $reversal_link			=	'https://sandbox.safaricom.co.ke/mpesa/reversal/v1/request';
		public $balance_link			=	'https://sandbox.safaricom.co.ke/mpesa/accountbalance/v1/query';
		public $c2b_regiterUrl			=  	'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/registerurl';
		public $transtat_link			=	'https://sandbox.safaricom.co.ke/mpesa/transactionstatus/v1/query';
		public $b2b_link				= 	'https://sandbox.safaricom.co.ke/mpesa/b2b/v1/paymentrequest';
		public $b2c_link				=	'https://sandbox.safaricom.co.ke/mpesa/b2c/v1/paymentrequest';

        public function __construct()
            {

                $this->checkout_rcallbackurl    =	url("RequestStkCallback");
                $this->checkout_qcallbackurl    =	url("QueryStkCallback");
                $this->reversal_resultUrl		=	url("ReversalCallback");
                $this->reversal_timeoutURL	    =	url("ReversalCallback");
                $this->balance_timeoutUrl		=	url("AccountBalCallback");
                $this->balance_resultUrl		=	url("AccountBalCallback");
                $this->c2b_confirmationUrl	    = 	url("C2BConfirmation");
                $this->c2b_validationUrl		= 	url("C2BValidation");
                $this->transtat_resultURL		=	url("TransStatCallback");
                $this->transtat_timeoutURL	    =	url("TransStatCallback");
                $this->b2b_timeoutURL			=	url("B2BCallback");
                $this->b2b_resultURL			=	url("B2BCallback");
                $this->b2c_timeoutURL			=	url("B2CCallback");
                $this->b2c_resultURL			=	url("B2CCallback");
            }

    }

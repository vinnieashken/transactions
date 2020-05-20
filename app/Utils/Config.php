<?php
namespace App\Utils;

class Config
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
		public $token_link				=	'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
		public $checkout_processlink	=	'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
	    public $checkout_querylink		=	'https://api.safaricom.co.ke/mpesa/stkpushquery/v1/query';
		public $reversal_link			=	'https://api.safaricom.co.ke/mpesa/reversal/v1/request';
		public $balance_link			=	'https://api.safaricom.co.ke/mpesa/accountbalance/v1/query';
		public $c2b_regiterUrl			=  	'https://api.safaricom.co.ke/mpesa/c2b/v1/registerurl';
		public $transtat_link			=	'https://api.safaricom.co.ke/mpesa/transactionstatus/v1/query';
		public $b2b_link				= 	'https://api.safaricom.co.ke/mpesa/b2b/v1/paymentrequest';
		public $b2c_link				=	'https://api.safaricom.co.ke/mpesa/b2c/v1/paymentrequest';

        public function __construct()
            {

                $this->checkout_rcallbackurl    =	url("api/requeststkcallback");
                $this->checkout_qcallbackurl    =	url("api/querystkcallback");
                $this->reversal_resultUrl		=	url("api/reversalcallback");
                $this->reversal_timeoutURL	    =	url("api/reversalcallback");
                $this->balance_timeoutUrl		=	url("api/accountbalballback");
                $this->balance_resultUrl		=	url("api/accountbalcallback");
                $this->c2b_confirmationUrl	    = 	url("api/c2bconfirmation");
                $this->c2b_validationUrl		= 	url("api/c2bvalidation");
                $this->transtat_resultURL		=	url("api/transstatcallback");
                $this->transtat_timeoutURL	    =	url("api/transstatcallback");
                $this->b2b_timeoutURL			=	url("api/b2bcallback");
                $this->b2b_resultURL			=	url("api/b2bcallback");
                $this->b2c_timeoutURL			=	url("api/b2ccallback");
                $this->b2c_resultURL			=	url("api/b2ccallback");
            }

    }

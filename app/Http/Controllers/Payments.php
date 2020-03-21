<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Service;
use App\Models\Shortcode;
use App\Models\Setting;
use App\User;
use Illuminate\Http\Request;
use App\Utils\Mpesa;
use Illuminate\Support\Facades\Input;

class Payments extends Controller
	{
		public $mpesa;
		public $data;
	    public function __construct()
			{
                $this->middleware('auth');
				$this->mpesa            =   new Mpesa();

			}

		public function index()
			{
                $this->data['user']     =   Role::where('user_id',\Auth::User()->id)->where('access_name','users')->first();
                $this->data['userimg']  =   Role::where('user_id',\Auth::User()->id)->where('access_name','thumbnail')->first();
                return view('admin.modules.dashboard',$this->data);
			}

        public function shortcode()
            {
                $this->data['user']         =   Role::where('user_id',\Auth::User()->id)->where('access_name','users')->first();
                $this->data['userimg']      =   Role::where('user_id',\Auth::User()->id)->where('access_name','thumbnail')->first();
                $this->data['shortcode']    =   Shortcode::paginate(10);
                return view('admin.modules.shortcode',$this->data);


            }
        public function saveshortcode(Request $request)
            {
                $shortcode                  =   new Shortcode();
                $shortcode->shortcode       =   $request->shortcode;
                //$shortcode->shortcode_type  =   $request->type;
                $shortcode->consumerkey     =   trim($request->consumerkey);
                $shortcode->consumersecret  =   trim($request->consumersecret);
                $shortcode->user_id         =   \Auth::User()->id;
                return $shortcode->save();
            }
        public function editshortcode(Request $request)
            {

                $shortcode                  =   Shortcode::find($request->id);
                $shortcode->shortcode       =   $request->shortcode;
                $shortcode->shortcode_type  =   $request->type;
                $shortcode->consumerkey     =   trim($request->consumerkey);
                $shortcode->consumersecret  =   trim($request->consumersecret);
                return $shortcode->save();
            }
        public function startnotification(Request $request)
            {

                $start =  $this->mpesa-> C2B_REGISTER(['consumerkey'=>$request->consumerkey,'consumersecret'=>$request->consumersecret,'shortcode'=>$request->shortcode]);
                $data   =   json_decode($start);
                if(in_array("ResponseDescription",$data))
                    {
                        if($data["ResponseDescription"] == 'success')
                            {
                                Shortcode::where('id',$request->id)
                                         ->update(['status',1]);
                                return true;
                            }
                    }
            }


        public function services()
            {
                $this->data['user']     =   Role::where('user_id',\Auth::User()->id)->where('access_name','users')->first();
                $this->data['userimg']  =   Role::where('user_id',\Auth::User()->id)->where('access_name','thumbnail')->first();
                $this->data['services'] =   Service::paginate(10);
                return view('admin.modules.service',$this->data);


            }
		public function register($shortcode)
			{
				//$result		=	$this->mpesa->C2B_REGISTER($shortcode);
				$scode = new Shortcode();
				$code = $scode->where('shortcode',$shortcode)->first();



				$setting = new Setting();

				//$setting->save([]);
				$setting->shortcode_id = $code->id;
				$setting->meta_name = "dandia doh";
				$setting->meta_value = "Active";
				$setting->userid = 1;
				$setting->save();



				//print_r($result);
			}
		public function checkout()
			{
				$mrq	=	$this->input->raw_input_stream;
				@file_put_contents(APPPATH."logs/mpesarq.txt", "\n".$mrq,FILE_APPEND);
				$mrq 	=	json_decode($mrq);
				if(isset($mrq))
					{
						$phone  = 	$this->assist->localizePhoneNumber($mrq->phoneno);
						$mpesa 	=	json_decode($this->mpesa->checkout($phone,$mrq->amount,substr($mrq->orderid,0,10),"payment for the epaper"));
						@file_put_contents(APPPATH."logs/mpesarequestres.txt", "\n".$mpesa,FILE_APPEND);
						if(isset($mpesa->ResponseCode))
							{
								if($mpesa->ResponseCode === "0")
									{
										$val 	=	array(
															"CheckoutRequestID" =>	$mpesa->CheckoutRequestID,
															"merchant_id"	 	=> 	$mpesa->MerchantRequestID,
															"amount"  			=>	$mrq->amount,
															"order_id"			=>	$mrq->orderid,
															// "email"				=>	$mrq->email,
															"date_created"		=>	date("Y-m-d H:i:s"),
															"paymentmode"		=>	"mpesa",
															// "currencycode"		=>  $mrq->currencycode,
															"phonenumber"		=>	(int)$phone
										             	);
										$x		=	$this->hmode->processPayment($val);
										$x      =   (object)array("status"=>$x);
										$this->output->set_content_type('application/json')
						        					 ->set_output(json_encode($x));
					        		}
					        	else
						        	{
						        		$x		=	"Failed";
										$x      =   (object)array("status"=>$x,"response"=>"request failed");
										$this->output->set_content_type('application/json')
						        					 ->set_output(json_encode($x));
						        	}
					        }
					    else
				        	{
				        		$x		=	"Failed";
								$x      =   (object)array("status"=>$x,"response"=>"No handshake made to safaricom");
								$this->output->set_content_type('application/json')
				        					 ->set_output(json_encode($x));
				        	}
			        }
			    else
		        	{
		        		$x		=	"Failed";
						$x      =   (object)array("status"=>$x,"response"=>"invalid Json");
						$this->output->set_content_type('application/json')
		        					 ->set_output(json_encode($x));
		        	}
			}

	}

<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmail;
use App\Models\Role;
use App\Models\Service;
use App\Models\Shortcode;
use App\Models\Setting;
use App\Models\Transaction;
use App\Models\User_meta;
use App\User;
use Illuminate\Http\Request;
use App\Utils\Mpesa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;

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
                foreach (Service::all() as $value)
                    {
                        $this->data["report"][$value->service_name] = Transaction::where("type", $value->service_name)->where("trans_time", '>=', date('Y-m-d') . " 00:00:00")->sum("amount");
                    }
                $this->data['user'] = Role::where('user_id', \Auth::User()->id)->where('access_name', 'users')->first();
                $this->data['userimg'] = Role::where('user_id', \Auth::User()->id)->where('access_name', 'thumbnail')->first();
                return view('admin.modules.dashboard', $this->data);
			}
        public function index2(Request $request)
            {
                $dat    =   $request->all();
                foreach (Service::all() as $value)
                    {
                        $this->data["report"][$value->service_name] = Transaction::where("type", $value->service_name)->where("trans_time", '>=', $dat['start'] . " 00:00:00")->where("trans_time", '<=', $dat['end'] . " 23:59:59")->sum("amount");
                    }
                $this->data['user'] = Role::where('user_id', \Auth::User()->id)->where('access_name', 'users')->first();
                $this->data['userimg'] = Role::where('user_id', \Auth::User()->id)->where('access_name', 'thumbnail')->first();
                return view('admin.modules.dashboard', $this->data);
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
                $validatedData = $request->validate([
                    'shortcode'         =>  'required|unique:shortcodes|integer',
                    'type'              =>  'required',
                    'consumerkey'       =>  'required',
                    'consumersecret'    =>  'required',
                    'passkey'           =>  'nullable'
                ]);

                if($validatedData)
                    {
                        $shortcode                  =   new Shortcode();
                        $shortcode->shortcode       =   $request->shortcode;
                        $shortcode->shortcode_type  =   $request->type;
                        $shortcode->consumerkey     =   trim($request->consumerkey);
                        $shortcode->consumersecret  =   trim($request->consumersecret);
                        $shortcode->passkey         =   trim($request->passkey);
                        $shortcode->user_id         =   \Auth::User()->id;
                        $req                        =   $shortcode->save();
                        if($req)
                            {
                                return array('status'=>TRUE,'msg'=>'Shortcode insert successful','header'=>'shortcode');
                            }
                        else
                            {
                                return array('status'=>False,'msg'=>'Shortcode insert not successful','header'=>'shortcode');
                            }
                    }
                else
                    {
                       return array('status'=>FALSE,'msg'=>$validatedData->errors());
                    }

            }
        public function editshortcode(Request $request)
            {
                $validatedData = $request->validate([
                    'shortcode'         =>  'required|integer',
                    'type'              =>  'required',
                    'consumerkey'       =>  'required',
                    'consumersecret'    =>  'required',
                    'passkey'           =>  'nullable'
                ]);
                if($validatedData)
                    {
                        $shortcode                  =   Shortcode::find($request->id);
                        $shortcode->shortcode       =   $request->shortcode;
                        $shortcode->shortcode_type  =   $request->type;
                        $shortcode->consumerkey     =   trim($request->consumerkey);
                        $shortcode->consumersecret  =   trim($request->consumersecret);
                        $shortcode->passkey         =   trim($request->passkey);
                        $req                        =   $shortcode->save();

                        if($req)
                            {
                                return array('status'=>TRUE,'msg'=>'Shortcode edit successful','header'=>'shortcode');
                            }
                        else
                            {
                                return array('status'=>False,'msg'=>'Shortcode edit not successful','header'=>'shortcode');
                            }
                    }
                else
                    {
                        return array('status'=>FALSE,'msg'=>$validatedData->errors());
                    }
            }
        public function startnotification(Request $request)
            {

                $start  =   $this->mpesa-> C2B_REGISTER(['consumerkey'=>$request->consumerkey,'consumersecret'=>$request->consumersecret,'shortcode'=>$request->shortcode]);
                $data   =   (array)json_decode($start);
                //var_dump($data);
                Log::error($data);
                if(isset($data["ResponseDescription"]))
                    {
                        if($data["ResponseDescription"] == 'success')
                            {
                                $shortcode = Shortcode::find($request->id);
                                $shortcode->status = 1;
                                return $shortcode->save();

                            }
                        return false;
                    }
                return false;
            }


        public function services()
            {
                $this->data['user']     =   Role::where('user_id',\Auth::User()->id)->where('access_name','users')->first();
                $this->data['userimg']  =   Role::where('user_id',\Auth::User()->id)->where('access_name','thumbnail')->first();
                $this->data['services'] =   Service::paginate(10);
                return view('admin.modules.service',$this->data);


            }

        public function transaction()
            {
                $this->data['user']     =   Role::where('user_id',\Auth::User()->id)->where('access_name','users')->first();
                $this->data['userimg']  =   Role::where('user_id',\Auth::User()->id)->where('access_name','thumbnail')->first();
                $this->data['services'] =   Service::paginate(10);
                return view('admin.modules.transaction',$this->data);
            }
        public function addservice(Request $request)
            {
                $validatedData = $request->validate([
                    'prefix'                =>  'nullable|max:4|alpha',
                    'shortcode'             =>  'required|integer',
                    'service_name'          =>  'required',
                    'description'           =>  'required',
                    'verification_callback' =>  'nullable|url',
                    'response_callback'     =>  'required|url'
                ]);
                if($validatedData)
                    {
                        $service                      = new Service();
                        $service->prefix              = $request->prefix;
                        $service->shortcode_id        = $request->shortcode;
                        $service->service_name        = $request->service_name;
                        $service->service_description = $request->description;
                        $service->verification_url    = $request->verification_callback;
                        $service->callback_url        = $request->response_callback;
                        $req                          = $service->save();
                        if($req)
                            {
                                return array('status'=>TRUE,'msg'=>'Service created successful','header'=>'Service');
                            }
                        else
                            {
                                return array('status'=>False,'msg'=>'Service creation failed','header'=>'Service');
                            }
                    }
                else
                    {
                        return array('status'=>FALSE,'msg'=>$validatedData->errors());
                    }
            }
        public function editservice(Request $request)
            {
                $validatedData = $request->validate([
                    'prefix'                =>  'nullable|max:4|alpha',
                    'shortcode'             =>  'required|integer',
                    'service_name'          =>  'required',
                    'description'           =>  'required',
                    'verification_callback' =>  'nullable|url',
                    'response_callback'     =>  'required|url'
                ]);
                if($validatedData)
                    {
                        $service                        =   Service::find($request->id);
                        $service->shortcode_id          =   $request->shortcode;
                        $service->prefix                =   $request->prefix;
                        $service->service_name          =   $request->service_name;
                        $service->service_description   =   $request->description;
                        $service->verification_url      =   $request->verification_callback;
                        $service->callback_url          =   $request->response_callback;
                        $req                            =   $service->save();
                        if($req)
                            {
                                return array('status'=>TRUE,'msg'=>'Service created successful','header'=>'Service');
                            }
                        else
                            {
                                return array('status'=>False,'msg'=>'Service creation failed','header'=>'Service');
                            }
                    }
                else
                    {
                        return array('status'=>FALSE,'msg'=>$validatedData->errors());
                    }
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
		public function add_user(Request $request)
            {
                $validatedData = $request->validate([
                    'email'                =>  'required|unique:users',
                    'fullname'             =>  'required',

                ]);
                if($validatedData)
                    {
                        $user           =   new User();
                        $user->name     =   $request->fullname;
                        $user->email    =   $request->email;
                        $user->username =   "Invite";
                        $user->status   =   1;
                        $req            =   $user->save();
                        if($req)
                        {
                            $usermeta               =   new User_meta();
                            $usermeta->user_id      =   $req->id;
                            $usermeta->access_name  =   'roles';
                            $usermeta->access_value =   serialize($request->roles);
                            $usermeta->save();

                            $data['email']      = $request->email;
                            $data['subject']    = "Welcome ".$request->fullname;
                            $data['cc']         =  '';

                            SendEmail::dispatch((object)$data);
                            return array('status'=>TRUE,'msg'=>'User created successful','header'=>'User');
                        }
                        else
                            {
                                return array('status'=>False,'msg'=>'User creation failed','header'=>'User');
                            }
                    }
                else
                    {
                        return array('status'=>FALSE,'msg'=>$validatedData->errors());
                    }
            }
        public function edit_user(Request $request)
            {

            }
        public function updaterecord(Request $request)
            {

                $res = DB::table($request->table)
                        ->where('id', (int)$request->id)
                        ->update([$request->column => $request->value]);
                if($res)
                    {
                        return array('status'=>TRUE,'msg'=>'Record update successful','header'=>ucfirst($request->table));
                    }
                else
                    {

                        return array('status'=>False,'msg'=>'Record update failed','header'=>ucfirst($request->table));
                    }
            }
    }

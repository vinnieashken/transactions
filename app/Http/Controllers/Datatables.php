<?php

namespace App\Http\Controllers;

use App\Models\Shortcode;
use App\Models\Transaction;
use App\User;
use Illuminate\Http\Request;

class Datatables extends Controller
    {
        public function get_users(Request $request)
            {
                $columns = array(
                    0   =>  'id',
                    1   =>  'name',
                    2   =>  'email',
                    3   =>  'status'

                );

                $totalData      = User::count();

                $totalFiltered  = $totalData;

                $limit  =   $request->input('length');
                $start  =   $request->input('start');
                $order  =   $columns[$request->input('order.0.column')];
                $dir    =   $request->input('order.0.dir');

                if(empty($request->input('search.value')))
                    {
                        $posts = User::offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();
                    }
                else
                {

                    $search     =   $request->input('search.value');


                    $posts  =   User::where('name','LIKE',"%{$search}%")
                                        ->orWhere('email', 'LIKE',"%{$search}%")
                                        ->orWhere('status', 'LIKE',"%{$search}%")
                                        ->offset($start)
                                        ->limit($limit)
                                        ->orderBy($order,$dir)
                                        ->get();

                    $totalFiltered = User::where('name','LIKE',"%{$search}%")
                                        ->orWhere('email', 'LIKE',"%{$search}%")
                                        ->orWhere('status', 'LIKE',"%{$search}%")
                                        ->count();
                }

                $data = array();
                if(!empty($posts))
                {
                    foreach ($posts as $post)
                    {
                        $actionbtn              =   ($post->status != 1)?'<a href="javascript:;"  class="text-dark updaterecord" data-column="status" data-table="users" data-value="0" data-id="'.$post->id.'">
                                                        <i class="fas fa-plus"></i>
                                                     </a>'
                                                     :'<a href="javascript:;"  class="text-dark updaterecord"  data-column="status" data-table="users" data-value="1"  data-id="'.$post->id.'">
                                                        <i class="fas fa-times"></i>
                                                     </a>';
                        $nestedData['id']       =   $post->id;
                        $nestedData['name']     =   $post->name;
                        $nestedData['email']    =   $post->email;
                        $nestedData['status']   =   ($post->status == 1)?'Active':"inactive";
                        $nestedData['action']   =   '<a href="javascript:;" class="text-dark mr-3 edit-user" data-user="'.$post.'"><i class="fas fa-edit  "></i></a>
                                                    '.$actionbtn;

                        $data[] = $nestedData;

                    }
                }

                $json_data = array(
                    "draw"            => intval($request->input('draw')),
                    "recordsTotal"    => intval($totalData),
                    "recordsFiltered" => intval($totalFiltered),
                    "data"            => $data,

                );

                echo json_encode($json_data);
            }
        public function alltrans(Request $request)
            {
                $columns = array(
                                    0   =>  'shortcode_id',
                                    1   =>  'transaction_code',
                                    2   =>  'account',
                                    3   =>  'msisdn',
                                    4   =>  'customer_name',
                                    5   =>  'type',
                                    6   =>  'channel',
                                    7   =>  'trans_time',
                                    8   =>  'amount'

                                );

                $totalData      = Transaction::count();

                $totalFiltered  = $totalData;

                $limit  =   $request->input('length');
                $start  =   $request->input('start');
                $order  =   $columns[$request->input('order.0.column')];
                $dir    =   $request->input('order.0.dir');

                if(empty($request->input('search.value')))
                    {
                        $posts = Transaction::offset($start)
                                            ->limit($limit)
                                            ->orderBy($order,$dir)
                                            ->get();
                        $sum   =  Transaction::offset($start)
                                                ->limit($limit)
                                                ->orderBy($order,$dir)
                                                ->sum('amount');
                    }
                else
                    {

                        $search     =   $request->input('search.value');
                        $shortcode  =   (Shortcode::where('shortcode','LIKE',"%{$search}%")->first())?Shortcode::where('shortcode','LIKE',"%{$search}%")->first()->id:FALSE;

                        $posts  =   Transaction::where('transaction_code','LIKE',"%{$search}%")
                                                ->orWhere('account', 'LIKE',"%{$search}%")
                                                ->orWhere('customer_name', 'LIKE',"%{$search}%")
                                                ->orWhere('msisdn', 'LIKE',"%{$search}%")
                                                ->orWhere('amount', 'LIKE',"%{$search}%")
                                                ->offset($start)
                                                ->limit($limit)
                                                ->orderBy($order,$dir)
                                                ->get();
                        $sum    =   Transaction::where('transaction_code','LIKE',"%{$search}%")
                                                ->orWhere('account', 'LIKE',"%{$search}%")
                                                ->orWhere('customer_name', 'LIKE',"%{$search}%")
                                                ->orWhere('msisdn', 'LIKE',"%{$search}%")
                                                ->orWhere('amount', 'LIKE',"%{$search}%")
                                                ->offset($start)
                                                ->limit($limit)
                                                ->orderBy($order,$dir)
                                                ->sum('amount');
                        $totalFiltered = Transaction::where('transaction_code','LIKE',"%{$search}%")
                                                    ->orWhere('account', 'LIKE',"%{$search}%")
                                                    ->orWhere('customer_name', 'LIKE',"%{$search}%")
                                                    ->orWhere('msisdn', 'LIKE',"%{$search}%")
                                                    ->orWhere('amount', 'LIKE',"%{$search}%")
                                                    ->count();
                    }

                $data = array();
                if(!empty($posts))
                    {
                        foreach ($posts as $post)
                            {
                                $nestedData['shortcode']        =   Shortcode::where('id',$post->shortcode_id)->first()->shortcode;
                                $nestedData['transaction_code'] =   $post->transaction_code;
                                $nestedData['account']          =   $post->account;
                                $nestedData['amount']           =   $post->amount;
                                $nestedData['msisdn']           =   $post->msisdn;
                                $nestedData['customer_name']    =   $post->customer_name;
                                $nestedData['origin']           =   $post->type;
                                $nestedData['channel']          =   $post->channel;
                                $nestedData['transaction_time'] =   date('j M Y h:i a',strtotime($post->trans_time));
                                //$nestedData['total']            =   $sum;
                                $data[] = $nestedData;

                            }
                    }

                $json_data = array(
                                    "draw"            => intval($request->input('draw')),
                                    "recordsTotal"    => intval($totalData),
                                    "recordsFiltered" => intval($totalFiltered),
                                    "data"            => $data,
                                    "total"           =>  $sum
                                );

                echo json_encode($json_data);
            }
    }

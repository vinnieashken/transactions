<?php

namespace App\Http\Controllers;

use App\Models\Shortcode;
use App\Models\Transaction;
use Illuminate\Http\Request;

class Datatables extends Controller
    {
        public function get_users(Request $request)
            {

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

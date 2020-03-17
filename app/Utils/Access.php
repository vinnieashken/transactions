<?php


namespace App\Utils;


class Access
    {
        public $roles;
        public function __construct()
            {
                $this->roles      =     [
                                            'Finance'       =>  [
                                                                    'report'        =>  ['view'  =>   1],
                                                                    'user'          =>  ['add'   =>   11, 'disable'   =>  12, 'update'=>  13],
                                                                    'transaction'   =>  ['B2C'   =>   21, 'reversal'  =>  22, 'check Balance' => 23, 'B2B' => 24]
                                                                ],
                                            'Admin'         =>  [
                                                                    'user'          =>  ['add'   =>   31, 'disable'   =>  32, 'update'=>  33]
                                                                ],
                                            'Customer Care' =>  [
                                                                    'report'        =>  ['view'  =>   41],
                                                                    'user'          =>  ['add'   =>   51, 'disable'   =>  52]
                                                                ]

                                        ];

            }
        public function rolemgt($data)
            {

            }
    }

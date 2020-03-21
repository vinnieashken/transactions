<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shortcode extends Model
    {
        //
        protected $table = "shortcodes";


        public function settings()
            {
                return $this->hasMany('App\Models\Setting');
            }
        public function updatedata($where,$data)
            {
                $con = new Shortcode();
                foreach($where as $key => $value)
                    {
                        $con->where($key,$value);
                    }
               return  $con->update($data);
            }


    }

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
    }

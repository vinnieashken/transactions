<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
    {
        protected $table = "services";
        public function shortcode()
            {
                return $this->belongsTo('App\Models\Shortcode');
            }
    }

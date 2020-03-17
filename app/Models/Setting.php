<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
    {
        protected $table = 'settings';

        public function Shortcode()
        {
            return $this->belongsTo('App\Models\Shortcode');
        }
    }



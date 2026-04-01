<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class Code extends Model
    {
        protected $table        = 'stars.kod';
        public    $timestamps   = false;
        public    $incrementing = false;
        protected $primaryKey   = null;
    }

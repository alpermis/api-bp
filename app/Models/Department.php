<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class Department extends Model
    {
        protected $table        = 'bolum';
        protected $primaryKey   = 'bolum_kod';
        public    $incrementing = false;
        protected $keyType      = 'string';
        public    $timestamps   = false;
    }

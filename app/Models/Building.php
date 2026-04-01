<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class Building extends Model
    {
        protected $table        = 'bina';
        protected $primaryKey   = 'bina_kod';
        public    $incrementing = false;
        protected $keyType      = 'string';
        public    $timestamps   = false;
    }

<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class Faculty extends Model
    {
        protected $table        = 'fakulte';
        protected $primaryKey   = 'fakulte_kod';
        public    $incrementing = false;
        protected $keyType      = 'string';
        public    $timestamps   = false;
    }

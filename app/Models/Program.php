<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class Program extends Model
    {
        protected $table        = 'eprogram';
        protected $primaryKey   = 'program_kod';
        public    $incrementing = false;
        protected $keyType      = 'string';
        public    $timestamps   = false;
    }

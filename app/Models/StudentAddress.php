<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class StudentAddress extends Model
    {
        protected $table      = 'ogrenci_adres';
        protected $primaryKey = 'ogrenci_no';
        public    $timestamps = false;

        protected static function boot()
        {
            parent::boot();

            static::addGlobalScope('select_fields', function ($builder) {
                $builder->select([
                            'ogrenci_no',
                            'adres1',
                            'adres2',
                            'adres3',
                            'adres_il',
                            'posta_kod',
                            'adres_ulke',
                            'ikamet_adresi'
                        ]);
            });
        }
    }

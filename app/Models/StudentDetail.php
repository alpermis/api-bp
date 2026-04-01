<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class StudentDetail extends Model
    {
        protected $table      = 'ogrenci_detay';
        protected $primaryKey = 'ogrenci_no';
        public    $timestamps = false;

        protected static function boot()
        {
            parent::boot();

            static::addGlobalScope('select_fields', function ($builder) {
                $builder->select([
                                     'ogrenci_no',
                                     'mobil_tel',
                                     'anne_tel',
                                     'baba_tel',
                                     'anne_ad',
                                     'anne_soyad',
                                     'baba_ad',
                                     'baba_soyad',
                                     'acil_ad_soyad',
                                     'acil_cep_tel'
                                 ]);
            });
        }
    }

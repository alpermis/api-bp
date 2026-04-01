<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\HasOne;

    class Staff extends Model
    {
        protected $table      = 'hoca';
        protected $primaryKey = 'sicil_no';
        public    $timestamps = false;

        public function detail(): HasOne
        {
            return $this->hasOne(StaffDetail::class, 'sicil_no', 'sicil_no');
        }
    }

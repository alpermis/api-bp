<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;

    class StaffDetail extends Model
    {
        protected $table      = 'hoca_detay';
        protected $primaryKey = 'sicil_no';
        public    $timestamps = false;

        public function building(): BelongsTo
        {
            return $this->belongsTo(Building::class, 'bina_kod', 'bina_kod');
        }
    }

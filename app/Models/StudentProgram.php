<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    use Illuminate\Database\Eloquent\Relations\HasOne;

    class StudentProgram extends Model
    {
        protected $table        = 'ogrenci_eprogram';
        public    $timestamps   = false;
        public    $incrementing = false;
        protected $primaryKey   = null;

        public function program(): BelongsTo
        {
            return $this->belongsTo(Program::class, 'program_kod', 'program_kod');
        }

        public function faculty(): BelongsTo
        {
            return $this->belongsTo(Faculty::class, 'fakulte_kod', 'fakulte_kod');
        }

        public function department(): BelongsTo
        {
            return $this->belongsTo(Department::class, 'bolum_kod', 'bolum_kod');
        }

        public function type(): BelongsTo
        {
            return $this->belongsTo(Code::class, 'tur', 'kod')->where('tur', 'ogrenci_tur');
        }
        public function standing(): HasOne
        {
            return $this->hasOne(Code::class, 'kod', 'basari_durum')->where('tur', 'basari_durum');
        }

    }

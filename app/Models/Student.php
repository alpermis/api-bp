<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Casts\Attribute;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    use Illuminate\Database\Eloquent\Relations\HasMany;
    use Illuminate\Database\Eloquent\Relations\HasOne;

    class Student extends Model
    {
        use HasFactory;

        protected $table = 'ogrenci';

        protected $primaryKey = 'ogrenci_no';

        public $timestamps = false;

        protected $fillable = [];

        protected $appends = ['photo_hash'];

        protected $photoContentCache = false;

        public function detail(): HasOne
        {
            return $this->hasOne(StudentDetail::class, 'ogrenci_no', 'ogrenci_no');
        }

        public function programs(): HasMany
        {
            return $this->hasMany(StudentProgram::class, 'ogrenci_no', 'ogrenci_no');
        }

        public function advisor(): BelongsTo
        {
            return $this->belongsTo(Staff::class, 'danisman_sicil_no', 'sicil_no');
        }

        public function activeStatus(): HasOne
        {
            return $this->hasOne(Code::class, 'kod', 'aktif')->where('tur', 'ogrenci_aktif');
        }

        public function studentStatus(): HasOne
        {
            return $this->hasOne(Code::class, 'kod', 'durum')->where('tur', 'ogrenci_durum');
        }

        public function studentType(): HasOne
        {
            return $this->hasOne(Code::class, 'kod', 'tur')->where('tur', 'ogrenci_tur');
        }

        /*public function standing(): HasOne
        {
            return $this->hasOne(Code::class, 'kod', 'basari_durum')->where('tur', 'basari_durum');
        }*/

        public function address(): HasOne
        {
            return $this->hasOne(StudentAddress::class, 'ogrenci_no', 'ogrenci_no')->where('ikamet_adresi', 'E');
        }

        protected function photoContent(): Attribute
        {
            return Attribute::make(
                get: function () {
                    if ($this->photoContentCache !== false) {
                        return $this->photoContentCache;
                    }

                    $photoSalt           = 'p9o5r1t1L2e0n2g5Ec';
                    $studentPhotoUrl     = 'https://stars.bilkent.edu.tr/webserv/image.php?id=' . $this->ogrenci_no . '&cry=' . md5($photoSalt . $this->ogrenci_no);
                    $studentPhotoContent = @file_get_contents($studentPhotoUrl);

                    $this->photoContentCache = $studentPhotoContent ? base64_encode($studentPhotoContent) : null;

                    return $this->photoContentCache;
                }
            );
        }

        protected function photoHash(): Attribute
        {
            return Attribute::make(
                get: function () {
                    $content = $this->photo_content;

                    return $content ? md5($content) : null;
                }
            );
        }
    }

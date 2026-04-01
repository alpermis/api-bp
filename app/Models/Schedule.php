<?php


    namespace App\Models;

    use Exception;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Facades\DB;

    class Schedule extends Model
    {
        use HasFactory;

        /**
         * The primary key associated with the table.
         *
         * @var string
         */
        protected $primaryKey = 'ogrenci_no';

        /**
         * The table associated with the model.
         *
         * @var string
         */
        protected $table = 'alinan_ders';

        /**
         * Indicates if the model should be timestamped.
         *
         * @var bool
         */
        public $timestamps = false;

        public static function getDailyScheduleMetadata($semester, $scheduleDate)
        {

            $filter = "SELECT 
                            TO_CHAR(ders_baslama_tarih, 'dd.mm.YYYY') AS ders_baslama_tarih, 
                            TO_CHAR(ders_baslama_tarih, 'YYYYmmdd') AS ders_baslama_tarih_kontrol, 
                            TO_CHAR(ders_bitis_tarih, 'dd.mm.YYYY') ders_bitis_tarih, 
                            TO_CHAR(ders_bitis_tarih, 'YYYYmmdd') AS ders_bitis_tarih_kontrol 
                        FROM 
                             donem 
                        WHERE 
                              donem = ?
                        ";

            $data = DB::selectOne($filter, [$semester]);


            $data->tarih          = $scheduleDate;
            $data->tarih_kontrol  = implode('', array_reverse(explode('.', $scheduleDate)));
            $data->tarih_okunakli = date('d F Y, l', strtotime($data->tarih)); //16 September 2020, Wednesday

            $data->dayNumber = date('N', strtotime($data->tarih));
            $data->dayName   = date('l', strtotime($data->tarih));
            $data->isWeekend = in_array($data->dayNumber, ['6', '7']);


            $data->ders_baslama_tarih_okunakli = date('d F Y, l', strtotime($data->ders_baslama_tarih)); //16 September 2020, Wednesday

            //dd($data);

            if ($data->tarih_kontrol < $data->ders_baslama_tarih_kontrol) {//dersler henuz baslamadi
                $data->coursesNotStartedYet = true;

                $educationModes = self::getEducationModes();

                $data->coursesStartDateEducationMode      = self::getEducationModeByDate($data->ders_baslama_tarih);//dersler hangi modda baslayacak basladiginda.
                $data->coursesStartDateEducationModeLabel = $educationModes[$data->coursesStartDateEducationMode];


            } else if ($data->tarih_kontrol > $data->ders_bitis_tarih_kontrol) {//dersler bitti.
                $data->coursesEnded = true;

            } else if (($data->tarih_kontrol >= $data->ders_baslama_tarih_kontrol) && ($data->tarih_kontrol <= $data->ders_bitis_tarih_kontrol)) {//dersler devam ediyor.
                $data->coursesContinue = true;

                $educationModes = self::getEducationModes();

                $data->todaysEducationMode = self::getEducationModeByDate($data->tarih);//dersler bugun hangi egitim modunda

                $data->todaysEducationModeLabel = $educationModes[$data->todaysEducationMode];

            } else {
                throw new Exception('Courses start/end check error.');
            }


            return $data;


        }

        public static function getEducationModeByDate($date)
        {

            $filter = "SELECT tarih_egitim_mod_getir(?) egitim_mod FROM dual";
            $data   = DB::selectOne($filter, [$date]);

            return $data->egitim_mod;


        }

        public static function getOddEvenParticipationMode($date)
        {

            $filter = "SELECT tarih_tek_cift_getir(?) tek_cift_mod FROM dual";
            $data   = DB::selectOne($filter, [$date]);

            return $data->tek_cift_mod;

        }


        public static function getEducationModes()
        {

            $types = ['D' => 'Normal Mode', 'T' => 'No lecture/studio/lab sessions.'];

            return $types;


        }

        public static function getCourseModes()
        {

            $types = [
                'D' => 'Online/Hybrid Lecture',
                'Y' => 'Face-to-face Lecture',
                'R' => 'Recitation',

                'L' => 'Face-to-face Lab/Studio',
                'O' => 'Online Lab/Studio',
            ];

            return $types;


        }

        public static function getCourseModeCellColors()
        {

            $types = [
                'D' => '#0092c7',
                'Y' => '#77c93c',
                'R' => '#8787ff',

                'L' => '#eb9642',
                'O' => '#d4556a',
            ];

            return $types;

        }

        public static function getCourseSubstituteModes()
        {

            $types = [
                'H' => ['code' => '', 'label' => ''],
                'E' => ['code' => '(S)', 'label' => '(Spare Hour)'],
                'S' => ['code' => '(FS)', 'label' => '(Spare Hour)']//yukaridaki ile aynisi yapildi simdilik. sonra gerekirse degistiririz dedi seyit hoca.
            ];

            return $types;

        }

        public static function getHours()
        {
            $filter = "SELECT saat_no, aralik FROM ders_saat_yeni ORDER BY saat_no ASC";

            $rows = DB::select($filter);

            $data = [];

            foreach ($rows as $row) {
                $data[$row->saat_no] = $row->aralik;
            }

            return $data;

        }

        public static function getStudentOneDaySchedule($semesterCode, $studentId, $dayNumber)
        {

            //dd([$semesterCode, $studentId, $dayNumber]);

            $filter = "
                SELECT 
                       NVL(ac.egitim_mod, 'H') sube_egitim_mod,
                       ad.ders_kod,
                       ad.ders_no,
                       ad.sube_no,
                       dp.gun_no,
                       dp.saat_no,
                       dp.ders_tur,
                       dp.yedek,
                       dp.online_saat_no,
                       dp.derslik_no,
                       d.zoom_katilim_adres,
                       d.zoom_katilim_sifre
                  FROM alinan_ders ad, ders_program dp, derslik d, acilan_ders ac
                 WHERE ad.donem = ?
                   AND ad.ogrenci_no = ?
                   AND dp.donem = ad.donem
                   AND dp.ders_kod = ad.ders_kod
                   AND dp.ders_no = ad.ders_no
                   AND dp.sube_no = ad.sube_no
                   AND dp.gun_no = ?
                   AND d.derslik_no(+) = dp.derslik_no
                   AND ac.donem = ad.donem
                   AND ac.ders_kod = ad.ders_kod
                   AND ac.ders_no = ad.ders_no
                   AND ac.sube_no = ad.sube_no
                 ORDER BY dp.gun_no, dp.saat_no, dp.ders_kod, dp.ders_no, dp.sube_no
            ";

            //print_r($filter);
            $rows = DB::select($filter, array($semesterCode, $studentId, $dayNumber));

            return $rows;

        }

        public static function getStudentWeeklySchedule($semesterCode, $studentId)
        {

            //dd([$semesterCode, $studentId, $dayNumber]);

            $filter = "
                SELECT 
                       NVL(ac.egitim_mod, 'H') sube_egitim_mod,
                       ad.ders_kod,
                       ad.ders_no,
                       ad.sube_no,
                       dp.gun_no,
                       dp.saat_no,
                       dp.ders_tur,
                       dp.yedek,
                       dp.derslik_no,
                       d.zoom_katilim_adres,
                       d.zoom_katilim_sifre
                  FROM alinan_ders ad, ders_program dp, derslik d, acilan_ders ac
                 WHERE ad.donem = ?
                   AND ad.ogrenci_no = ?
                   AND dp.donem = ad.donem
                   AND dp.ders_kod = ad.ders_kod
                   AND dp.ders_no = ad.ders_no
                   AND dp.sube_no = ad.sube_no
                   AND d.derslik_no(+) = dp.derslik_no
                   AND ac.donem = ad.donem
                   AND ac.ders_kod = ad.ders_kod
                   AND ac.ders_no = ad.ders_no
                   AND ac.sube_no = ad.sube_no
                 ORDER BY dp.gun_no, dp.saat_no, dp.ders_kod, dp.ders_no, dp.sube_no
            ";

            //print_r($filter);
            $rows = DB::select($filter, array($semesterCode, $studentId));

            return $rows;

        }


        public static function getDays()
        {

            $filter = "SELECT gun_no, gun_ad_en FROM ders_gun ORDER BY gun_no ASC";

            //print_r($filter);
            $rows = DB::select($filter);

            $data = [];

            foreach ($rows as $row) {
                $data[$row->gun_no] = $row->gun_ad_en;
            }

            return $data;

        }


        public static function getScheduleDateDayNumber($date)
        {//$date format must be DD.MM.YYYY

            $filter = "SELECT tarih_ders_program_hafta_gun(?) tarih_gun_no FROM dual";
            $data   = DB::selectOne($filter, [$date]);

            return $data->tarih_gun_no;


        }

    }
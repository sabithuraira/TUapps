<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bulletin extends Model
{
    //
    // protected $with = ['user'];

    // protected $appends = ['name'];

    protected $table = 'bulletin';

    protected $fillable = [
        'judul',
        'user_id',
        'deksripsi',
        'start_date',
        'end_date',
        'created_by',
        'updated_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->select(['id', 'name', 'email']);
    }

    public function getNameAttribute()
    {

        return $this->user->name;
    }

    public function attributes()
    {
        return [
            'judul' => 'Judul Bulletin',
            'user_id' => 'User yang ditampilkan',
            'start_date' => 'Mulai',
            'end_date' => 'Selesai',
            'deskripsi' => 'Deskripsi',
            'hasil' => 'Yang dihasilkan',
            'created_by' => 'Dibuat oleh',
            'updated_by' => 'Terkahir diperbaharui oleh',
            'created_at' => 'Dibuat pada',
            'updated_at' => 'Terakhir diperbaharui pada',
        ];
    }
    public function getBadgeJudulAttribute()
    {
        return array(
            "Ucapan Selamat" => "<div class='badge badge-info'>Penghargaan</div>",
            "Pensiun" => "<div class='badge badge-primary'>Ucapan Selamat</div>",
            "Penghargaan" => "<div class='badge badge-warning'>Pensiun</div>",
            "Tulisan" => "<div class='badge badge-danger'>Tulisan</div>",
            "Lainnya" => "<div class='badge badge-secondary'>Lainnya</div>",
        );
    }

    public function getBulletinCardHeaderAttribute()
    {
        return array(
            "Ucapan Selamat"    => "<div class='header bg-info'>    <h5 class='m-t-10 text-light'>  Selamat Kepada                             </h5> </div>",
            "Pensiun"           => "<div class='header bg-primary'>  <h5 class='m-t-10 text-light'> Selamat Memasuki <br/> Masa Purna Bakti    </h5></div>",
            "Penghargaan"       => "<div class='header bg-warning'> <h5 class='m-t-10 text-light'>  Selamat Atas Penghargaan                   </h5></div>",
            "Tulisan"           => "<div class='header bg-danger'>  <h5 class='m-t-10 text-light'>  Tulisan Dari                               </h5></div>",
            "Lainnya"           => "<div class='header bg-secondary'><h5 class='m-t-10 text-light'> Ucapan Kepada                              </h5></div>",
        );
    }
    public function getListJudul()
    {
        return array(
            "Ucapan Selamat",
            "Pensiun",
            "Penghargaan",
            "Tulisan",
            "Lainnya",
        );
    }
}

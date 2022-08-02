<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pengadaan extends Model
{
    //
    protected $table = 'pengadaan';
    protected $guarded = [];


    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function badge_konf_ppk($st)
    {
        switch ($st) {
            case '':
                return "<div class='badge badge-info'>Menunggu <br/> Konfirmasi PPK</div>";
                break;
            case 'Sedang diproses':
                return "<div class='badge badge-warning'>Sedang <br/> diproses</div>";
                break;
            case 'Diterima':
                return "<div class='badge badge-success'>Diterima</div>";
                break;
            case 'Ditolak':
                return "<div class='badge badge-danger'>Ditolak</div>";
                break;
        }
    }

    public function badge_konf_pbj($st)
    {
        switch ($st) {
            case '':
                return "<div class='badge badge-info'>Menunggu <br/> Konfirmasi </div>";
                break;
            case 'Sedang diproses':
                return "<div class='badge badge-warning'>Sedang <br/> Diproses</div> ";
                break;
            case 'Selesai':
                return "<div class='badge badge-success'>Selesai</div>";
                break;
            case 'Ditolak':
                return "<div class='badge badge-danger'>Ditolak</div>";
                break;
        }
    }
}

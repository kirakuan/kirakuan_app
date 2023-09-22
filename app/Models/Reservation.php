<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;
    
    # テーブルの設定
    protected $table = 'reservations';
    protected $primaryKey = ['reservation_id', 'user_id'];
    public $incrementing = false; 
    protected $keyType = 'string';

    protected $fillable = [
        'reservation_id',
        "user_id",
        "start_date_time",
        "end_date_time",
        "is_booked",
        "is_deleted",
    ];
}

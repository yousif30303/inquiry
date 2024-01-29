<?php

namespace App\Models;

use App\Models\User;
use App\Models\Inquiry;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Remark extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'user_id',
        'inquiry_id'
    ];


    public function user(){
        return $this->belongsTo(User::class);
    }

    public function inquiry(){
        return $this->belongsTo(Inquiry::class);
    }
}

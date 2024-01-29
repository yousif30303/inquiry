<?php

namespace App\Models;

use App\Models\User;
use App\Models\Remark;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
        'category_id',
        'mobile',
        'date',
        'visit_time',
        'remarks',
        'entered_by',
        'status',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function Category()
    {
        return $this->belongsTo(Category::class);
    }

    public function remarks()
    {
        return $this->hasMany(Remark::class);
    }

}

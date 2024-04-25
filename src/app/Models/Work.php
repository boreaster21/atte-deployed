<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'start_at',
        'finished_at',
        'total_work',
        'start_rest',
        'finished_rest',
        'total_rest',
        'work_on',
    ];
    protected $casts = [
        'start_at' => 'datetime',
        'finished_at' => 'datetime',

        'start_rest' => 'datetime',
        'finished_rest' => 'datetime',
        'total_rest' => 'int',

        'work_on' => 'date',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}

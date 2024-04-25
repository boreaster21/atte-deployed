<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rest extends Model
{
    use HasFactory;
    protected $fillable = [
        // 'name',
        // 'email',
        // 'password',
    ];
    public function rest()
    {
        return $this->belongsTo(Work::class);
    }
}

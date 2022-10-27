<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Match;

class Odd extends Model
{
    use HasFactory;

    protected $fillable = ['name','bookmaker','val'];

    public function match()
    {
        return $this->belongsTo(Match::class);
    }
}

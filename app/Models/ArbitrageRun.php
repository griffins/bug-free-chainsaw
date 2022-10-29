<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ArbitrageMatch;

class ArbitrageRun extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','home','draw','away'];

    public function matches()
    {
        return $this->hasMany(ArbitrageMatch::class);
    }

    public function getFormulaAttribute()
    {
        $formula = [];
        if ($this->home) {
            $formula[]= 'Home';
        }
        if ($this->draw) {
            $formula[]= 'Draw';
        }
        if ($this->away) {
            $formula[]= 'Away';
        }
        return implode(', ', $formula);
    }

    public function getWinningsAttribute()
    {
        $winnings = 0;
        foreach ($this->matches as $match) {
            $winnings+= $match->winnings($this);
        }
        return $winnings;
    }
}

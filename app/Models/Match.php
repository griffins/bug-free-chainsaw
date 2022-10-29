<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Odd;

class Match extends Model
{
    use HasFactory;

    protected $fillable = ['competition','category','home_team','away_team','starts_at'];

    public $dates = ['starts_at'];

    public function odds()
    {
        return $this->hasMany(Odd::class);
    }

    public function getHomeTeamOddsAttribute()
    {
        return $this->odds->where('name', $this->home_team)->first()->val;
    }

    public function getAwayTeamOddsAttribute()
    {
        return $this->odds->where('name', $this->away_team)->first()->val;
    }

    public function getDrawOddsAttribute()
    {
        return $this->odds->where('name', 'Draw')->first()->val;
    }

    public function getResultAttribute()
    {
        if ($this->status === 'finished') {
            if ($this->away_team_score === $this->home_team_score) {
                return '[Draw]';
            } elseif ($this->away_team_score > $this->home_team_score) {
                return '[Away]';
            } else {
                return '[Home]';
            }
        } else {
            return '';
        }
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = ['competition','category','home_team','away_team','starts_at'];
    public $table = 'matches';
    public $dates = ['starts_at'];

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

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ArbitrageRun;
use App\Models\Game;

class ArbitrageMatch extends Model
{
    use HasFactory;

    protected $fillable = ['arbitrage_run_id','match_id'];

    public function run()
    {
        return $this->belongsTo(ArbitrageRun::class);
    }

    public function match()
    {
        return $this->belongsTo(Game::class);
    }

    public function winnings($run)
    {
        if ($this->match->status === 'finished') {
            $wins = 0;
            if ($run->away) {
                if ($this->match->away_team_score > $this->match->home_team_score) {
                    $wins += $this->match->away_team_odds * 100;
                }
                $wins -= 100;
            }
            if ($run->home) {
                if ($this->match->away_team_score < $this->match->home_team_score) {
                    $wins += $this->match->home_team_odds * 100;
                }
                $wins -= 100;
            }
            if ($run->draw) {
                if ($this->match->away_team_score === $this->match->home_team_score) {
                    $wins += $this->match->draw_odds * 100;
                }
                $wins -= 100;
            }
            return $wins;
        }
    }
}

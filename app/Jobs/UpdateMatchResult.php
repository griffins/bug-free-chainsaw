<?php

namespace App\Jobs;

use Http;
use Normalizer;
use Carbon\Carbon;
use App\Models\Match;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateMatchResult implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public $date;
    public $bookmaker;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($bookmaker, $date)
    {
        $this->date = $date;
        $this->bookmaker = $bookmaker;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $bookmakers = [
            "betika" => "https://ls.fn.sportradar.com/betika/en/Europe:Moscow/gismo/sport_matches/1/%s/0",
            "sportpesa" => "https://www.ke.sportpesa.com/api/results/search"
        ];
        $url = $bookmakers[$this->bookmaker];
        if ($this->bookmaker === 'sportpesa') {
            $details = Http::post($url, ['date' =>  $this->date->timestamp])->object();
            $details = collect($details)->where('sport_name', 'Football')->toArray();
            foreach ($details as $detail) {
                $home = $detail->team1;
                $away = $detail->team2;
                $time = Carbon::createFromTimeStampMs($detail->start_date);
                $scores = explode(":", explode(" ", $detail->result)[0]);
                if (count($scores) === 1) {
                    if (strpos($scores[0], '-') !== false) {
                        $scores = explode('-', $scores[0]);
                    } else {
                        if ($scores[0] === 'CAN') {
                            $this->updateScores($home, $away, $time, null, true);
                        } else {
                            // we don't know how to handle this. problably log it
                        }
                        continue;
                    }
                }
                $this->updateScores($home, $away, $time, $scores);
            }
        } elseif ($this->bookmaker==='betika') {
            $data = Http::get(sprintf($url, $this->date->format('Y-m-d')))->object();
            foreach ($data->doc[0]->data->sport->realcategories as $category) {
                foreach ($category->tournaments as $tournament) {
                    foreach ($tournament->matches as $match) {
                        if ($match->status->name === 'Ended') {
                            $scores =[$match->result->home,$match->result->away];
                            $home = $match->teams->home->name;
                            $away = $match->teams->away->name;
                            $time = Carbon::parse($match->_dt->uts);
                            $this->updateScores($home, $away, $time, $scores);
                        }
                    }
                }
            }
        }
    }

    public function updateScores($home, $away, $time, $scores, $postponed = false)
    {
        $matches = Match::query()
        ->where('home_team', $home)
        ->where('away_team', $away)
        ->where('starts_at', $time)
        ->get();
        foreach ($matches as $match) {
            if ($postponed) {
                $match->status = "cancelled";
            } else {
                $match->status = "finished";
                $match->away_team_score = $scores[1];
                $match->home_team_score = $scores[0];
            }
            $match->save();
        }
    }
}

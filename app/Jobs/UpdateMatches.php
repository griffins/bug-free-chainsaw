<?php

namespace App\Jobs;

use Http;
use App\Models\Match;
use App\Models\Odd;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class UpdateMatches implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public $bookmaker;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($bookmaker)
    {
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
            'sportpesa' => 'https://www.ke.sportpesa.com/api/todays/1/games?type=prematch&section=today&markets_layout=multiple&o=startTime&pag_count=500&pag_min=1',
            'betika' => 'https://api.betika.com/v1/uo/matches?page=1&limit=500&tab=&sub_type_id=1,186,340&sport_id=14&tag_id=&sort_id=1&period_id=-1&esports=false'
        ];
        $data =  Http::get($bookmakers[$this->bookmaker])->object();

        if ($this->bookmaker === 'sportpesa') {
            \DB::transaction(function () use ($data) {
                foreach ($data as $detail) {
                    $home_team =  $detail->competitors[0]->name;
                    $away_team =  $detail->competitors[1]->name;
                    $starts_at = Carbon::parse($detail->date);
                    $payload  = compact('home_team', 'away_team', 'starts_at');
                    $market =  collect($detail->markets)->where('name', '3 Way')->first();
                    $odds = $market->selections;
                    $this->upsertMatch('SportPesa', $payload, $detail->country->name, $detail->competition->name, $odds);
                }
            });
        } elseif ($this->bookmaker === 'betika') {
            $data = $data->data;
            \DB::transaction(function () use ($data) {
                foreach ($data as $detail) {
                    if ($detail->sport_name === 'Soccer') {
                        list('home_team' => $home_team, 'away_team' => $away_team, 'category' => $category, 'competition_name' => $competition) = (array) $detail;
                        $starts_at = Carbon::parse($detail->start_time)->tz('Africa/Nairobi');
                        $payload  = compact('home_team', 'away_team', 'starts_at');
                        $odds = [
                        (object) [
                            "name" => $home_team,
                            "odds" =>  $detail->home_odd
                        ],
                        (object) [
                            "name" => 'Draw',
                            "odds" =>  $detail->neutral_odd
                        ],
                        (object) [
                            "name" => $away_team,
                            "odds" =>  $detail->away_odd
                        ]
                    ];
                        $this->upsertMatch('Betika', $payload, $category, $competition, $odds);
                    }
                }
            });
        }
        return $data;
    }

    public function upsertMatch($bookmaker, $payload, $category, $competition, $odds)
    {
        $match = Match::query()->firstOrNew($payload);
        $match->competition = $competition;
        $match->category = $category;
        $match->save();
        foreach ($odds as $selection) {
            $odd = Odd::query()->firstOrNew(['name' => $selection->name, 'bookmaker' => $bookmaker, 'match_id' => $match->id]);
            $odd->val = $selection->odds;
            $match->odds()->save($odd);
        }
    }
}

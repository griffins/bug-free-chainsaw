<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class MigrateOddsDataToMatches extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('odds')->join('matches', 'match_id', 'matches.id')->orderBy('odds.created_at')->chunk(100, function ($odds) {
            foreach ($odds as $odd) {
                if ($odd->name === $odd->home_team) {
                    DB::table('matches')->where('id', $odd->match_id)->update(['odds_home' => $odd->val]);
                } elseif ($odd->name === $odd->away_team) {
                    DB::table('matches')->where('id', $odd->match_id)->update(['odds_away' => $odd->val]);
                } elseif ($odd->name === 'Draw') {
                    DB::table('matches')->where('id', $odd->match_id)->update(['odds_draw' => $odd->val]);
                }
                DB::table('odds')->where('id', $odd->id)->delete();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}

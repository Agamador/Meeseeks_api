<?php

namespace App\Http\Controllers;

use App\Models\Level;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    public function get_main_levels($user_id){
        Level::where('user_id', 1)->get();
    }

    public function get_community_levels(){
        $levels = Level::select('id', 'name');

    //     return json_encode(Level::join('scores', 'scores.level_id', '=', 'levels.id')->
    //     select('levels.name', 'scores.value', 'scores.user_id')->orderBy('scores.value', 'desc')
    //         ->where('user_id', '!=', 1)->take(3));
    }

    public function post_community_level(Request $request){
        $level = new Level();
        $level->user_id = $request->user_id;
        $level->file_name = $request->file_name;
        $level->name = $request->name;
        $level->lives = $request->lives;
        $level->digsideers = $request->digsideers;
        $level->digdowners = $request->digdowners;
        $level->stopperers = $request->stopperers;
        $level->umbrellaers = $request->umbrellaers;
        $level->stairers = $request->stairers;
        $level->climbers = $request->climbers;
        $level->scene = $request->scene;
        $level->save(); 
    }
    public function get_level($id){
        return false;
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Level;
use App\Models\Score;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    public function get_main_levels($user_id)
    {
        $levels = Level::select('id', 'name')->where('user_id', 1)->get();
        $superados = [];
        $last_level = 0;
        foreach($levels as $l){
            $current_level = Score::where('user_id', $user_id)->where('level_id', $l->id)->first();
            if ($current_level != null){
                $last_level = $l->id;
                $superados += [$l->id => ['name'=> $l->name]];
                $top = Score::join('users', 'users.id', 'scores.user_id')->select('scores.value','users.name')->where('level_id', $l->id)->orderBy('value', 'desc')->take(3)->get();
                for($i = 0; $i < $top->count(); $i++){
                    $superados[$l->id] += ['top_'.($i+1) => ['score'=> $top[$i]->value, 'name'=> $top[$i]->name]];
                }
            }
        }
        if (empty($superados)){
            //el nivel inicial del juego siempre va a ser el id numero 1 de la base de datos.
            $level = Level::select('id','name')->where('id', 1)->first();
            $superados = ['id'=> $level->id,'name'=>$level->name];
        }
        else{
            //20 o el id del último nivel del modo historia
            if($last_level < 20)
            $level = Level::select('id','name')->where('id',$last_level+1)->first();
            $superados += [$level->id => ['name'=> $level->name]];
        }
        return json_encode($superados);
    }

    public function get_community_levels()
    {
        $levels = Level::select('id', 'name')->where('user_id', '!=', 1)->get();
        if (!$levels->isEmpty()) {
            $result = [];
            foreach ($levels as $l) {
                $actual_level = [$l->id =>[ 'name' => $l->name]];

                $top = Score::join('users', 'users.id', 'scores.user_id')->select('scores.value', 'users.name')->where('level_id', $l->id)->orderBy('value', 'desc')->take(3)->get();
                for ($i = 0; $i < $top->count(); $i++) {
                    $actual_level[$l->id] += ['top_' . $i+1 => ['score' => $top[$i]->value, 'name' => $top[$i]->name]];
                }
                // array_push($result, $actual_level);
                $result += $actual_level;
            }
        }
        return json_encode($result);
    }

    public function post_community_level(Request $request)
    {
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

    public function get_level($level_id)
    {
        return false;
    }
}

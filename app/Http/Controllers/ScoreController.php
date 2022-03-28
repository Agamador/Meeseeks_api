<?php

namespace App\Http\Controllers;

use App\Models\Score;
use Illuminate\Http\Request;

class ScoreController extends Controller
{

    public function store_score(Request $request)
    {
        //calculo HighScore: (salvados - perdidos) * 100 + 10000/ tiempo(s)
        $new_hi = ($request->saves - $request->losses) * 100 + 10000 / $request->time;
        $percent =(integer)( ($request->saves / $request->lives) * 100);
        //comprobamos si ya existe un score para el nivel superado.
        $score = Score::where('user_id', $request->user_id)->where('level_id', $request->level_id)->first();
        if ($score != null) {
            if ($score->value <= $new_hi) {
                $score->value = $new_hi;
                $score->percent = $percent;
                $score->saves = $request->saves;
                $score->losses = $request->losses;
                $score->time = $request->time;
                $score->save();
            }

            
        } else {
            $new_score = new Score();
            $new_score->saves = $request->saves;
            $new_score->losses = $request->losses;
            $new_score->time = $request->time;
            $new_score->value = $new_hi;
            $new_score->percent = $percent;
            $new_score->user_id = $request->user_id;
            $new_score->level_id = $request->level_id;
            $new_score->save();
        }
        //si existe comprobamos si la nueva puntuación es mejor que la que ya existía,
        //sobreescribir o ignorar
    }
}

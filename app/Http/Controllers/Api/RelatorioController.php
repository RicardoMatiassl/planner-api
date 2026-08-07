<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Meta;
use App\Models\Tarefa;
use Illuminate\Support\Facades\Auth;

class RelatorioController extends Controller{
    public function metas(){
        $usuario = Auth::user();

        $total = Meta::where("usuario_id", $usuario->id)->count();

        $cumpridas = Meta::where("usuario_id", $usuario->id)->where("status", "CUMPRIDA")->count();

        $porcentagem = 0;
        if ($total > 0){
            $porcentagem = ($cumpridas / $total) * 100;
        }
        else $porcentagem = 0;

        return response()->json(['total'=> $total, 'cumpridas' => $cumpridas, 'porcentagem' => $porcentagem]);
    }

    public function tarefas(){
        $usuario = Auth::user();

        $total = Tarefa::where("usuario_id", $usuario->id)->count();

        $cumpridas = Tarefa::where("usuario_id", $usuario->id)->where("status", "CUMPRIDA")->count();

        $porcentagem = 0;
        if ($total > 0){
            $porcentagem = ($cumpridas / $total) * 100;
        }
        else $porcentagem = 0;

        return response()->json(['total'=> $total, 'cumpridas' => $cumpridas, 'porcentagem' => $porcentagem]);    
    }

    public function categorias_metas(){
        $usuario = Auth::user();

        $numero = Meta::where("usuario_id", $usuario->id)->where("status", "CUMPRIDA")->selectRaw("categoria_id, COUNT(*) as total")->groupBy("categoria_id")->with("categoria")->orderBy("total", "desc")->get();

        return response()->json([
            'categorias' => $numero
        ]);
    }

    public function categorias_tarefas(){
        $usuario = Auth::user();

        $numero = Tarefa::where("usuario_id", $usuario->id)->where("status", "CUMPRIDA")->selectRaw("categoria_id, COUNT(*) as total")->groupBy("categoria_id")->with("categoria")->orderBy("total", "desc")->get();

        return response()->json([
            'categorias' => $numero
        ]);
    }

    public function semana_produtiva(){
        $usuario = Auth::user();

        $semanas = Tarefa::where("usuario_id", $usuario->id)->where("status", "CUMPRIDA")->selectRaw("WEEK(data) as semana")
        ->selectRaw("COUNT(*) as total")->groupBy("semana")->orderBy("total", "desc")->get();

        return response()->json([
            "semanas" => $semanas
        ]);
    }

    public function mes_produtivo(){}

    public function turno_produtivo(){}
}
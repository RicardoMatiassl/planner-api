<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Meta;
use Illuminate\Support\Facades\Auth;

class RelatorioController extends Controller{
    public function metas(){
        $usuario = Auth::user();

        $total = Meta::where("usuario_id", $usuario->id)->count();

        $cumpridas = Meta::where("usuario_id", $usuario->id)->where("status", "concluida")->count();

        $porcentagem = 0;
        if ($total > 0){
            $porcentagem = ($cumpridas / $total) * 100;
        }
        else $porcentagem = 0;

        return response()->json(['total'=> $total, 'cumpridas' => $cumpridas, 'porcentagem' => $porcentagem]);
    }
}
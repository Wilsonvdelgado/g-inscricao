<?php

namespace App\Http\Controllers;

use App\Models\InscricaoHistorio;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    function saveHistory($inscritos_id, $tipo, $data, $titulo, $descricao)
    {
        $history =  InscricaoHistorio::create([
            'inscritos_id' => $inscritos_id,
            'tipo' => $tipo,
            'data' => $data,
            'titulo' => $titulo,
            'descricao' => $descricao

        ]);
        return $history ? true : false;
        // try {
        //     $history =  InscricaoHistorio::create([
        //         'inscritos_id' => $inscritos_id,
        //         'estado' => $tipo,
        //         'tipo' => $data,
        //         'titulo' => $titulo,
        //         'descricao' => $descricao

        //     ]);
        //     return $history ? true : false;
        // } catch (\Throwable $th) {
        //     return false;
        // }
    }
}

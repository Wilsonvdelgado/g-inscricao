<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Http\Controllers\Controller;
use App\Models\Subscribe;
use Illuminate\Http\Request;
use App\Models\Caixa;
use Carbon\Carbon;
use DateTime;

use Illuminate\Support\Facades\Date;
use Mockery\Matcher\Contains;
use PHPUnit\TextUI\XmlConfiguration\Constant;

class CaixaController extends Controller
{

    public function index()
    {
        return view('caixa.index');
    }

    public function list()
    {
        $listCaixa =  Caixa::all();

        $list = [];
        $currentValue = 0;
        foreach ($listCaixa as $caixa) {
            $formatDate =  Carbon::createFromFormat('Y-m-d', $caixa->data)->format('d-m-Y');
            $caixa["formatDate"] = $formatDate;
            $currentValue =  $caixa->tipo_movimento == Constants::ENTRADA  ? $currentValue  + $caixa->valor : $currentValue  - $caixa->valor;
            $caixa["currentValue"] = $currentValue;
            array_push(
                $list,
                $caixa
            );
        }
        return $list;
    }

    /***
     * Save payment inscritos
     */
    public function addPayment(Request $request)
    {
        $inscrito =  $request["id"];
        $countPayment = Caixa::where('inscritos_id', '=', $inscrito)->count();
        $prestacao =  $countPayment + 1;
        $descricao = $prestacao . "ª prestação";
        return view('subscribe.addpayment', compact('inscrito', 'descricao', 'prestacao'));
    }

    public function savePayment(Request $request)
    {
        $valor =  $request->valor;
        $descricao =  $request->descricao;
        $inscrito =  $request->inscrito;
        $prestacao = $request->prestacao;
        $date = $request->date;

        try {
            $countPayment = Caixa::where('inscritos_id', '=', $inscrito)->count();
            $prestacaoBD =  $countPayment + 1;

            if ($prestacaoBD != $prestacao) {
                return array("error" => "Ocorreu um erro. Feche o formulário e volte a inserir");
            }

            $caixa =  Caixa::create([
                'tipo_movimento' => Constants::ENTRADA,
                "titulo" => $descricao,
                'descricao' => $descricao,
                'valor' => $valor,
                'data' => $date,
                'user_id' => 1,
                'inscritos_id' => $inscrito,
                'numero_pagamento' => $prestacao
            ]);

            if ($caixa) {
                $status =  $this->saveHistory($inscrito, "PAGAMENTO", $date, $descricao,  $descricao);
                return $status;
            }
            return  false;
        } catch (\Throwable $th) {
            return array("error" => $th . "");
        }
    }

    /**
     * caixa
     */
    public function create(Request $request)
    {
        $types = [Constants::ENTRADA => 'Entrada', Constants::SAIDA => 'Saída'];

        $subscribesList = Subscribe::where("estado", '<>', 'ELIMINADO')->get();

        // $subscribesList = Subscribe::all();

        $list = [];

        foreach ($subscribesList as $subscribe) {
            $list[$subscribe->id] = $subscribe->nome;
        }

        return view('caixa.create', compact("types", "list"));
    }

    public function store(Request $request)
    {
        $title =  $request->title;
        $description =  $request->description;
        $date = $request->date;
        $type = $request->type;
        $valor =  $request->valor;
        $inscrito =  $request->inscrito;
        $devolucao_check =  $request->devolucao_check;
        // $prestacao = $request->prestacao;

        if ($devolucao_check && $inscrito == null) {
            return array("error" =>  "Informe o inscrito");
        }

        try {
            $caixa =  Caixa::create([
                'tipo_movimento' => $type,
                "titulo" => $title,
                'descricao' => $description,
                'valor' => $valor,
                'data' => $date,
                'user_id' => 1,
                'inscritos_id' => $inscrito,
            ]);

            if ($caixa && $inscrito) {
                $status =  $this->saveHistory($inscrito, "PAGAMENTO", $date, $title,  $description);
                return $status;
            }

            return $caixa ? true : false;
        } catch (\Throwable $th) {
            return array("error" => $th . "");
        }
    }
}

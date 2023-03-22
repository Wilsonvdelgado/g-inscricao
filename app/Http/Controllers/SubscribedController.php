<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Helper\OrderItem;
use App\Models\Subscribe;
use Carbon\Carbon;
use Illuminate\Http\Request;



class SubscribedController extends Controller
{

    /**
     * Estados
     * Em analise , não aceite , Aceite, 
     */

    public function getOrderList()
    {
        $list = [
            new OrderItem("data_insc_asc", "Data inscrição - Ascendente", "ASC"),
            new OrderItem("data_insc_desc", "Data inscrição - Descendente", "Desc"),
            new OrderItem("nome_asc", "Nome - Ascendente", "ASC"),
            new OrderItem("nome_desc", "Nome - Descendente", "Desc"),
        ];
        return $list;
    }

    public function index()
    {
        $list = $this->getOrderList();
        $orders = [];
        foreach ($list as $item)
            $orders[$item->key] = $item->title;

        return view('subscribe.index', compact('orders'));
    }

    private function getColumnName($column)
    {
        switch ($column) {
            case 'data_inscricao':
                return "data_inscricao";

            default:
                return "nome";
        }
    }

    public function list(Request $request)
    {
        $orderColumn = $request["orderColumn"];
        $orderType = $request["orderType"];


        $column = $this->getColumnName($orderColumn);
        $type = $orderType == "DESC" ? "DESC" : "ASC";

        $listSubscribe =  Subscribe::where("estado", '<>', 'ELIMINADO')->orderBy($column, $type)->get();

        $list = [];
        foreach ($listSubscribe as $subscribe) {
            $payments = $subscribe->payments()->get();
            $firstPayment =  $payments->get(0);
            $SecondPayment =  $payments->get(1);
            $subscribe["prestacao_1"] = $firstPayment ? $firstPayment->valor : 0;
            $subscribe["prestacao_2"] = $SecondPayment ? $SecondPayment->valor : 0;
            $subscribe["total_pago"] = $payments->sum('valor');
            array_push(
                $list,
                $subscribe
            );
        }
        return $list;
    }

    private function getDescriptionState($status)
    {
        switch ($status) {
            case 'EM_ANALISE':
                return "Em análise";

            default:
                return "";
        }
    }

    public function detail($id)
    {
        $data = Subscribe::find($id);

        // files
        $anexos =   explode(" ", $data->anexo);
        $length = count($anexos);
        $data->passaport = $length > 0 ? trim($anexos[0]) : null;
        $data->bi_cni = $length > 1 ? trim($anexos[1]) : null;
        $data->comprovativo_pagamento = $length > 2 ? trim($anexos[2]) : null;

        //paymens 
        $paymentsBD = $data->payments();
        $data->total_pago = $paymentsBD->sum('valor');

        $listPayments =  $paymentsBD->get();

        foreach ($listPayments as $payment) {
            $formatDate =  Carbon::createFromFormat('Y-m-d', $payment->data)->format('d-m-Y');
            $payment["formatDate"] = $formatDate;
        }
        $data->listPayments = $listPayments;
        $data->estado_description = $this->getDescriptionState($data->estado);
        return view("subscribe.detail", compact('data'));
    }

    public function changeStatus($id)
    {
        $estado = Subscribe::find($id)->estado;
        $inscrito = $id;

        $list = [
            "EM_ANALISE" => "Em análise",
            "VALIDADO" => "Validado",
            "NAO_ACEITE" => "Não aceite",
            "ELIMINADO" => "Eliminado"
        ];
        return view("subscribe.changestatus", compact('estado', 'list', 'inscrito'));
    }

    public function saveChangestatus(Request $request)
    {
        $id =  $request->inscrito;

        try {
            $data = Subscribe::find($id);

            if ($data == null) {
                return false;
            }

            if ($data->estado ==  $request->estado) {
                return true;
            }

            $data->update([
                "estado" => $request->estado,
            ]);

            $descricao = ($request->estado == "NAO_ACEITE" || $request->estado == "ELIMINADO") ?  $request->motivo : null;

            $this->saveHistory($id, "ALTERACAO_ESTADO", date("Y/m/d"), $request->estado, $descricao);
            return true;
        } catch (\Throwable $th) {
            return array("error" => $th . "");
        }
    }
}

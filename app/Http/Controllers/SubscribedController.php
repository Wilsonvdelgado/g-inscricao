<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Helper\OrderItem;
use App\Models\Pacote;
use App\Models\Subscribe;
use Carbon\Carbon;
use DateTimeImmutable;
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

    private function getPayment(Subscribe $subscribe)
    {
        $payments = $subscribe->payments()->where('tipo_movimento', "ENTRADA")->get();
        return $payments;
    }


    public function list(Request $request)
    {
        $orderColumn = $request["orderColumn"];
        $orderType = $request["orderType"];
        $pagamentoCompleto = $request["pagamento_completo"];

        $column = $this->getColumnName($orderColumn);
        $type = $orderType == "DESC" ? "DESC" : "ASC";

        $pacotes = Pacote::all();

        $listSubscribe =  Subscribe::where("estado", '<>', 'ELIMINADO');

        if ($pagamentoCompleto != null) {
            $listSubscribe =   $listSubscribe->where('pagamento_completo', true);
        }

        $listSubscribe = $listSubscribe->orderBy($column, $type)->get();

        $list = [];
        foreach ($listSubscribe as $subscribe) {

            $payments = $this->getPayment($subscribe);
            $firstPayment =  $payments->get(0);
            $SecondPayment =  $payments->get(1);
            $subscribe["prestacao_1"] = $firstPayment ? $firstPayment->valor : 0;
            $subscribe["prestacao_2"] = $SecondPayment ? $SecondPayment->valor : 0;

            $pacote = $pacotes->where('id', $subscribe->pacote_id)->first();
            $valorPagamento = $payments->sum('valor');

            $subscribe["total_pago"]  = $valorPagamento;
            $subscribe["completedPayment"] = $subscribe->pagamento_completo; // $valorPagamento >= $pacote->valor;
            $subscribe["pacotes"] = $pacote;
            $subscribe["notification"] = $valorPagamento > $pacote->valor ? "Valor pago superior ao pacote. Pacote:" . $pacote->valor : null;
            $date = new DateTimeImmutable($subscribe["data_inscricao"]);
            $subscribe["format_data_inscricao"]  = $date->format('d-m-Y H:i:s');

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
        $anexos =   explode(",", $data->anexo);
        $length = count($anexos);
        if ($length == 3) {
            $data->bi_cni = $length > 0 ? trim($anexos[0]) : null;
            $data->comprovativo_pagamento = $length > 1 ? trim($anexos[1]) : null;
            $data->passaport = $length > 2 ? trim($anexos[2]) : null;
        } else   if ($length == 2) {
            $data->bi_cni = $length > 0 ? trim($anexos[0]) : null;
            $data->comprovativo_pagamento = $length > 1 ? trim($anexos[1]) : null;
            $data->passaport = $length > 2 ? trim($anexos[2]) : null;
        } else {
            $data->comprovativo_pagamento =  trim($anexos[0]);
        }

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

    public function export(Request $request)
    {
        $pagamentoCompleto = $request["pagamento_completo"];

        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
        $worksheet = $reader->load('excel_models/Inscricao_JMJ_Lisboa_2023.xlsx');
        $list =  Subscribe::where("estado", '<>', 'ELIMINADO');

        if ($pagamentoCompleto != null) {
            $list =   $list->where('pagamento_completo', true);
        }
        $list = $list->orderBy("nome", "ASC")->get();

        $l = 2;
        foreach ($list as $item) {
            $payments = $this->getPayment($item);
            $firstPayment =  $payments->get(0);
            $SecondPayment =  $payments->get(1);


            $worksheet->getActiveSheet()->setCellValue('A' . $l, $l - 1);

            $date = new DateTimeImmutable($item["data_inscricao"]);

            $worksheet->getActiveSheet()->setCellValue('B' . $l, $date->format('d-m-Y H:i:s'));
            // $worksheet->getActiveSheet()->setCellValue('B' . $l, $item->email);
            $worksheet->getActiveSheet()->setCellValue('C' . $l, $item->nome);
            $worksheet->getActiveSheet()->setCellValue('D' . $l, $item->paroquia);
            $worksheet->getActiveSheet()->setCellValue('E' . $l, $item->ilha);
            $worksheet->getActiveSheet()->setCellValue('F' . $l, $item->telemovel);
            //prestacao1
            $worksheet->getActiveSheet()->setCellValue('G' . $l, $firstPayment ? $firstPayment->valor : 0);

            //prestacao2
            $worksheet->getActiveSheet()->setCellValue('H' . $l, $SecondPayment ? $SecondPayment->valor : 0);

            //total
            $totalPago = $payments->sum('valor');
            $worksheet->getActiveSheet()->setCellValue('I' . $l, $totalPago);
            //total
            $descricaoPagamentoCompleto = $item->pagamento_completo ? "Completo" : "Incompleto";
            $worksheet->getActiveSheet()->setCellValue('J' . $l, $descricaoPagamentoCompleto);
            $l++;
        }

        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header("Content-Disposition: attachment; filename=Inscritos_JMJ.xlsx");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private", false);

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($worksheet, 'Xlsx');
        ob_end_clean();
        $writer->save('php://output');
    }
}

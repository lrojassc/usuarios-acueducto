<?php

namespace App\Http\Controllers;

use App\Models\Config;
use Symfony\Component\HttpFoundation\Request;

class ConfigController extends Controller
{

    /**
     * Configuraciones generales del sitio
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function index()
    {
        $configs = Config::all();
        $value_invoice = isset($configs[0]->value_invoice) ? $configs[0]->value_invoice : 0;
        $month_selected = isset($configs[0]->month_invoiced) ? $configs[0]->month_invoiced : '';
        return view('config.index', ['value_invoice' => $value_invoice, 'month_selected' => $month_selected, 'months' => $this->monthsDetails]);
    }

    /**
     * Crear o actualizar la información de la configuración
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $config = new Config();
        $data_config = $config::all();
        if (count($data_config) === 0) {
            $config->value_invoice = $request->value_invoice;
            $config->month_invoiced = $request->monthInvoice;
            $config->save();
            $message = 'Se registró de forma exitosa la configuración';
        } else {
            $config_last = $data_config[0];
            $config_last->setAttribute('value_invoice', $request->value_invoice);
            $config_last->setAttribute('month_invoiced', $request->monthInvoice);
            $config_last->save();
            $message = 'Se actualizó de forma exita la información';
        }
        return redirect()->route('config.index')->with('success', $message);
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\Config;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * @var array|string[]
     */
    protected array $monthsDetails = [
        'ENERO' => 'ENERO', 'FEBRERO' => 'FEBRERO', 'MARZO' => 'MARZO', 'ABRIL' => 'ABRIL',
        'MAYO' => 'MAYO', 'JUNIO' => 'JUNIO', 'JULIO' => 'JULIO', 'AGOSTO' => 'AGOSTO', 'SEPTIEMBRE' => 'SEPTIEMBRE',
        'OCTUBRE' => 'OCTUBRE', 'NOVIEMBRE' => 'NOVIEMBRE', 'DICIEMBRE' => 'DICIEMBRE'
    ];

    /**
     * @var array|string[]
     */
    protected array $monthsNumber = [
        '01' => 'ENERO', '02' => 'FEBRERO', '03' => 'MARZO', '04' => 'ABRIL', '05' => 'MAYO', '06' => 'JUNIO',
        '07' => 'JULIO', '08' => 'AGOSTO', '09' => 'SEPTIEMBRE', '10' => 'OCTUBRE', '11' => 'NOVIEMBRE', '12' => 'DICIEMBRE'
    ];

    protected function getValueInvoiceConfig(Config $config)
    {
        $data_config = $config::all();
        return $data_config[0]->value_invoice;
    }

    protected function getValueMonthInvoiceConfig(Config $config)
    {
        $data_config = $config::all();
        return $data_config[0]->month_invoiced;
    }

}

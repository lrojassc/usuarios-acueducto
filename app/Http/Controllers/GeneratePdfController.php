<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Http\Request;

class GeneratePdfController extends Controller
{
    public function getPdf()
    {
        $nombre = 'liever rojas';
        $pdf = PDF::loadView('pdf.payment', compact('nombre'));
        $pdf->setPaper('A4');
        return $pdf->stream('prueba.pdf');
    }
}

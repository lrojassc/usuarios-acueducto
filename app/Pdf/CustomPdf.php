<?php

namespace App\Pdf;

use Barryvdh\DomPDF\Facade\Pdf as PDF;

class CustomPdf extends PDF
{

    function AddTwoElements($element1, $element2)
    {
        // Agrega el primer elemento
        $this->Cell(0, 10, $element1, 0, 1);

        // Agrega el segundo elemento
        $this->Cell(0, 10, $element2, 0, 1);
    }
}

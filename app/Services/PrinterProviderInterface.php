<?php

namespace App\Services;

use Mike42\Escpos\PrintConnectors\PrintConnector;

interface PrinterProviderInterface
{
    /**
     * @param string $printerId
     * @return PrintConnector
     */
    public function getConnector($printerId);
}
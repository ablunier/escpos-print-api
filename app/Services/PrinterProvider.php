<?php

namespace App\Services;


use App\Exceptions\PrinterException;
use Mike42\Escpos\PrintConnectors\CupsPrintConnector;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\PrintConnectors\PrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

class PrinterProvider implements PrinterProviderInterface
{
    /**
     * @var array
     */
    protected $config;

    /**
     * @var array
     */
    private $drivers = [
        'network' => [
            'connector' => NetworkPrintConnector::class,
            'param'     => 'ip'
        ],
        'cups'    => [
            'connector' => CupsPrintConnector::class,
            'param'     => 'name'
        ],
        'file'    => [
            'connector' => FilePrintConnector::class,
            'param'     => 'filename'
        ],
        'windows' => [
            'connector' => WindowsPrintConnector::class,
            'param'     => 'name'
        ],
    ];

    /**
     * PrinterProvider constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @param string $printerId
     * @return PrintConnector
     * @throws PrinterException
     */
    public function getConnector($printerId)
    {
        if (! array_key_exists($printerId, $this->config)) {
            throw new PrinterException(sprintf('Printer "%s" not found', $printerId));
        }

        $printerConfig = $this->config[$printerId];

        if (! array_key_exists($printerConfig['driver'], $this->drivers)) {
            throw new PrinterException(sprintf('Unexpected driver "%s', $printerConfig['driver']));
        }

        $connectorClass = $this->drivers[$printerConfig['driver']]['connector'];
        $param = $this->drivers[$printerConfig['driver']]['param'];

        $connector = new $connectorClass($param);

        return $connector;
    }
}
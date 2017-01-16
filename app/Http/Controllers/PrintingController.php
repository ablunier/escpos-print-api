<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Log;
use Exception;

class PrintingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        //
    }

    /**
     * @param Request $request
     * @return array
     */
    public function printStream(Request $request)
    {
        $success = true;

        $stream = $request->getContent();

        try {
            $connector = new NetworkPrintConnector(env('THERMAL_PRINTER_HOST'), 9100);

            $connector->write($stream);
            $connector->finalize();
            unset($connector);
        } catch (Exception $e) {
            $success = false;
            Log::error($e->getMessage(), ['exception' => $e]);
        }

        return [
            'success' => $success
        ];
    }
}

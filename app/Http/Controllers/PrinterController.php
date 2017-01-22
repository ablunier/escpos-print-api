<?php

namespace App\Http\Controllers;

use App\Services\PrinterProviderInterface;
use Illuminate\Http\Request;
use Log;
use Exception;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class PrinterController extends Controller
{
    /**
     * @var PrinterProviderInterface
     */
    private $printerProvider;

    public function __construct(PrinterProviderInterface $printerProvider)
    {
        $this->printerProvider = $printerProvider;
    }

    /**
     * @param Request $request
     * @param string $printerId
     * @return array
     * @throws BadRequestHttpException
     */
    public function printStream(Request $request, $printerId)
    {
        $success = true;
        $message = null;

        $stream = $this->getStream($request);

        try {
            $connector = $this->printerProvider->getConnector($printerId);

            $connector->write($stream);
            $connector->finalize();
            unset($connector);
        } catch (Exception $e) {
            $success = false;
            $message = $e->getMessage();
            Log::error($e->getMessage(), ['exception' => $e]);
        }

        return [
            'success' => $success,
            'message' => $message
        ];
    }

    /**
     * @param Request $request
     * @return string
     * @throws BadRequestHttpException
     */
    protected function getStream(Request $request)
    {
        $stream = $request->getContent();

        if (empty($stream)) {
            throw new BadRequestHttpException('No content provided');
        }

        return $stream;
    }
}

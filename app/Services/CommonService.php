<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;

class CommonService
{
    public function writeLog($message): void
    {
        Log::info($message);
    }

    public function writeErrorLog(Exception $e): string
    {
        if (env('APP_ENV') == "local") {
            $errorMessage = "Error : " . $e->getMessage();
            Log::info($errorMessage);
        } else {
            $errorMessage = "Error Code : " . $e->getCode();
            $errorMessageLog = "Error : " . $e->getMessage();
            Log::info($errorMessageLog);
        }

        return $errorMessage;
    }
}

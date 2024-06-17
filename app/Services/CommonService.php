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
        } else {
            $errorMessage = "Error Code : " . $e->getCode();
        }

        Log::info($errorMessage);
        return $errorMessage;
    }
}

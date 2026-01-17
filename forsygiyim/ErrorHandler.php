<?php
// ErrorHandler.php
class ErrorHandler {
    public static function logError($message, $context = []) {
        $logPath = __DIR__ . '/logs/errors.log';
        
        // Klasör yoksa oluştur
        if (!is_dir(__DIR__ . '/logs')) {
            mkdir(__DIR__ . '/logs', 0777, true);
        }

        $date = date('Y-m-d H:i:s');
        $contextString = !empty($context) ? json_encode($context) : '';
        $logMessage = "[$date] ERROR: $message $contextString" . PHP_EOL;
        
        error_log($logMessage, 3, $logPath);
    }
}
?>
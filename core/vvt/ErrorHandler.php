<?php
namespace vvt;

use Throwable;

final class ErrorHandler
{
    public function __construct()
    {
        if(DEBUG){
            error_reporting(E_ALL);
        } else{
            error_reporting(0);
        }
        set_exception_handler([$this, 'exceptionHandler']);
        set_error_handler([$this, 'errorHandler']);

        ob_start();
        register_shutdown_function([$this, 'fatalErrorHandler']);
    }
    public function exceptionHandler(Throwable $e)
    {
        $this->logErrors($e->getMessage(), $e->getFile(), $e->getLine());
        $this->displayError("Исключение", $e->getMessage(),$e->getFile(), $e->getLine(), $e->getCode());
    }
    public function fatalErrorHandler()
    {
        $error = error_get_last();
        if (!empty($error) && $error['type'] & (E_ERROR | E_PARSE | E_COMPILE_ERROR | E_CORE_ERROR)) {
            $this->logErrors($error['message'], $error['file'], $error['line']);
            ob_end_clean();
            $this->displayError($error['type'], $error['message'], $error['file'], $error['line']);
        } else {
            ob_end_flush();
        }
    }
    public function errorHandler(int $errno, string $errstr, string $errfile, int $errline): bool
    {
        // Если уровень ошибки не включён в error_reporting, отдаём обработку PHP
        if (!(error_reporting() & $errno)) {
            return false;
        }

        $this->logErrors($errstr, $errfile, $errline);

        // В режиме разработки не останавливаем скрипт на предупреждениях
        if (DEBUG && ($errno === E_WARNING || $errno === E_NOTICE || $errno === E_DEPRECATED)) {
            // Возвращаем false, чтобы PHP вывел стандартное сообщение (если display_errors=On)
            // или true, чтобы подавить вывод, но продолжить выполнение
            return false; 
        }
        // Критические ошибки или production → показываем страницу и останавливаем
        $this->displayError($errno, $errstr, $errfile, $errline);
        return true;
    }
    protected function logErrors(string $message, string $file, int $line): void
    {
        $data = "[". date("Y-m-d H:i:s") . "] Текст ошибки {$message} | Файл {$file} | Строка {$line}" 
            . "\n";
        file_put_contents(LOGS . "/errors.log", $data, FILE_APPEND );
    }
    protected function displayError($errno, $errstr, $errfile, $errline, $response = 500)
    {
        if($response == 0) $response = 404;
        http_response_code($response);

        if($response == 404 && (!DEBUG)){
            require_once WWW . "/errors/404.php";
            die;
        }
        if(DEBUG) {
            require_once WWW . "/errors/development.php";
        } else{
            require_once WWW . "/errors/production.php";
        }
        die;
    }
}
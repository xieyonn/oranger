<?php
/**
 * @brief 错误处理
 *
 * @author xieyong <xieyong@xiaomi.com>
 */

namespace App\Library\Core;

use Throwable;
use Yii;
use App\Library\DI\DI;

class ErrorHandler
{
    const ERROR_CODE = 999999;

    // php内置错误类型 -> string的映射
    const ERROR_TYPE = [
        E_ERROR => 'ERROR',
        E_WARNING => 'WARNING',
        E_PARSE => 'PARSE',
        E_NOTICE => 'NOTICE',
        E_CORE_ERROR => 'CORE_ERROR',
        E_CORE_WARNING => 'CORE_WARNING',
        E_COMPILE_ERROR => 'COMPILE_ERROR',
        E_COMPILE_WARNING => 'COMPILE_WARNING',
        E_USER_ERROR => 'USER_ERROR',
        E_USER_WARNING => 'USER_WARNING',
        E_USER_NOTICE => 'USER_NOTICE',
        E_STRICT => 'STRICT',
        E_RECOVERABLE_ERROR => 'RECOVERABLE_ERROR',
        E_DEPRECATED => 'DEPRECATED',
        E_USER_DEPRECATED => 'USER_DEPRECATED',
    ];

    protected $is_cli; // 是否命令行界面
    protected $is_prod = true; // 是否是线上环境
    protected $di;
    protected $defult_msg = 'Internal Server Error';

    public function __construct()
    {
        $this->is_cli = (PHP_SAPI === 'cli');
        $this->is_prod = (defined('ENV') && ENV === 'prod');
        $this->di = DI::getInstance();
    }
    
    /**
     * 捕捉异常
     *
     * @param \Exception $e
     * @return void
     */
    public function exceptionHanlder($exception)
    {
        try {
            if ($this->di->has('uncaught_error_log')) {
                $this->di->get('uncaught_error_log')->logException($exception);
            }
            
            $code = $exception->getCode();
            $msg = $exception->getMessage();
            if ($code === 0) {
                $code = self::ERROR_CODE;
            }
            // 线上web环境隐藏异常信息(不管是否开启DEBUG)
            // if ($this->is_prod && ! $this->is_cli) {
                // if ($exception instanceof \Exception) {
                    // if ($exception->getCode() < ExceptionBase::SYSTEM_EXCEPTION_CODE) {
                    //     $code = self::ERROR_CODE; // 异常系统错误码
                    //     $msg = $this->defult_msg;
                    // }
                // }
            // }
            
            // 打印调试信息
            if (defined('DEBUG') && DEBUG === true) {
                $msg .= $exception->getTraceAsString();
            }

            if (! $this->is_cli) {
                $statusCode = 500;
                if ($exception instanceof \yii\web\HttpException) {
                    $statusCode = $exception->statusCode;
                }
                $this->httpResponse($code, $msg, $statusCode);
            } else {
                if ($this->di->has('console_log')) {
                    $this->di->get('console_log')->logException($exception);
                }
            }
        } catch (\Exception $e) {
            $this->handleFallbackExceptionMessage($e, $exception);
        } catch (\Throwable $t) {
            $this->handleFallbackExceptionMessage($t, $exception);
        }
    }

    protected function httpResponse($code, $msg, $statusCode = 500)
    {
        $response = Yii::$app->response;
        $response->setStatusCode($statusCode);
        $response->format = \yii\web\Response::FORMAT_JSON;
        $response->data =  [
            'code' => $code,
            'message' => $msg,
            'data' => [],
        ];
        $response->send();
        exit();
    }

    /**
     * 错误处理
     *
     * @param [type] $e
     * @return void
     */
    public function errorHandler($code, $message, $file, $line)
    {
        try {
            if (error_reporting() & $code) {
                if ($this->di->has('error_log')) {
                    $this->di->get('error_log')->error([
                        'code' => $code,
                        'msg' => $message,
                        $file . ":" . $line,
                    ]);
                }
                
                $msg = "$message $file:$line";
                
                if ($this->is_prod && ! $this->is_cli) {
                    $this->httpResponse(self::ERROR_CODE, $this->defult_msg);
                }
    
                $error_type = self::ERROR_TYPE[$code];
                if ($this->is_cli) {
                    echo "[PHP {$error_type}][" . date('Y-m-d H:i:s') ."] " . $msg . "\n";
                } else {
                    $this->httpResponse($code, $msg);
                }
            }
        } catch (Throwable $e) {
            $this->handleFallbackExceptionMessage($t, $exception);
        }

        // 关闭php内置错误提醒
        return true;
    }

    protected function handleFallbackExceptionMessage($exception, $previousException)
    {
        $msg = "An Error occurred while handling another error:\n";
        $msg .= (string) $exception;
        $msg .= "\nPrevious exception:\n";
        $msg .= (string) $previousException;

        // 线上环境隐藏异常细节
        if ($this->is_prod && ! $this->is_cli) {
            $this->httpResponse(self::ERROR_CODE, 'An internal server error occurred.');
        }

        if ($this->is_cli) {
            echo $msg . "\n";
        } else {
            $this->httpResponse(self::ERROR_CODE, $msg);
        }

        if (defined('HHVM_VERSION')) {
            flush();
        }
        exit(1);
    }
}
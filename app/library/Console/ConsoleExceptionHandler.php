<?php

/**
 *@brief 全局异常捕获(ErrorController::errorAction无法捕获命令行执行中抛出的异常)
 *
 *@author xieyong <qxieyongp@163.com>
 *@date 2018-03-21
 */

namespace App\Library\Console;

use App\Library\DI\DI;

class ConsoleExceptionHandler
{
    /**
     * 处理命令行程序未捕获的异常
     * @param mixed $exception
     * @return \Closure
     */
    public static function getExceptionHandler()
    {
        return function ($exception) {
            $di = DI::getInstance();
            // 命令行输出异常
            $logger = $di->get('console_log');
            $logger->logException($exception);

            // 记录错误日志
            if (defined('ENV') && ENV !== 'dev') {
                $di->get('command_log')->logException($exception);
            }
        };
    }

    public static function getErrorHandler()
    {
        return function ($errno, $errstr, $errfile, $errline) {
            $di = DI::getInstance();
            $error = [
                'code' => $errno,
                'msg' => $errstr,
                'file' => $errfile . ":" . $errline,
            ];
            // 命令行输出错误
            $logger = $di->get('console_log');
            $logger->error($error);

            // 记录错误日志
            if (defined('ENV') && ENV !== 'dev') {
                $di->get('command_log')->error($error);
            }
        };
    }
}

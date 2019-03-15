<?php

/**
 * 日志记录类
 *
 * @author: xieyong <qxieyongp@163.com>
 * @Date: 2017/8/19
 * @Time: 14:11
 */

namespace Oranger\Library\Logger;

use Throwable;
use Exception;

class Logger
{
    // 异常等级
    const DEBUG = 1;
    const INFO = 2;
    const NOTICE = 3;
    const WARNING = 4;
    const ERROR = 5;
    const EXCEPTION = 6;
    const CRITICAL = 7;
    const ALERT = 8;
    const EMERGENCY = 9;

    /**
     * @var array 异常等级
     */
    protected $level = [
        self::DEBUG => 'debug',
        self::INFO => 'info',
        self::NOTICE => 'notice',
        self::WARNING => 'warning',
        self::ERROR => 'error',
        self::EXCEPTION => 'exception',
        self::CRITICAL => 'critical',
        self::ALERT => 'alert',
        self::EMERGENCY => 'emergency',
    ];

    /**
     * @var array 设置
     */
    protected $option = [
        'max_buffer_size' => 200,          // 缓冲区最大值
        'log_threshold' => self::DEBUG,  // 阈值
        'delay_write' => true,         // 是否延迟写入
        'seperator' => ' ',
        'appid' => '',
        'log_trace' => true, // 异常日志是否记录trace信息
    ];

    /**
     * @var string 日志名
     */
    protected $log_name = '';

    /**
     * @var array 缓存
     */
    protected $buffer = [];

    /**
     * @var int 缓存行数
     */
    protected $buffer_length = 0;

    /**
     * @var LogWriter 写日志类
     */
    protected $writer = [];

    /**
     * Logger constructor.
     *
     * @param string    $log_name 日志名
     * @param LogWriter $writer   执行写操作的对象
     * @param array     $option   设置
     */
    public function __construct($log_name, $writer, $option = [])
    {
        $this->log_name = $log_name;
        $this->writer = $writer;

        if (!empty($option)) {
            $this->option = array_merge($this->option, $option);
        }
    }

    /**
     * 记录日志
     * @author: xieyong <xieyong@xiaomi.com>
     *
     * @param int   $level 异常等级
     * @param array $msg   错误消息 [msg1, msg2, ..., msgn] 按顺序组合
     */
    protected function log($level, $msg)
    {
        // 过滤不超过阈值的异常
        if ($level < $this->option['log_threshold']) {
            return;
        }

        $log_line = $this->formatLine($level, $msg);

        // 延迟写入时，日记先保存到buffer中，程序结束时执行写操作
        if ($this->option['delay_write']) {
            array_push($this->buffer, $log_line);
            $this->buffer_length++;

            // 缓存达到域值立即写入
            if ($this->buffer_length == $this->option['max_buffer_size']) {
                $this->write($this->buffer);
                $this->clearCache();
            }
        } else {
            $this->write([$log_line]);
        }
    }

    /**
     * 格式化一行日志
     * @author: xieyong <xieyong@xiaomi.com>
     *
     * @param int   $level 异常等级
     * @param array $msg   异常信息 [msg1, msg2, ..., msgn] 按顺序组合
     *
     * @return string
     */
    protected function formatLine($level, $msg)
    {
        $datatime = $this->encloseSquareBrackets(date('Y-m-d H:i:s', time()));
        $appid = !empty($this->option['appid']) ? $this->encloseSquareBrackets($this->option['appid']) : '';
        $log_data = [];

        if (! empty($appid)) {
            $log_data[] = $appid;
        }
        $log_data = [
            $datatime,
            $this->encloseSquareBrackets($this->level[$level]),
            $this->convertToString($msg)
        ];

        return implode($this->option['seperator'], $log_data);
    }

    /**
     * 给字符串加上方括号
     *
     * @param string $var
     * @return string
     */
    protected function encloseSquareBrackets($var)
    {
        return '[' . $var . ']';
    }

    /**
     * 将任意变量转为字符
     *
     * @param  mixed  $var
     * @return string
     */
    public function convertToString($var)
    {
        $result = '';
        switch (gettype($var)) {
            case "boolean":
            case "integer":
            case "double":
            case "string":
                $result = (string)$var;
                break;
            case "array":
                foreach ($var as $key => $val) {
                    $key = is_numeric($key) ? '' : $key . ": ";
                    $result .= $key . $this->convertToString($val) . $this->option['seperator'];
                }
                break;
            case "object":
                $result = print_r($var, true);
                break;
            case "resource":
                try {
                    $result = get_resource_type($var);
                } catch (Throwable $e) {
                    $result = 'unknown resource';
                }
                break;
            case "NULL":
                $result = "null";
                break;
            case "unknown type":
                $result = "unknown type";
                break;
            default:
                $result = 'failed get var type';
        }
        return $result;
    }

    /**
     * 保存日志
     * @author: xieyong <xieyong@xiaomi.com>
     *
     * @param array $content 写入内容
     */
    protected function write($content = [])
    {
        if (!empty($content)) {
            foreach ($this->writer as $entry) {
                $entry->write($this->log_name, implode(PHP_EOL, $content) . PHP_EOL);
            }
        }
    }

    /**
     * 清楚缓存
     * @author: xieyong <xieyong@xiaomi.com>
     */
    private function clearCache()
    {
        $this->buffer = [];
        $this->buffer_length = 0;
    }

    /**
     * 对象解构时写日志
     */
    public function __destruct()
    {
        $this->write($this->buffer);
    }

    /**
     * Debug
     * @author: xieyong <xieyong@xiaomi.com>
     *
     * @param $msg
     */
    public function debug(...$msg)
    {
        $this->log(self::DEBUG, $msg);
    }

    /**
     * Info
     * @author: xieyong <xieyong@xiaomi.com>
     *
     * @param $msg
     */
    public function info(...$msg)
    {
        $this->log(self::INFO, $msg);
    }

    /**
     * Notice
     * @author: xieyong <xieyong@xiaomi.com>
     *
     * @param $msg
     */
    public function notice(...$msg)
    {
        $this->log(self::NOTICE, $msg);
    }

    /**
     * Warning
     * @author: xieyong <xieyong@xiaomi.com>
     *
     * @param $msg
     */
    public function warning(...$msg)
    {
        $this->log(self::WARNING, $msg);
    }

    /**
     * Error
     * @author: xieyong <xieyong@xiaomi.com>
     *
     * @param $msg
     */
    public function error(...$msg)
    {
        $this->log(self::ERROR, $msg);
    }

    /**
     * Critical
     * @author: xieyong <xieyong@xiaomi.com>
     *
     * @param $msg
     */
    public function critical(...$msg)
    {
        $this->log(self::CRITICAL, $msg);
    }

    /**
     * Alert
     * @author: xieyong <xieyong@xiaomi.com>
     *
     * @param $msg
     */
    public function alert(...$msg)
    {
        $this->log(self::ALERT, $msg);
    }

    public function var(...$msg)
    {
        $data = [];
        foreach ($msg as $entry) {
            $data[] = var_export($entry, true);
        }
        $this->debug($data);
    }

    /**
     * 记录异常信息
     * @author: xieyong <xieyong@xiaomi.com>
     *
     * @param \Throwable $e
     */
    public function logException(Throwable $e)
    {
        $msg = [
            'code' => $e->getCode(),
            'msg' => $e->getMessage(),
            'file' => $e->getFile() . ":" . $e->getLine(),
        ];

        if ($this->option['log_trace'] === true && defined('DEBUG') && DEBUG === true) {
            $msg[] = "\n";
            $msg['trace'] = "\n" . $e->getTraceAsString();
        }

        $previous = $e->getPrevious();
        while ($previous !== null) {
            $msg[] = "\n";
            $msg['previous'][] = [
                "\n",
                'code' => $previous->getCode(),
                'msg' => $previous->getMessage(),
                $previous->getFile() . ":" . $previous->getLine(),
            ];

            $previous = $previous->getPrevious();
        }

        if ($e instanceof \Exception) {
            $this->log(self::EXCEPTION, $msg);
        } else {
            $this->log(self::ERROR, $msg);
        }
    }
}

<?php

/**
 *@brief 命令行入口
 *
 *@author xieyong <qxieyongp@163.com>
 *@date 2018-03-21
 */

namespace App\Library\Console;

use App\Library\DI\DI;
use App\Library\Console\CommandBase;
use App\Library\Exception\CliException;

class CommandEntry
{
    private $call_class = '';

    private $call_function = '';

    private $parmas = [];

    private $di;

    /**
     * 命令行执行入口函数
     */
    public function run()
    {
        set_exception_handler(ConsoleExceptionHandler::getExceptionHandler());
        set_error_handler(ConsoleExceptionHandler::getErrorHandler());

        return function () {
            $this->processParams($_SERVER['argv'], $_SERVER['argc']);

            if (empty($this->call_class)) {
                $this->showAvailableCommands();
                return;
            }

            $class_name = '\App\Command\\' . $this->call_class . 'Command';
            $obj = new $class_name();
            $reflection = new \ReflectionClass($obj);

            if (!$reflection->isSubclassOf('\App\Library\Console\CommandBase')) {
                throw new CliException('COMMAND_CLASS_SHOULD_INHERIT_COMMAND_BASE');
            }

            if (empty($this->call_function) || !$reflection->hasMethod($this->call_function . 'Action')) {
                $method_reflection = $reflection->getMethods();
                $method_list = [];
                foreach ($method_reflection as $method) {
                    $method_list[] = $method->name;
                }
                $this->showAvailableActions($method_list);
                return;
            }

            try {
                $method = $reflection->getMethod($this->call_function . 'Action');

                $pass = [];
                foreach ($method->getParameters() as $param) {
                    if (isset($this->parmas[$param->getName()])) {
                        $pass[] = $this->parmas[$param->getName()];
                    } else {
                        $pass[] = $param->getDefaultValue();
                    }
                }

                $obj->_invoke_args = $this->parmas;
                return $method->invokeArgs($obj, $pass);
            } catch (\Throwable $e) {
                DI::getInstance()->get('console_log')->logException($e);
            }
        };
    }

    /**
     * 处理参数
     *
     * @param  array $argc
     * @param  array $argv
     * @return void
     */
    protected function processParams($argv, $argc)
    {
        $this->call_class = $argv[1] ?? '';
        $this->call_function = $argv[2] ?? '';

        // 有参数
        if ($argc > 3) {
            for ($i = 3; $i < $argc; $i++) {
                $name = $argv[$i];
                if (preg_match('#^--(\w[\w\d]*)#', $name, $matches)) {
                    $i++;
                    $value = $argv[$i] ?? '';
                    $this->parmas[$matches[1]] = $value;
                }
            }
        }
    }

    /**
     * 获取所有可用的命令
     *
     * @return void
     */
    protected function showAvailableCommands()
    {
        $dir = COMMAND_PATH;
        $list = [];
        $file_list = scandir($dir);
        foreach ($file_list as $command_file) {
            if (preg_match('#(^\w(\d|\w)*)Command\.php$#', $command_file, $matches)) {
                $list[] = $matches[1];
            }
        }

        echo "Alvailable Commands\n";
        echo "============================================\n";
        echo implode("\n", $list) . "\n";
        echo "============================================\n";
    }

    /**
     * 显示所有可用的方法
     *
     * @param  array $methods
     * @return void
     */
    protected function showAvailableActions($methods)
    {
        if (empty($methods)) {
            echo "No Actions Defined Yet\n";
        } else {
            $list = [];
            foreach ($methods as $action) {
                if (preg_match('#(^\w[\d\w]+)Action$#', $action, $matches)) {
                    $list[] = $matches[1];
                }
            }

            echo "Alvailable Actions\n";
            echo "============================================\n";
            echo implode("\n", $list) . "\n";
            echo "============================================\n";
        }
    }
}

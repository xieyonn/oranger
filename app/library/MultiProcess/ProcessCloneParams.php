<?php

/**
 * @brief 限制进程数上限，并给出每个任务需要的参数，父进程生成子进程来完成所有任务
 *
 * @author xieyong <xieyong@xiaomi.com>
 */

namespace Oranger\Library\MultiProcess;

class ProcessCloneParams
{
    protected $callable; // 任务

    protected $max_process_num; // 进程数上限

    protected $params; // 任务参数

    protected $current_process_num = 0; // 当前进程总数

    protected $task_called_num = 0; // 已执行的任务数目

    protected $finish_num = 0; // 已完成的任务数目

    protected $task_num; // 任务总数

    public function __construct($max_process_num, $callable, $params)
    {
        if (! is_numeric($max_process_num) || $max_process_num <= 0) {
            throw new ProcessException('INVALIED_PROCESS_NUM', ['num' => $max_process_num]);
        }
        $this->max_process_num = $max_process_num;

        if (! is_callable($callable)) {
            throw new ProcessException('INVALIED_CALLABLE', ['c' => $callable]);
        }
        $this->callable = $callable;

        if (! is_array($params)) {
            throw new ProcessException('PARAMS_NEED_INDEXED_ARRAY', ['p' => $params]);
        }

        $this->task_num = count($params);
        if ($this->task_num === 0) {
            throw new ProcessException('PARAMS_EMPTY');
        }

        $this->params = array_values($params);
    }

    public function run($call_back = null)
    {
        $this->log("当前进程:", posix_getpid(), "任务总数:", $this->task_num, "最大进程数", $this->max_process_num);

        while (true) {
            if ($this->finish_num === $this->task_num) {
                $this->log('所有任务运行完毕');

                if ($call_back !== null) {
                    if (! is_callable($call_back)) {
                        throw new ProcessException('INVALIED_CALLABLE', ['c' => $call_back]);
                    }
                    call_user_func($call_back);
                }
                exit(0);
            }

            if ($this->current_process_num === $this->max_process_num
                || $this->task_called_num === $this->task_num
                || $this->max_process_num <= 0
            ) {
                // 1.当前进程数已经达到上限
                // 2.所有任务都已触发
                // 3.由于fork失败自动减少上限
                // 父进程阻塞，等待子进程退出

                $heart = 1;
                while (true) {
                    // WNOHANG 非阻塞调用让父进程保持心跳
                    $rtv = pcntl_wait($status, WNOHANG);

                    if ($rtv == 0) {
                        usleep(100000);
                        $heart++;
                        if ($heart === 50) {
                            // 每5s输出一次心跳
                            $this->log("当前子进程总数", $this->current_process_num, '等待子进程退出...');
                            $heart = 1;
                        }
                        continue;
                    }

                    if ($rtv == -1) {
                        $this->log('等待子进程退出异常');
                    }

                    if ($rtv > 0) {
                        $this->log("进程", $rtv, "退出");
                    }

                    // 释放一个子进程名额
                    $this->current_process_num--;
                    $this->finish_num++;
                    break;
                }
            } else {
                $pid = pcntl_fork();
                $this->current_process_num++;

                $param = array_shift($this->params);
                $this->task_called_num++;

                if ($pid == -1) {
                    $this->log('fork 失败');
                    $this->max_process_num--; // 失败则减少进程上限防止卡在这里

                    // 把参数塞回去
                    $this->task_called_num--;
                    array_unshift($this->params, $param);
                }

                if ($pid == 0) {
                    // 子进程
                    $rand = rand(1, 5);
                    usleep($rand * 100000); // 随机等待，避免同时刻运行

                    $this->log('子进程', posix_getpid(), '开始运行');
                    try {
                        call_user_func_array($this->callable, $param);
                        exit(0);
                    } catch (\Exception $e) {
                        throw new ProcessException('EXCEPTION_CATCH', [], $e);
                        exit(1);
                    }
                }
            }
        }
    }

    protected function log(...$msg)
    {
        echo "[" . date('Y-m-d H:i:s') . "] " . implode(" ", $msg) . "\n";
    }
}

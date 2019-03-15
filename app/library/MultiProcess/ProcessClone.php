<?php
/**
 * @brief 多进程处理同一个任务
 * 
 * 规定创建的进程数，父进程创建多个子进程同时运行一个任务
 *
 * @author xieyong <xieyong@xiaomi.com>
 * @date 2018-07-23
 */

namespace Oranger\Library\MultiProcess;

class ProcessClone
{
    protected $callable; // 任务
    protected $max_process_num; // 进程数上限
    protected $params; // 任务参数(多个任务使用相同任务参数)
    protected $current_process_num = 0; // 当前进程总数
    protected $finish = 0; // 已完成进程总数

    public function __construct($max_process_num, $callable, $params = [])
    {
        if (! is_numeric($max_process_num) || $max_process_num <= 0) {
            throw new ProcessException('INVALIED_PROCESS_NUM', ['num' => $max_process_num]);
        }
        $this->max_process_num = $max_process_num;

        if (! is_callable($callable)) {
            throw new ProcessException('INVALIED_CALLABLE', ['c' => $callable]);
        }
        $this->callable = $callable;
        
        $this->params = $params;
    }

    public function run($call_back = null)
    {
        $this->log("当前进程", posix_getpid(), "将要fork", $this->max_process_num, "个子进程");

        if ($this->max_process_num === 1) {
            call_user_func_array($this->callable, $this->params);
            exit(0);
        }

        for($i = 0; $i < $this->max_process_num; $i++) {
            $pid = pcntl_fork();

            if ($pid == -1) {
                $this->log('fork 失败');
            }

            if ($pid == 0) {
                // 子进程
                // 随机等待，避免同时刻运行
                $rand = rand(1, 5);
                usleep($rand * 200000);
                try {
                    call_user_func_array($this->callable, $this->params);
                    exit(0); // 子进程执行完后退出
                } catch(\Exception $e) {
                    throw new ProcessException('EXCEPTION_CATCH', [], $e);
                    exit(1);
                }
            }
            
            if ($pid > 0) {
                // 父进程
                if (++$this->current_process_num < $this->max_process_num) {
                    // 继续fork
                    continue;
                }

                // 等待子进程退出
                while(1) {
                    $rtv = pcntl_wait($status, WUNTRACED);
                    $this->finish++;
                    
                    if ($rtv == -1) {
                        $this->log('等待子进程退出异常');
                    }

                    if ($rtv > 0) {
                        $this->log("进程", $rtv, "退出");
                    }

                    if ($this->finish == $this->max_process_num) {
                        $this->log("所有进程执行完毕");

                        if ($call_back !== null) {
                            if (!is_callable($call_back)) {
                                throw new ProcessException('INVALIED_CALLABLE', ['c' => $call_back]);
                            }
                            call_user_func($call_back);
                        }
                        exit(0);
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

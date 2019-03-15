<?php
/**
 * @brief 多进程处理同一个任务
 *
 * @author xieyong <xieyong@xiaomi.com>
 * @date 2018-07-23
 */

namespace Oranger\Library\Process;

class MultiProcess
{
    protected $callable;
    protected $process_num;
    protected $params;
    protected $current_num = 0;
    protected $finish = 0;

    public function __construct($process_num, $callable, $params = [])
    {
        $this->callable = $callable;
        $this->process_num = $process_num;
        $this->params = $params;
    }

    public function run()
    {
        $this->log("当前进程", posix_getpid());

        if ($this->process_num === 1) {
            call_user_func_array($this->callable, $this->params);
            exit(0);
        }

        for($i = 0; $i < $this->process_num; $i++) {
            $pid = pcntl_fork();

            if ($pid == -1) {
                $this->log('fork 失败');
                $this->process_num--; // 失败则减少进程数防止卡在这里
            }
            $this->process_num--;

            if ($pid == 0) {
                // 等待，避免同时刻运行
                usleep($i * 200000);
                call_user_func_array($this->callable, $this->params);
                exit(0); // 子进程执行完后退出
            }

            if ($pid > 0) {
                // 父进程
                if (++$this->current_num < $this->process_num) {
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

                    if ($this->finish == $this->process_num) {
                        $this->log("所有进程执行完毕");
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

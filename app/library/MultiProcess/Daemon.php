<?php

/**
 * 多进程处理模型
 */

namespace App\Library\MultiProcess;

class Daemon
{
    public function __construct()
    {
        
    }

    public function run()
    {
        echo 'father process pid: ' . posix_getpid() . "\n";
        $pid = pcntl_fork();

        if ($pid == -1) {
            die('fork faild');
        }

        if ($pid == 0) {
            echo "child process " . posix_getpid() . " running ...\n";
            while(1) {
                echo "child process sleep\n";
                sleep(1);
                echo "child process finish sleep\n";
            }
        }

        if ($pid > 0) {
            echo "father process running ...\n";
            while(1) {
                $rtv = pcntl_wait($status, WUNTRACED);
                if ($rtv == -1) {
                    echo "error\n";
                }
                if ($rtv == 0) {
                    echo "no child exist\n";
                }

                if ($rtv > 0) {
                    echo $rtv . " exit\n";
                    break;
                }

                usleep(100000);
            }
            echo "status: " . $status . "\n";
            var_dump(pcntl_wifexited($status));
        }
    }
}

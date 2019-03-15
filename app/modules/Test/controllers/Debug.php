<?php

use Oranger\Core\BaseController;

class DebugController extends BaseController
{

    public function IndexAction()
    {
        echo 'debug';

        //通过ini_set('output_buffering', 0)并不生效
        //应该编辑/etc/php.ini，设置output_buffering=0禁用output buffering机制
        //ini_set('output_buffering', 0); //彻底禁用output buffering功能
        for ($i = 0; $i < 10; $i++) {
            echo $i . '<br/>';
            ob_end_clean(); //通知操作系统底层，尽快把数据给客户端浏览器
            usleep(500000); // 0.5s
        }
    }
}
<?php
/**
 * @brief 开发控制器
 *
 * @author xieyong <qxieyongp@163.com>
 * @date 2018-10-10
 */

namespace App\Command;

use App\Library\Console\CommandBase;
use App\Library\DI\DI;

class DevCommand extends CommandBase
{
    public function indexAction()
    {
        DI::getInstance()->console_log->info('aa');
    }
}

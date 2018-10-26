<?php
/**
 * @brief 开发控制器
 *
 * @author xieyong <qxieyongp@163.com>
 * @date 2018-10-10
 */

namespace App\Command;

use App\Library\Console\CommandBase;

class DevCommand extends CommandBase
{
    public function indexAction()
    {
        echo 'hello';
    }
}

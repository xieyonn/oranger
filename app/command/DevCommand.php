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
use App\Library\Iterator\DateTimeIterator;

class DevCommand extends CommandBase
{
    public function indexAction()
    {
        $i = new DateTimeIterator(strtotime('2018-01-01'), strtotime('2018-01-10'));
        foreach ($i as $key => $value) {
            var_dump($value);
        }
    }
}

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
use App\Library\MultiProcess\ProcessClone;

class DevCommand extends CommandBase
{
    public $a;

    public function __construct()
    {}
    
    /**
     * undocumented function
     *
     * @return void
     * @author yourname
     */

    public function indexAction()
    {
        // DI::getInstance()->redis
        $call = function () {
            echo '123...';
        };
        
        $p = new ProcessClone(3, $call, []);
        $p->run();
    }
}

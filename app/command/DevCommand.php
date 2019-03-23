<?php
/**
 * @brief 开发控制器
 *
 * @author xieyong <qxieyongp@163.com> * @date 2018-10-10
 */

namespace Oranger\Command;

use Oranger\Library\Console\CommandBase;
use Oranger\Library\DI\DI;
use Oranger\Library\Tools\CsvFileIterator;
use Oranger\Library\Config\ConfigManager;

class DevCommand extends CommandBase
{
    public $a;

    protected $di;


    public function __construct()
    {
        

    }

    /**
     * undocumented function
     *
     * @author yourname
     * @param  mixed $a
     * @return void
     */
    public function indexAction()
    {
        $opt = [
            'combine' => true,
            'headers' => true,
        ];
        foreach ($a as $value) {
            var_dump($value);
        }
    }
}

<?php
/**
 * @brief 开发控制器
 *
 *
 * @author xieyong <qxieyongp@163.com> * @date 2018-10-10
 */

namespace Oranger\Command;

use Oranger\Library\Console\CommandBase;
use Oranger\Library\DI\DI;

class DevCommand extends CommandBase
{
    public $a;

    protected $di;

    public function __construct()
    {
        $redis = DI::getInstance()->redis;
        $data = $redis->object('encoding', 'bit');
        var_dump($data);
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
        $a = [
            'k1' => 'v1',
            'k2' => 'v2',
            'k3' => [
                'k4' => 'v4',
                'k5' => 'v5',
            ],
        ];

        echo json_encode($a);
    }

    public function yesAction() 
    {
        echo "xieyong commit";
    }
}

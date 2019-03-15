<?php
/**
 * @brief 开发控制器
 *
 * @author xieyong <qxieyongp@163.com> * @date 2018-10-10
 */

namespace Oranger\Command;

use Oranger\Library\Console\CommandBase;
use Oranger\Library\DI\DI;
use Oranger\Library\Model\KeyValConfig;

class DevCommand extends CommandBase
{
    public $a;

    protected $di;

    public function __construct()
    {
        $this->di = DI::getInstance();
    }

    /**
     * undocumented function
     *
     * @return void
     * @author yourname
     */
    public function indexAction()
    {
        $sql = <<<EOL
select * from test
EOL;
        $data = $this->di->db->pdo->query($sql)->fetchAll();
        var_dump($data);
    }
}

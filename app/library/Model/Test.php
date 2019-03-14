<?php
/**
 * @brief test
 *
 * @author xieyong <qxieyongp@163.com>
 * @date 2019-03-14 11:02
 */

namespace App\Library\Model;

use App\Library\Database\DBBase;

class Test extends DBBase
{
    /**
     * 配置名
     *
     * @var string
     */
    protected $config_name = 'db';

    /**
     * 表名
     *
     * @var string
     */
    protected $table = 'test';

    /**
     * @param
     */
    public function __construct()
    {
        parent::__construct();
    }
}

<?php
/**
 * @brief mysql key val存储表
 *
 * @author xieyong <qxieyongp@163.com>
 * @date 2019-03-14 11:02
 */

namespace Oranger\Library\Model;

use Oranger\Library\Database\DBBase;

class KeyValConfig extends DBBase
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
    protected $table = 'key_val_config';

    /**
     * @param
     */
    public function __construct()
    {
        parent::__construct();
    }
}

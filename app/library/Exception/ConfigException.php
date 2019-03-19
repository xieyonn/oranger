<?php
/**
 * 配置类异常
 *
 * @author: xieyong <qxieyongp@163.com>
 * @Date: 2017/8/18
 * @Time: 23:41
 */

namespace Oranger\Library\Exception;

use Oranger\Library\Core\Exception;

class ConfigException extends Exception
{
    /**
     * @var array 范围 1120-1130
     */
    protected $map = [
        'CONFIG_PATH_NOT_SET' => 1121,
        'CONFIG_FILE_NOT_EXIST' => 1122,
        'CONFIG_ITEM_NOT_EXIST' => 1123,
    ];
}

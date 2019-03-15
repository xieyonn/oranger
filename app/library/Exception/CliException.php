<?php
/**
 *@brief 命令行脚本异常
 *
 *@author xieyong <qxieyongp@163.com>
 *@date 2018-03-21
 */

namespace Oranger\Library\Exception;

use Oranger\Library\Core\Exception;

class CliException extends Exception
{
    /**
     * @var array 范围 1300~1400
     */
    protected $map = [
        'COMMAND_CLASS_SHOULD_INHERIT_COMMAND_BASE' => 1301,
        'PARAMS_NOT_GIVEN' => 1302,
        'CLASS_NOT_EXIST' => 1303,
        'INVALID CALL' => 1304,
    ];
}

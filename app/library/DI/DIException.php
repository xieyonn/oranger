<?php

/**
 * 依赖注入异常
 *
 * @author: xieyong <qxieyongp@163.com>
 * @Date: 2017/8/19
 * @Time: 22:25
 */

namespace Oranger\Library\DI;

use Oranger\Library\Core\Exception;

/**
 * Class DIException
 * @package App\Library\Exception
 */
class DIException extends Exception
{
    /**
     * @var array 范围 1100~1120
     */
    protected $map = [
        'SERVICE_DUPLICATE_DEFINE' => 1101,
        'SERVICE_NOT_DEFINED' => 1102,
        'INVOKE_SERVICE_FAILED' => 1103,
    ];
}

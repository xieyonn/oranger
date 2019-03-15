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
     * @var array 范围 101000 ~ 102000
     */
    protected $map = [
        'SERVICE_DUPLICATE_DEFINE' => ['code' => 101001, 'zh_cn' => '服务{name}重复定义'],
        'SERVICE_NOT_DEFINED' => ['code' => 101002, 'zh_cn' => '服务{name}未定义'],
        'INVOKE_SERVICE_FAILED' => ['code' => 101003, 'zh_cn' => '服务{name}调用失败'],
    ];
}

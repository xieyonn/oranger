<?php
/**
 * @brief 系统异常 与启动、配置相关的异常。
 *
 * @author xieyong <qxieyongp@163.com>
 * @date 2019-03-15 16:58
 */


namespace Oranger\Library\Exception;

use Oranger\Library\Core\Exception;

class SystemException extends Exception
{
    /**
     * @var array 范围 1000-1100
     */
    protected $map = [
        'LANGUAGE_FILE_NOT_EXIST' => 1001,
    ];
}

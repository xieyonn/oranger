<?php
/**
 * @brief KeyValService异常
 *
 * @author xieyong <qxieyongp@163.com>
 * @date 2019-03-14 15:00
 */

namespace Oranger\Library\Exception;

use Oranger\Library\Core\Exception;

class KeyValServiceException extends Exception
{
    /**
     * @var array 范围 102000 ~ 103000
     */
    protected $map = [
        'EMPTY_KEY' => 1140,
        'CONFIG_NOT_SET' => 1141,
        'SET_REDIS_ERROR' => 1142,
    ];
}

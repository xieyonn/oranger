<?php
/**
 * 用户服务层异常
 *
 * @author: xieyong <qxieyongp@163.com>
 * @Date: 2017/8/26
 * @Time: 15:26
 */

namespace Oranger\Library\Exception;

use Oranger\Library\Core\Exception;

class UserServiceException extends Exception
{
    /**
     * @var array 范围 1500-1600
     */
    protected $map = [
        'USERNAME_IS_EMPTY' => 1501,
        'USERNAME_EXISTED' => 1502,
        'PASSWORD_IS_EMPTY' => 1503,
        'STUDENTID_IS_EMPTY' => 1504,
        'STUDENTID_EXISTED' => 1505,
        'INVALID_UID' => 1506,
        'DB_ERROR' => 1507,
        'NICKNAME_IS_EMPTY' => 1508,
    ];
}

<?php
/**
 * 管理员用户服务层异常
 *
 * @author: xieyong <qxieyongp@163.com>
 * @Date: 2017/8/28
 * @Time: 21:36
 */

namespace Oranger\Library\Exception;

use Oranger\Library\Core\Exception;

/**
 * Class AdminUserServiceException
 * @package App\Library\Exception
 */
class AdminUserServiceException extends Exception
{
    /**
     * @var array 范围 1200-1300
     */
    protected $map = [
        'USERNAME_IS_EMPTY' => 1201,
        'DB_ERROR' => 1202,
        'USERNAME_EXISTED' => 1203,
    ];
}

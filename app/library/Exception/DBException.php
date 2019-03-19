<?php
/**
 * 数据库异常
 *
 * @author: xieyong <qxieyongp@163.com>
 * @Date: 2017/8/20
 * @Time: 20:00
 */

namespace Oranger\Library\Exception;

use Oranger\Library\Core\Exception;

class DBException extends Exception
{
    /**
     * @var array 范围 1400-1500
     */
    protected $map = [
        'DB_CONNECTION_ERROR' => 1401,
        'INSERT_TOO_MANY_ITEMS' => 1402,
        'DELETE_PARAM_EMPTY' => 1403,
        'ISEXIST_PARAM_EMPTY' => 1404,
        'UPDATE_WITH_EMPTY_CONDITION' => 1405,
        'DB_ERROR' => 1406,
        'DB_TABLENAME_EMPTY' => 1407,
    ];
}

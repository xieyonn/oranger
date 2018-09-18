<?php
/**
 * 服务层异常
 *
 * @author: xieyong <qxieyongp@163.com>
 * @Date: 2017/8/26
 * @Time: 14:59
 */

namespace App\Library\Exception;

use App\Library\Core\Exception;

/**
 * Class ServiceException
 * @package App\Library\Exception
 */
class ServiceException extends Exception
{
    /**
     * @var array 范围 103000 ~ 104000
     */
    protected $map = [

    ];
}

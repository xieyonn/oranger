<?php
/**
 * @brief http异常类
 *
 * @author xieyong <qxieyongp@163.com>
 * @date 2019-03-13 10:54
 */

namespace App\Library\Core;

class HttpException extends Exception
{
    /**
     * undocumented class variable
     *
     * @var string
     */
    public $http_code;

    public function __construct($message = "", $params = [], $http_code = 200)
    {
        $this->http_code = $http_code;
        parrent::__construct($message, $params);
    }
}

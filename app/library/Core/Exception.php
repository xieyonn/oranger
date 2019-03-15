<?php
/**
 * 异常类基类
 *
 * @author: xieyong <qxieyongp@163.com>
 * @Date: 2017/8/18
 * @Time: 22:27
 */

namespace Oranger\Library\Core;

use Throwable;
use Oranger\Library\Tools\T;

class Exception extends \Exception
{
    /**
     * $_map = [
     *     'EXCEPTION_NAME' => ['code' => 1001],
     * ]
     * @var array 字典
     */
    protected $map = [];

    /**
     * Exception constructor.
     *
     * @param string         $message msg
     * @param Throwable|null $previous
     *
     * @throws \Exception
     */
    public function __construct($message = "", $params = [], Throwable $previous = null)
    {
        if (empty($message)) {
            throw new \Exception('exception message is empty');
        }

        if (! isset($this->map[$message])) {
            throw new \Exception('exception code is not set yet');
        }


        $code = $this->map[$message];
        $msg = T::intl($code, $params);

        parent::__construct($msg, $code, $previous);
    }
}

<?php
/**
 *@brief 命令行脚本异常
 *
 *@author xieyong <qxieyongp@163.com>
 *@date 2018-03-21
 */

namespace App\Library\Exception;

use App\Library\Core\Exception;

class CliException extends Exception
{
    /**
     * @var array 范围 10000 ~ 11000
     */
    protected $map = [
        'COMMAND_CLASS_SHOULD_INHERIT_COMMAND_BASE' => ['code' => 10001, 'zh_cn' => '命令行必须继承CommandBase类'],
        'PARAMS_NOT_GIVEN' => ['code' => 10002, 'zh_cn' => '参数未设置'],
        'CLASS_NOT_EXIST' => ['code' => 10003, 'zh_cn' => '命令不存在'],
        'INVALID CALL' => ['code' => 10004, 'zh_cn' => '错误的调用{call}'],
    ];
}

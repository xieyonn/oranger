<?php

/**
 *@brief 命令行基类
 *
 *@author xieyong <qxieyongp@163.com>
 *@date 2018-03-20
 */

namespace Oranger\Library\Console;

use Oranger\Library\Exception\CliException;

abstract class CommandBase
{
    public $_invoke_args;

    protected function getParma(string $name)
    {
        if (isset($this->_invoke_args[$name])) {
            return $this->_invoke_args[$name];
        }

        throw new CliException('PARAMS_NOT_GIVEN');
    }
}

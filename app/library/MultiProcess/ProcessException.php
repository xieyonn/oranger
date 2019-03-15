<?php
/**
 * @brief 多进程 异常
 *
 * @author xieyong <xieyong@xiaomi.com>
 */
namespace Oranger\Library\MultiProcess;

use Oranger\Library\Core\Exception;

class ProcessException extends Exception
{
    protected $category = 'process';

    // [106100, 106200]
    protected $map = [
        'PARAMS_NEED_INDEXED_ARRAY' => ['code' => 106101, 'placeholders' => []],
        'PARAMS_EMPTY' => ['code' => 106102, 'zh_cn' => 'PARAMS_EMPTY'],
        'EXCEPTION_CATCH' => ['code' => 106103, 'zh_cn' => 'EXCEPTION_CATCH'],
        'INVALIED_CALLABLE' => ['code' => 106104, 'zh_cn' => 'INVALIED_CALLABLE'],
        'INVALIED_PROCESS_NUM' => ['code' => 106105, 'zh_cn' => 'INVALIED_PROCESS_NUM'],
    ];
}

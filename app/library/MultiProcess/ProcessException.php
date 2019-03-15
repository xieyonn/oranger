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
    /**
     * 范围 1130-1140
     */
    protected $map = [
        'PARAMS_NEED_INDEXED_ARRAY' => 1131,
        'PARAMS_EMPTY' => 1132,
        'EXCEPTION_CATCH' => 1133,
        'INVALIED_CALLABLE' => 1134,
        'INVALIED_PROCESS_NUM' => 1135,
    ];
}

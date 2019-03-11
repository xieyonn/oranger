<?php
/**
 * @brief 多进程 异常
 *
 * @author xieyong <xieyong@xiaomi.com>
 */
namespace App\Library\MultiProcess;

use App\Library\Core\Exception;

class ProcessException extends Exception
{
    protected $category = 'process';

    // [102501, 102600]
    protected $map = [
        'PARAMS_NEED_INDEXED_ARRAY' => ['code' => 102501, 'zh_cn' => 'PARAMS_NEED_INDEXED_ARRAY'],
        'PARAMS_EMPTY' => ['code' => 102502, 'zh_cn' => 'PARAMS_EMPTY'],
        'EXCEPTION_CATCH' => ['code' => 102503, 'zh_cn' => 'EXCEPTION_CATCH'],
        'INVALIED_CALLABLE' => ['code' => 102504, 'zh_cn' => 'INVALIED_CALLABLE'],
        'INVALIED_PROCESS_NUM' => ['code' => 102505, 'zh_cn' => 'INVALIED_PROCESS_NUM'],
    ];
}

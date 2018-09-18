<?php

use App\Library\Core\BaseController;
/**
 *@brief 当有未捕获的异常，控制流会流到这里
 *
 *@author xieyong <qxieyongp@163.com>
 *@date 2018-03-19
 */

class ErrorController extends BaseController
{
    /**
     * 异常捕获
     */
    public function errorAction($exception) {
        var_dump($exception);
    }
}

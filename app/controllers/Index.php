<?php

use App\Library\Core\BaseController;

/**
 *@brief hello
 *
 *@author xieyong <qxieyongp@163.com>
 *@date 2018-03-19
 */


class IndexController extends BaseController
{
    public function indexAction()
    {
        phpinfo();
    }
}

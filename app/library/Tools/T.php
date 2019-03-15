<?php
/**
 * @brief 语言转换工具
 *
 * @author xieyong <qxieyongp@163.com>
 * @date 2019-03-15 17:16
 */

namespace Oranger\Library\Tools;

use Oranger\Library\DI\DI;

class T
{
    /**
     * 语言转换
     *
     * @author xieyong
     * @param  mixed  $token
     * @param  mixed  $params
     * @return string
     */
    public static function intl($token, $params = [])
    {
        $lang_data = DI::getInstance()->lang_data;

        if (! isset($lang_data[$token])) {
            return $token;
        }

        $msg = $lang_data[$token];
        foreach ($params as $key => $value) {
            $msg = str_replace('{' . $key . '}', var_export($value, true), $msg);
        }

        return $msg;
    }
}

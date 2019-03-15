<?php
/**
 * @brief Json封装
 *
 * @author xieyong <qxieyongp@163.com>
 * @date 2019-03-13 15:01
 */

namespace Oranger\Library\Tools;

class Json
{
    /**
     * Json encode
     *
     * @return string
     * @author xieyong
     */
    public static function encode($data, $options = JSON_UNESCAPED_UNICODE, $depth = 512)
    {
        return \json_encode($data, $options, $depth);
    }

    /**
     * Json decode
     *
     * @return array|object
     * @author xieyong
     */
    public static function decode($data, $is_array = true, $depth = 512, $options = 0)
    {
        return \json_decode($data, $is_array, $depth, $options);
    }
}

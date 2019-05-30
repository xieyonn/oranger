<?php

/**
 * @brief PATH去重
 *
 * @author xieyong <qxieyongp@163.com>
 * @date 2019-05-19 11:02
 */

namespace Oranger\Library\Tools;

class PathRemoveDuplicate
{
    /**
     * 入口命令
     *
     * @return string
     */
    public static function run($data)
    {
        $path_array = explode(':', $data);

        $hash = [];
        foreach ($path_array as $entry) {
            $hash[$entry] = 1;
        }

        return implode(':', array_keys($hash));
    }
    
}


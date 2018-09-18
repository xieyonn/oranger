<?php
/**
 * @brief DB 帮助函数
 *
 * @author xieyong <qxieyongp@163.com>
 * @date 2018-04-08
 */

namespace App\Library\Tools;

class DBHelper
{
    /**
     * 绑定数组参数
     *
     * @param string $prefix
     * @param array $data
     * @return array
     */
    public static function bindArray(string $prefix, array $data)
    {
        $where = '';
        $bind = [];
        $i = 0;
        foreach ($data as $val) {
            $key = ':' . $prefix . $i;
            $where .= $key . ',';
            $bind[$key] = $val;
            $i++;
        }

        return ['where' => trim($where, ','), 'bind' => $bind];
    }
}

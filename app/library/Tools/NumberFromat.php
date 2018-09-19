<?php

/**
 * @brief 数字格式化
 *
 * @author xieyong <qxieyongp@163.com>
 * @date 2018-09-19
 */

namespace App\Library\Tools;

class NumberFormat
{
    /**
     * 格式化文件大小
     *
     * @param string $bytes 单位
     * @param integer $precision 精度
     * @return string
     */
    public static function formatBytes($bytes, $precision = 2)
    {
        $unit = ["B", "KB", "MB", "GB"];
        $exp = floor(log($bytes, 1024)) | 0;
        return round($bytes / (pow(1024, $exp)), $precision) . $unit[$exp];
    }
}

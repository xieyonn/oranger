<?php
/**
 * @brief 数学相关
 *
 * @author xieyong <qxieyongp@163.com>
 * @date 2018-06-20
 */

namespace App\Library\Tools;

class Math
{
    /**
     * 计算比例
     *
     * @param mixed $numerator 分子
     * @param mixed $denominator 分母
     * @return string
     */
    public function toPercent($numerator, $denominator)
    {
        // 分母为0
        if ($denominator == 0) {
            return '-';
        }

        $result = $numerator / $denominator;

        return number_format($result, 2) . '%';
    }
}
<?php
/**
 * @brief 日期帮助函数
 *
 * @author xieyong <qxieyongp@163.com>
 * @date 2018-04-07
 */

namespace App\Library\Tools;

class Datehelper
{
    const DAY = 86400; // 一天的秒数
    const WEEK = 604800; // 一周的秒数
    /**
     * 判断两个日期是否跨季度
     *
     * @param string $begin 开始时间
     * @param string $end 结束时间
     * @return boolean
     */
    public function isCrossSeason(string $begin, string $end)
    {
        $season = [
            1 => [1, 2, 3],
            2 => [1, 2, 3],
            3 => [1, 2, 3],
            4 => [4, 5, 6],
            5 => [4, 5, 6],
            6 => [4, 5, 6],
            7 => [7, 8, 9],
            8 => [7, 8, 9],
            9 => [7, 8, 9],
            10 => [10, 11, 12],
            11 => [10, 11, 12],
            12 => [10, 11, 12],
        ];

        $begin_month = date('n', strtotime($begin));
        $end_month = date('n', strtotime($end));
        
        return ! in_array($end_month, $season[$begin_month]);
    }

    /**
     * 下一个季度日期
     *
     * @param string $now 当前时间
     * @return string 下一个季度日期
     */
    public function nextSeasonDate(string $now)
    {
        $timestamp = strtotime($now);
        $year      = date('Y', $timestamp);
        $month     = date('n', $timestamp);
        if ($month <= 3) {
            return $year . '-04-01 00:00:00';
        }
        if ($month <= 6) {
            return $year . '-07-01 00:00:00';
        }
        if ($month <= 9) {
            return $year . '-10-01 00:00:00';
        } 

        return $year . '-12-31 23:59:59';
    }

    public function getNextMonth(string $start)
    {
        return date('Y-m-d', strtotime($start . ' +1 month'));
    }

    /**
     * 获取下个季节时间
     *
     * @param string $date_time
     * @return string
     */
    public function getNextSeason(string $date_time)
    {
        $timestamp = strtotime($date_time);
        $year      = date('Y', $timestamp);
        $month     = date('n', $timestamp);
        if ($month <= 3) {
            return $year . '-04-01 00:00:00';
        }
        if ($month <= 6) {
            return $year . '-07-01 00:00:00';
        }
        if ($month <= 9) {
            return $year . '-10-01 00:00:00';
        } 

        return $year . '-12-31 23:59:59';
    }

    /**
     * 获取最近的周的起止时间
     * @param string $now 当前时间
     * @param int $num 周的数量
     * @return array
     */
    public function genRecentWeek(string $now, int $num = 1)
    {
        $now_int = strtotime($now);
        $today_int = strtotime(date('Y-m-d', $now_int));
        $range         = array();
        $week_index    = date('N', $now_int); // 当前是星期几 1-星期一 7-星期日
        $monday        = $today_int - (($week_index - 1) * self::DAY); // 本周一
        $monday_string = date('Y-m-d', $monday);

        // 本周
        $range[] = array(
            'begin_time' => date(DATE_FMT,  $monday),
            'end_time'   => date(DATE_FMT,  $today_int),
        );

        // 前4周
        for ($i = 0; $i < $num; $i++) {
            $range[] = array(
                'begin_time' => date(DATE_FMT, strtotime($monday_string . ' -' . ($i + 1) . ' week')),
                'end_time'   => date(DATE_FMT, strtotime($monday_string . ' -' . $i . ' week') - self::DAY),
            );
        }

        return $range;
    }
}
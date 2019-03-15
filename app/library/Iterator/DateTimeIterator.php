<?php

/**
 * @brief 日期迭代器
 *
 * @author xieyong <xieyong@xiaomi.com>
 */

namespace Oranger\Library\Iterator;

use Iterator;

class DateTimeIterator implements Iterator
{
    const ORDER_LOW_HIGH = 0;
    const ORDER_HIGH_LOW = 1;

    protected $begin_time = 0;

    protected $end_time = 0;

    protected $position = 0;

    protected $option = [
        'interval' => 1, // 默认步进为1
        'step_length' => 600, // 默认步长600秒
        'is_format' => false, // 是否格式化
        'format_str' => 'Y-m-d H:i:s', //格式化字符串
        'timezone' => '', // 时区
        'order' => self::ORDER_HIGH_LOW, // 顺序默认从高到低
        'no_common_border' => false, // 边界不重叠 例如不重叠 [00:00:00 ~ 00:00:59] [00:01:00 ~ 00:01:59]
    ];

    public function __construct($begin_time, $end_time, $option = [])
    {
        $this->begin_time = $begin_time;
        $this->end_time = $end_time;
        $this->position = 0;

        if (! empty($option)) {
            $this->option = array_merge($this->option, $option);
        }
    }

    /**
     * 统一出口
     *
     * @param  int   $begin_time
     * @param  int   $end_time
     * @return array
     */
    protected function outPut($begin_time, $end_time)
    {
        if (! $this->option['is_format']) {
            return [
                'begin_time' => $begin_time,
                'end_time' => $end_time,
            ];
        }

        return [
            'begin_time' => $this->toDateTime($begin_time, $this->option['timezone']),
            'end_time' => $this->toDateTime($end_time, $this->option['timezone']),
        ];
    }

    /**
     * 时间戳转换为字符串
     *
     * @param  int    $unix_timestamp
     * @param  string $timezone
     * @return string
     */
    protected function toDateTime($unix_timestamp, $timezone)
    {
        if ($unix_timestamp === 0) {
            return 0;
        }

        $date_time_default = date($this->option['format_str'], $unix_timestamp);

        if (empty($timezone)) {
            return $date_time_default;
        }

        $date_obj = new \DateTime($date_time_default);
        try {
            $timezone_obj = new \DateTimeZone($timezone);
        } catch (\Exception $e) {
            throw new \Exception('illegal timezone');
        }
        $date_obj->setTimezone($timezone_obj);

        return $date_obj->format($this->option['format_str']);
    }

    public function rewind()
    {
        $this->position = 0;
    }

    public function current()
    {
        $step = $this->option['step_length'];

        if ($this->option['order'] === self::ORDER_LOW_HIGH) {
            // 从低到高
            $current_begin = $this->begin_time + ($step * $this->position);
            $current_end = $current_begin + $step;

            if ($current_end >= $this->end_time) {
                $current_end = $this->end_time;
            } elseif ($this->option['no_common_border']) {
                // 边界分离
                $current_end -= 1;
            }
        } else {
            // 从高到底
            $current_end = $this->end_time - ($step * $this->position);
            $current_begin = $current_end - $step;

            if ($current_begin <= $this->begin_time) {
                $current_begin = $this->begin_time;
            } elseif ($this->option['no_common_border']) {
                // 边界分离
                $current_begin += 1;
            }
        }

        return $this->outPut($current_begin, $current_end);
    }

    public function key()
    {
        return $this->position;
    }

    public function next()
    {
        $this->position += $this->option['interval'];
    }

    public function valid()
    {
        if ($this->option['order'] === self::ORDER_LOW_HIGH) {
            $position_time = $this->begin_time + ($this->option['step_length'] * $this->position);
            return ($position_time < $this->end_time);
        }
        $position_time = $this->end_time - ($this->option['step_length'] * $this->position);
        return ($position_time > $this->begin_time);
    }
}

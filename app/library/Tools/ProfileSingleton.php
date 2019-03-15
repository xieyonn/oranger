<?php

/**
 * @brief 性能记录
 *
 * @author xieyong <xieyong@xiaomi.com>
 */

namespace Oranger\Library\Tools;

class ProfileSingleton
{
    private static $_instance;
    private $data = [];
    private $history = [];

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (!self::$_instance instanceof self) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    /**
     * 开始记录
     *
     * @param string $mark
     * @return void
     */
    public function begin($mark)
    {
        $this->data[$mark] = microtime(true);
    }

    /**
     * 结束记录
     *
     * @param string $mark
     * @return int
     */
    public function end($mark)
    {
        if (!isset($this->data[$mark])) {
            return 0;
        }

        $now = microtime(true);
        $cost = $now - $this->data[$mark];
        $this->history[$mark][] = $cost;
        $this->data[$mark] = $now; // 多次使用end

        return $cost;
    }

    /**
     * 获取某一个标志的历史记录
     *
     * @param string $mark
     * @param bool $avg 是否计算平均值
     * @return string
     */
    public function getHistory($mark, $avg = false)
    {
        if (empty($this->history[$mark])) {
            return '';
        }

        $str = "[" . $mark . "]\n";

        if ($avg) {
            $count = 0;
            $sum = 0;

            foreach ($this->history[$mark] as $val) {
                $str .= $val . "\n";
                $count++;
                $sum += $val;
            }
            $str .= 'avg ' . $sum / $count;
        } else {
            $str .= implode("\n", $this->history[$mark]);
        }


        return $str;
    }

    public function __toString()
    {
        $str = '';
        foreach ($this->data as $mark => $val) {
            if (!empty($this->history[$mark])) {
                $str .= "[" . $mark . "]\n" . implode("\n", $this->history[$mark]) . "\n";
            }
        }

        return $str;
    }
}

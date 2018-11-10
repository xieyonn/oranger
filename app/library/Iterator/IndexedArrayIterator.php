<?php

/**
 * @brief 索引数组迭代器
 *
 * @author xieyong <xieyong@xiaomi.com>
 */

namespace App\Library\Iterator;

use Iterator;

class IndexedArrayIterator implements Iterator
{
    // 数据集和
    protected $data = [];
    // 集合个数
    protected $cnt = 0;
    protected $position = 0;

    protected $option = [
        'interval' => 1, // 迭代时步进
        'step_length' => 100, // 步长
        'preserve_keys' => false, // array_slice()参数 是否保留原索引数组的索引
    ];

    public function __construct($data, $option = [])
    {
        // 转为索引数组
        $this->data = array_values($data);
        $this->position = 0;
        $this->cnt = count($data);

        if (!empty($option)) {
            $this->option = array_merge($this->option, $option);
        }
    }

    public function rewind()
    {
        $this->position = 0;
    }

    public function current()
    {
        $offset = $this->option['step_length'] * $this->position;

        return array_slice($this->data, $offset, $this->option['step_length'], $this->option['preserve_keys']);
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
        $offset = $this->option['step_length'] * $this->position;

        return $offset < $this->cnt;
    }
}

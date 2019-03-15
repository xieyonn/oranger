<?php
/**
 * 配置类
 *
 * @author: xieyong <qxieyongp@163.com>
 * @Date: 2017/8/19
 * @Time: 13:58
 */

namespace Oranger\Library\Config;

use Oranger\Library\Exception\ConfigException;

class Config
{
    /**
     * @var array 配置
     */
    protected $config = [];

    /**
     * Config constructor.
     *
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    /**
     * 返回数组
     * @author: xieyong <qxieyongp@163.com>
     * @return array
     */
    public function toArray()
    {
        return $this->config;
    }

    /**
     * 返回一个配置项
     * @author: xieyong <qxieyongp@163.com>
     *
     * @param string $key key
     *
     * @throws ConfigException
     * @return mixed
     */
    public function item(string $key = '')
    {
        if (! isset($this->config[$key])) {
            throw new ConfigException('CONFIG_ITEM_NOT_EXIST', ['key' => $key]);
        }

        return $this->config[$key];
    }
}

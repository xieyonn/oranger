<?php
/**
 * 依赖注入类
 *
 * @author: xieyong <qxieyongp@163.com>
 * @Date: 2017/8/19
 * @Time: 22:17
 */

namespace Oranger\Library\DI;

class DI
{
    /**
     * @var DI 实例变量
     */
    protected static $_instance = null;
    /**
     * @var array 已注册服务
     */
    protected $services = [];

    /**
     * DI constructor.
     */
    private function __construct()
    {
    }

    /**
     * 单例模式，获取实例
     */
    public static function getInstance()
    {
        if (!self::$_instance instanceof self) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    /**
     * 重置(重置后需要重新定义服务)
     *
     * @return void
     */
    public static function reset()
    {
        self::$_instance = null;
    }

    /**
     * 设置服务
     * 
     * @param string $name 服务名字
     * @param        $define
     *
     * @throws DIException
     */
    public function set($name, $define)
    {
        if (isset($this->services[$name])) {
            throw new DIException('SERVICE_DUPLICATE_DEFINE', ['name' => $name]);
        }

        $service = new DIService($name, $define, false);
        $this->services[$name] = $service;
    }

    /**
     * 获取服务
     *
     * @param string $name 服务名
     * @param mixed  $params 调用服务时传递的参数
     *
     * @return mixed
     * @throws DIException
     */
    public function get($name, ...$params)
    {
        if (!isset($this->services[$name])) {
            throw new DIException('SERVICE_NOT_DEFINED', ['name' => $name]);
        }

        $service = $this->services[$name];

        return $service->invoke(...$params);
    }

    /**
     * 设置共享服务
     *
     * @param string $name 服务名
     * @param        $define
     *
     * @throws DIException
     */
    public function setShared($name, $define)
    {
        if (isset($this->services[$name])) {
            throw new DIException('SERVICE_DUPLICATE_DEFINE', ['name' => $name]);
        }

        $service = new DIService($name, $define, true);
        $this->services[$name] = $service;
    }

     /**
     * 判断是否设置了某服务
     *
     * @param string $name
     * @return boolean
     */
    public function has($name)
    {
        return isset($this->services[$name]);
    }

    /**
     * 魔术方法获取服务(只能以无参调用)
     *
     * @param string $name
     * @return void
     */
    public function __get($name)
    {
        if (isset($this->services[$name])) {
            return $this->services[$name]->invoke();
        }

        throw new DIException('SERVICE_NOT_DEFINED', ['name' => $name]);
    }
}

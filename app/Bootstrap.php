<?php

use Oranger\Library\Config\ConfigManager;
use Oranger\Library\Exception\SystemException;
use Oranger\Library\Core\ErrorHandler;
use Oranger\Library\Tools\Profile;

/**
 * 所有在Bootstrap类中, 以_init开头的方法, 都会被Yaf调用,
 * 这些方法, 都接受一个参数:Yaf_Dispatcher $dispatcher
 * 调用的次序, 和申明的次序相同
 *
 * @author: xieyong <qxieyongp@163.com>
 * @date: 2017/8/2
 * @time: 14:12
 * @see http://www.laruence.com/manual/yaf.class.bootstrap.html
 */
class Bootstrap extends Yaf_Bootstrap_Abstract
{
    /**
     * 是否输出错误
     */
    public function _init_is_open_error()
    {
        if (defined('DEBUG') && DEBUG == true) {
            ini_set('display_errors', 1);
            error_reporting(E_ALL);
        } else {
            ini_set('display_errors', 0);
            error_reporting(0);
        }
    }

    /**
     * 设置错误处理函数
     *
     * @return void
     * @author xieyong
     */
    public function _init_error_handler()
    {
        $handler = new ErrorHandler();
        \set_exception_handler([$handler, 'exceptionHanlder']);
        \set_error_handler([$handler, 'errorHandler']);
    }

    /**
     * 设置异常语言
     * @author: xieyong <qxieyongp@163.com>
     */
    public function _init_exception_language()
    {
        $config = Yaf_Application::app()->getConfig();
        $language = $config->application->language;
        $language_file = LANG_PATH . '/' . $language . '.php';

        if (!file_exists($language_file)) {
            throw new SystemException('LANGUAGE_FILE_NOT_EXIST');
        }

        $lang_data = include $language_file;
        \Oranger\Library\DI\DI::getInstance()->setShared('lang_data', function () use ($lang_data) {
            return $lang_data;
        });
    }

    /**
     * 注册插件
     * @author: xieyong <qxieyongp@163.com>
     */
    // public function _init_plugin()
    // {

    // }

    /**
     * 注册路由
     *
     * @param Yaf_Dispatcher $dispatcher
     */
    public function _init_route(Yaf_Dispatcher $dispatcher)
    {
        $router = $dispatcher->getRouter();
        $router->addConfig(new Yaf_Config_Ini(CONFIG_PATH . '/router.ini'));
    }

    /**
     * 注册日志服务
     * @author: xieyong <qxieyongp@163.com>
     */
    public function _init_logger()
    {
        $logger_config_array = ConfigManager::getInstance()->getConfig('logger')->toArray();
        $di = \Oranger\Library\DI\DI::getInstance();

        foreach ($logger_config_array as $logger_name => $logger_config) {
            // 日志服务是共享服务
            $di->setShared(
                $logger_name,
                \Oranger\Library\Logger\LoggerFactory::getLogger(
                    $logger_config['name'],
                    $logger_config['type'],
                    $logger_config['options']
                )
            );
        }
    }

    /**
     * 注册数据库服务(用Medoo类连接数据库)
     * @author: xieyong <qxieyongp@163.com>
     */
    public function _init_database()
    {
        $db_config_array = \Oranger\Library\Config\ConfigManager::getInstance()->getConfig('database')->toArray();

        if (! empty($db_config_array)) {
            foreach ($db_config_array as $name => $config) {
                // 数据库连接是共享服务
                \Oranger\Library\DI\DI::getInstance()
                    ->setShared($name, \Oranger\Library\Database\MedooProvider::getMedoo($config));
            }
        }
    }

    /**
     * 注册redis服务
     *
     * @return void
     * @author xieyong
     */
    public function _init_redis()
    {
        $redis_config_array = \Oranger\Library\Config\ConfigManager::getInstance()->getConfig('redis')->toArray();

        if (! empty($redis_config_array)) {
            foreach ($redis_config_array as $name => $config) {
                \Oranger\Library\DI\DI::getInstance()
                    ->setShared($name, function () use ($config) {
                        return new \Predis\Client([
                            'host' => $config['host'],
                            'port' => $config['port'],
                            'password' => $config['password'],
                        ], [
                            'prefix' => $config['prefix'],
                        ]);
                    });
            }
        }
    }

    /**
     * 注册性能记录器
     *
     * @return void
     */
    public function _init_profile()
    {
        \Oranger\Library\DI\DI::getInstance()->setShared('profile', function () {
            return Profile::getInstance();
        });
    }
}

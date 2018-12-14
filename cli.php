<?php

/**
 * 命令行入口文件
 *
 * @author: xieyong <qxieyongp@163.com>
 * @date: 2017/8/2
 * @time: 12:49
 *
 * @see Yaf框架 http://www.laruence.com/manual/index.html
 */

if (substr(php_sapi_name(), 0, 3) !== 'cli') {
    die("This Programe can only be run in CLI mode");
}

// 定义执行环境
define('ENV', 'dev');

if (defined('ENV') && ENV === 'dev') {
    define('DEBUG', true);
} else {
    define('ENV', 'prod');
    define('DEBUG', false);
}

// app id
define('APPID', 'pages');

// CLI命令
defined('STDIN') or define('STDIN', fopen('php://stdin', 'r'));
defined('STDOUT') or define('STDOUT', fopen('php://stdout', 'w'));
defined('STDERR') or define('STDERR', fopen('php://stderr', 'w'));

// 定义目录
define('ROOT_PATH', realpath(dirname(__FILE__)));
define('APP_PATH', ROOT_PATH . '/app');
define('CONFIG_PATH', ROOT_PATH . '/conf');
define('LOG_PATH', ROOT_PATH . '/logs');
define('LIB_PATH', APP_PATH . '/library');
define('VIEW_PATH', APP_PATH . '/views');
define('COMMAND_PATH', APP_PATH . '/command');

// 定义时区
date_default_timezone_set("Asia/Shanghai");

// 站点配置
require_once CONFIG_PATH . '/site_config.php';

// 其他宏定义
require_once CONFIG_PATH . '/define.php';

require ROOT_PATH . '/vendor/autoload.php';

// 检查php扩展
$need_extentions = ['yaf', 'PDO', 'pdo_mysql', 'json', 'mbstring'];
$php_extentions = get_loaded_extensions();
foreach ($need_extentions as $ext) {
    if (!in_array($ext, $php_extentions)) {
        echo 'need extension: ' . $ext;
        exit(-1);
    }
}

// psr-4 autoloader
spl_autoload_register(function ($class) {
    $path_array = explode('\\', trim($class, '\\\\'));
    // 前两个路径首字母要小写
    foreach ([0, 1] as $index) {
        if (! empty($path_array[$index])) {
            $path_array[$index] = lcfirst($path_array[$index]);
        }
    }

    $file_path = ROOT_PATH . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, $path_array) . '.php';
    if (file_exists($file_path)) {
        include $file_path;
    }
});

$app = new Yaf_Application(ROOT_PATH . "/conf/application.ini", ENV);
$app->bootstrap()->execute((new \App\Library\Console\CommandEntry())->run());




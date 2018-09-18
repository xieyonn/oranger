<?php
/**
 * 字符串相关工具函数
 *
 * @author: xieyong <qxieyongp@163.com>
 * @Date: 2017/8/26
 * @Time: 10:53
 */

namespace App\Library\Tools;

class StringHelper
{
    /**
     * 生成给定长度的随机字符串
     * @author: xieyong <qxieyongp@163.com>
     *
     * @param int $length 字符串长度
     *
     * @return string
     */
    public static function getRandomString(int $length = 1)
    {
        $str = '';
        $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        $max = strlen($strPol) - 1;

        for ($i = 0; $i < $length; $i++) {
            $str .= $strPol[rand(0, $max)];//rand($min,$max)生成介于min和max两个数之间的一个随机整数
        }

        return $str;
    }

    /**
     * 生成给定长度的随机字符串(包含特殊字符)
     * @author: xieyong <qxieyongp@163.com>
     *
     * @param int $length 字符串长度
     *
     * @return string
     */
    public static function getRandStringExt(int $length = 1)
    {
        $str = '';
        $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz!@#$%^&*()_+";
        $max = strlen($strPol) - 1;

        for ($i = 0; $i < $length; $i++) {
            $str .= $strPol[rand(0, $max)];//rand($min,$max)生成介于min和max两个数之间的一个随机整数
        }

        return $str;
    }

    /**
     * 将任意变量转为字符串
     *
     * @param mixed $var
     * @return string
     */
    public static function convertToString($var)
    {
        $result = '';
        switch (gettype($var)) {
            case "boolean":
            case "integer":
            case "double":
            case "string":
                $result = (string) $var;
                break;
            case "array":
                foreach ($var as $key => $val) {
                    $key = is_numeric($key) ? '' : $key . ": ";
                    $result .= $key . self::convertToString($val) . ' ';
                }
                break;
            case "object":
                $result = var_export($var, true);
                break;
            case "resource":
                try {
                    $result = get_resource_type($var);
                } catch (\Throwable $e) {
                    $result = 'unknown resource';
                }
                break;
            case "NULL":
                $result = "null";
                break;
            case "unknown type":
                $result = "unknown type";
                break;
            default:
                $result = 'failed get var type';
        }
        return $result;
    }

    /**
     * 获取utf8表头
     * @author: xieyong
     * @date: 2018/3/15
     * @return string
     */
    public static function getUtf8BOM()
    {
        return chr(239) . chr(187) . chr(191);
    }

    /**
     * 移除字符串前的BOM
     * @author: xieyong
     * @date: 2018/3/16
     *
     * @param $string
     *
     * @return  string
     */
    public static function removeUft8BOM($string)
    {
        $a = substr($string, 0, 1);
        $b = substr($string, 1, 2);
        $c = substr($string, 2, 3);

        if (empty($a) || empty($b) || empty($c)) {
            return $string;
        }

        if (ord($a) === 239 && ord($b) === 187 && ord($c) === 191) {
            return substr($string, 3);
        }

        return $string;
    }
}

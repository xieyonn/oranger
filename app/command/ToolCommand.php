<?php
/**
 * @brief 工具类
 *
 * @author xieyong <qxieyongp@163.com>
 * @date 2018-04-07
 */

namespace Oranger\Command;

use Oranger\Console\CommandBase;
use Oranger\Tools\StringHelper;

class ToolCommand extends CommandBase
{
    public function doAction()
    {
        var_dump(strlen('6180826651837488'));
    }

    public function nowAction()
    {
        var_dump(time());
        var_dump(date('Y-m-d H:i:s'));
    }

    public function rsaAction()
    {
        $result = '';
        $key = <<<EOL
-----BEGIN RSA PRIVATE KEY-----
MIIEogIBAAKCAQB8vXG0ImYhLHvHhpi5FS3gd2QhxSQiU6dQ04F1OHB0yRRQ3NXF
5py2NNDw962i4WP1zpUOHh94/mg/KA8KHNJXHtQVLXMRms+chomsQCwkDi2jbgUa
4jRFN/6N3QejJ42jHasY3MJfALcnHCY3KDEFh0N89FV4yGLyDLr+TLqpRecg9pkP
nOp++UTSsxz/e0ONlPYrra/DiaBjsleAESZSI69sPD9xZRt+EciXVQfybI/2SYeA
dXMm1B7tHCcFlOxeUgqYV03VEqiC0jVMwRCd+03NU3wvEmLBvGOmNGudocWIF/y3
VOqyW1byXFLeZxl7s+Y/SthxOYXzu3mF+2/pAgMBAAECggEAK5qZbYt8wenn1uZg
6onRwJ5bfUaJjApL+YAFx/ETtm83z9ByVbx4WWT7CNC7fK1nINy20/mJrOTZkgIx
x6otiNC4+DIsACJqol+RLoo8I9pk77Ucybn65ZteOz7hVZIU+8j6LzW0KDt6yowX
e75r7G/NEpfibNc3Zz81+oDd2x+bHyGbzc9QcePIVuEzkof6jgpbWrQZU14itx9l
VxEgj/fbMccvBx8brR/l9ClmDZd9Y6TWsF1rfJpF3+DPeqFkKCiD7PGz3bs4O/Zd
ZrfV21ZNVusBW49G6bU63gQVKsOf1qGo3efbAW1HVxgTQ/lExVdcMvdenZm+ADKp
L4/wUQKBgQDOfBjn3OC2IerUFu18EgCS7pSjTSibXw+TeX3D5zwszLC091G2rGlT
5DihBUhMfesNdpoZynrs4YB6Sz9C3wSGAB8AM/tNvPhtSVtbMHmrdT2DEEKCvLkO
RNBnt+8aTu2hGRanw9aL1189gzwrmXK5ZuuURfgLrB9ihrvjo4VznQKBgQCapx13
dEA1MwapBiIa3k8hVBCoGPsEPWqM33RBdUqUsP33f9/PCx00j/akwmjgQNnBlAJo
Y7LOqPCyiwOkEf40T4IlHdzYntWQQvHhfBwqSgdkTE9tKj43Ddr7JVFRL6yMSbW3
9qAp5UX/+VzOLGAlfzJ8CBnkXwGrnKPCVbnZvQKBgQCd+iof80jlcCu3GteVrjxM
LkcAbb8cqG1FWpVTNe4/JFgqDHKzPVPUgG6nG2CGTWxxv4UFKHpGE/11E28SHYjb
cOpHAH5LqsGy84X2za649JkcVmtclUFMXm/Ietxvl2WNdKF1t4rFMQFIEckOXnd8
y/Z/Wcz+OTFF82l7L5ehrQKBgFXl9m7v6e3ijpN5LZ5A1jDL0Yicf2fmePUP9DGb
ZTZbbGR46SXFpY4ZXEQ9GyVbv9dOT1wN7DXvDeoNXpNVzxzdAIt/H7hN2I8NL+4v
EjHG9n4WCJO4v9+yWWvfWWA/m5Y8JqusV1+N0iiQJ6T4btrE4JSVp1P6FSJtmWOK
W/T9AoGAcMhPMCL+N+AvWcYt4Y4mhelvDG8e/Jj4U+lwS3g7YmuQuYx7h5tjrS33
w4o20g/3XudPMJHhA3z+d8b3GaVM3ZtcRM3+Rvk+zSOcGSwn3yDy4NYlv9bdUj/4
H+aU1Qu1ZYojFM1Gmbe4HeYDOzRsJ5BhNrrV12h27JWkiRJ4F/Q=
-----END RSA PRIVATE KEY-----
EOL;

        $data = <<<EOL
uxQrofm9NmFJmaEm2tO5IbP5+ponFTD6Trhyi1RPFBEOyHnM1Aj1S4FSrAsLkpWRsMmOo6+Cyft8TwR5FFNDzJF83rI7QzHQ0OZi6MZw/lFuF/gkmNn9cPSoKbuVWYB1NZokmtqm78Tn4prqKh/n/qrkRIgh57OVZUNhCWn8UNVIJu6UqB5JoPb4l1EHKbqmPL/N8SyYw+hZaPZ/3M1fyrLpDkHDR2pgEfV1MvrGowz4HmO9D9WHX+56WtSkaP9rsWEY5F4dKV36ztP5OzpZn4jAt0RxX7TbZT0ED06ToLwqICcM6667cyfgTc7c76ANQR4TRhPdxToocsfsgR0s8A==
EOL;

        var_dump(($data));
        $status = openssl_private_decrypt($data, $result, $key);
        var_dump($status);
        var_dump($result);
    }

    public function ocAction()
    {
        $body = '{"time":1543419844,"source":"OC-API","waybill_id":518112844721355201,"code":10000,"msg":""}';
        $appid = 'xm_1001';
        $key = 'b8848ce2828a451ce2b5b537bcc8fb35';
        $key = 'a';

        $str = $appid . $body . $key;
        $sign = strtoupper(md5($str));
        var_dump($sign);
    }

    public function indexAction()
    {
        var_dump(strlen('118091370010096500'));
    }

    public function timeAction()
    {
        var_dump(strtotime('2018-09-10'));
    }

    public function CompareAction($a, $b)
    {
        $file_a = file_get_contents($a);
        $file_b = file_get_contents($b);

        $data_a = explode("\n", $file_a);
        $data_b = explode("\n", $file_b);

        var_dump(array_diff($data_a, $data_b));
        var_dump(array_diff($data_b, $data_a));
    }

    public function randStringAction($length = 10, $type = 0)
    {
        echo StringHelper::getRandomString($length);
    }

    public function randStringExtAction($length = 10, $type = 0)
    {
        echo StringHelper::getRandStringExt($length);
    }

    public function uniqueAction($s_path, $d_path)
    {
        if (! file_exists($s_path)) {
            throw new \Exception('file_not_exist');
        }

        $file_data = file_get_contents($s_path);
        $data = explode("\n", $file_data);

        $unique_data = array_unique($data);
        file_put_contents($d_path, implode("\n", $unique_data));
    }

    /**
     * 计算包裹单、发货单、合单数
     *
     * @param  [type] $file_path
     * @return void
     */
    public function doCountAction($file_path)
    {
        $file_data = file_get_contents($file_path);
        $data = explode("\n", $file_data);

        // throw new \Exception('a');die;
        $result = [];
        foreach ($data as $row) {
            $explode = explode(',', $row);
            $package_cnt = $explode[0];
            $waybill_cnt = $explode[1];
            $type = $explode[2];

            if (isset($result[$type]['waybill'])) {
                $result[$type]['waybill'] += $waybill_cnt;
            } else {
                $result[$type]['waybill'] = $waybill_cnt;
            }

            if (isset($result[$type]['package'])) {
                $result[$type]['package'] += $package_cnt;
            } else {
                $result[$type]['package'] = $package_cnt;
            }
        }

        foreach ($result as $key => $row) {
            echo $key . ' ' . $row['waybill'] . ' ' . $row['package'] . "\n";
        }
    }

    public function halfAction($file, $to)
    {
        $file_data = file_get_contents($file);
        $data = explode("\n", $file_data);

        $rtv = [];
        foreach ($data as $entry) {
            $rtv[] = $entry / 2;
        }

        file_put_contents($to, implode("\n", $rtv));
    }
}

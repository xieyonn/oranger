<?php
/**
 * @brief 工具类
 *
 * @author xieyong <qxieyongp@163.com>
 * @date 2018-04-07
 */

namespace App\Command;

use App\Library\Tools\StringHelper;

use App\Library\Console\CommandBase;

class ToolCommand extends CommandBase
{
    public function doAction()
    {
        $a = file_get_contents('/Users/xieyong/tmp/a');
        $b = file_get_contents('/Users/xieyong/tmp/b');

        $a_arr = explode("\n", $a);
        $b_arr = explode("\n", $b);
        var_dump(array_diff($a_arr, $b_arr));
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
     * @param [type] $file_path
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
        foreach($data as $entry) {
            $rtv[] = $entry / 2;
        }

        file_put_contents($to, implode("\n", $rtv));
    }
}
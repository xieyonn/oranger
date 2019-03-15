<?php
/**
 * @brief 比赛
 *
 * @author xieyong <qxieyongp@163.com>
 * @date 2018-04-09
 */

namespace Oranger\Command;

use Oranger\Console\CommandBase;

class MatchCommand extends CommandBase
{
    public function runAction ()
    {
        // $data = [1];
        $data = '1d00:00:00';
        $this->solution($data);
    }

    public function solution($line)
    {
        if (preg_match('#(\d+)d(\d{2}):(\d{2}):(\d{2})#', $line, $matches)) {
            $day = (int)$matches[1];
            $hour = (int)$matches[2];
            $minute = (int)$matches[3];
            $second = (int)$matches[4];

            $lack = 24 * $day; // 一天减少24秒

            if ($hour > $minute) {
                // 没有过当前小时内的临界点
                $lack += $hour;
            } 
            
            if ($hour == $minute && $second <= 58) {
                // 在临界点，但是没到58秒
                $lack += $hour;
            }
        
            if ($hour == $minute && $second > 58 || $hour < $minute) {
                $lack += $hour + 1;
            }

            $total_seconds = 86400 * $day + $hour * 3600 + $minute * 60 + $second;
            $total_seconds = $total_seconds - $lack;

            $my_day = ($total_seconds / 86400);
            $my_day_left = $total_seconds % 86400;
            $my_hour = $my_day_left / 3600;
            $my_hour_left = $my_day_left % 3600;
            $my_minute = $my_hour_left / 60;
            $my_second = $my_hour_left % 60;

            echo (int)$my_day . 'd' . addPrefixZero((int)$my_hour) . ':' 
                . addPrefixZero((int)$my_minute) . ':' 
                . addPrefixZero((int)$my_second);
        }
    }

 
    

    function solution2($line) {
        $money = explode(',', $line);
        $num = count($money);

        if ($num == 1) {
            echo $money[0];
            return;
        }
        if ($num == 2) {
            echo $money[0] > $money[1] ? $money[0] : $money[1];
            return;
        }
        $d = [];
        $d[0] = $money[0];
        $d[1] = $money[0] > $money[1] ? $money[0] : $money[1];
        for ($i = 2; $i < $num; $i++) {
            if (empty($money[$i])) {
                break;
            }

            $current = $money[$i];
            $left = empty($money[$i - 1]) ? 0 : $money[$i - 1];
            $right = empty($money[$i + 1]) ? 0 : $money[$i + 1];

            $take_it = $d[$i - 2] + $current;
            $not_take_it = $d[$i - 1];
            $d[$i] = $take_it > $not_take_it ? $take_it : $not_take_it;
        }

        echo $d[$num - 1];
    }


    function solution1($line) {
        if ($line == 1 || $line == 0) {
            echo 'Bad';
            return ;
        }
    
        $rule1 = (($line - 1 ) & ($line - 2)) == 0;
        $rule2 = (($line) & ($line + 1)) == 0;
        if ($rule1 && $rule2) {
            echo "Very Good";
        } elseif ($rule1 && ! $rule2) {
            echo "Good";
        } elseif (! $rule1 && $rule2) {
            echo "Bad";
        } else {
            echo "Normal";
        }

        return ;
    }
}

function addPrefixZero($num) {
    if (strlen($num) == 1) {
        return '0' . $num;
    } else {
        return $num;
    }
}


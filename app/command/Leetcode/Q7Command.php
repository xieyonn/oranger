<?php

/**
 * @brief Q7Command
 *
 * @author xieyong <qxieyongp@163.com>
 * @date 2019-03-24 23:13
 */

namespace Oranger\Command\Leetcode;

use Oranger\Library\Console\CommandBase;
use Oranger\Library\DI\DI;

class Q7Command extends CommandBase
{
    public function solution($x)
    {
        $max = 2147483647;
        $min = -2147483648;

        $r = '';
        $prefix = '';
        $x = (string) $x;
        if ($x == 0) {
            return 0;
        }
        $char_arry = str_split($x);

        if ($char_arry[0] === '-') {
            unset($char_arry[0]);
            $prefix = '-';
        }

        foreach ($char_arry as $value) {
            $r = $value . $r;
        }

        $r = (int) ($prefix . $r);

        if ($r < $min || $r > $max) {
            return 0;
        }
        return $r;
    }

    public function runAction($case = 0)
    {
        $input = [
            '123',
        ];

        $output = [
            '321',
        ];

        $test_case = [];
        if ($case == 0) {
            $test_case = $input;
            $expect = $output;
        } else {
            $case--;
            $test_case[$case] = $input[$case];
            $expect[$case] = $output[$case];
        }
        $this->di->profile->begin('mark');
        foreach ($test_case as $key => $entry) {
            $result = $this->solution($entry);
            if ($expect[$key] == $result) {
                DI::getInstance()->console_log->info("通过", $entry, "耗时", $this->di->profile->end('mark'));
            } else {
                DI::getInstance()->console_log->error("失败", $entry, "输出", $result, "预期结果", $expect[$key]);
            }
        }
    }

    private $di;

    public function __construct()
    {
        $this->di = DI::getInstance();
    }
}

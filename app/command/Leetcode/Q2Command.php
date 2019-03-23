<?php

/**
 * @brief Q2Command
 *
 * @author xieyong <qxieyongp@163.com>
 * @date 2019-03-21 17:47
 */

namespace Oranger\Command\Leetcode;

use Oranger\Library\Console\CommandBase;
use Oranger\Library\DI\DI;

class Q2Command extends CommandBase
{
    public function solution($l1, $l2)
    {

    }

    public function runAction($case = 0)
    {
        $input = [
            [[1,3], [2]],
        ];


        $expect = [
            '2.0'
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
            $result = $this->solution(...$entry);
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

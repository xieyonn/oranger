<?php

/**
 * @brief Q3Command
 *
 * @author xieyong <qxieyongp@163.com>
 * @date 2019-03-21 15:10
 */

namespace Oranger\Command\Leetcode;

use Oranger\Library\Console\CommandBase;
use Oranger\Library\DI\DI;

class Q3Command extends CommandBase
{
    public function solution($s)
    {
        $subs = [];
        $max_length = 0;
        $str_length = strlen($s);
        $breakpoint = -1;

        if (0 == $str_length) {
            return 0;
        }
        if (1 == $str_length) {
            return 1;
        }

        $length_count = 0;
        $str_arr = str_split($s);

        foreach ($str_arr as $key => $char) {
            $char = ord($char);
            if (! isset($subs[$char])) {
                $subs[$char] = $key;
                $length_count++;
            } else {
                $index = $subs[$char];
                if ($index > $breakpoint) {
                    $length_count = $key - $index;
                } else {
                    $length_count++;
                }

                $subs[$char] = $key;
                if ($index > $breakpoint) {
                    $breakpoint = $index;
                }
            }
            if ($length_count > $max_length) {
                $max_length = $length_count;
            }
        }
        return $max_length;
    }

    public function runAction($case = 0)
    {
        $input = [
            'abcabcbb',
            'bbbbb',
            'pwwkew',
            ' ',
            '',
            'dvdf',
            "abba",
            "tmmzuxt",
            "blqsearxxxbiwqa",
        ];

        $output = [
            3, 1, 3, 1, 0, 3, 2, 5, 8,
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

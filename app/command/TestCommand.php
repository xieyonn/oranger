<?php

/**
 *@brief test
 *
 *@author xieyong <qxieyongp@163.com>
 *@date 2018-03-19
 */

namespace Oranger\Command;

use Oranger\Console\CommandBase;
use Oranger\Tools\Datehelper;
use Oranger\Tools\DBHelper;
use Oranger\DI\DI;
use Oranger\MultiProcess\Daemon;
use Oranger\Tools\Profile;
use Oranger\Tools\ProfileSingleton;
use Oranger\Process\MultiProcess;
use Oranger\Tools\DateTimeHelper;

class TestCommand extends CommandBase
{
    public function runAction()
    {

    }

    public function f1($line)
    {
        $choice = explode(' ', $line);
        foreach ($choice as $item) {
            $choice[] = $item - 1;
        }

        $max = 0;
        $total = [];
        foreach ($choice as $pick) {
            if (empty($total[$pick])) {
                $total[$pick] = 0;
            }
            $total[$pick] += $pick;
            if ($total[$pick] > $max) {
                $max = $total[$pick];
            }
        }
        var_dump($total);

        return $max;
    }

    public function testAction($a1 = 0, $b1 = 1)
    {
        $obj = new Datehelper();
        $date = [
            ['begin' => '2018-01-01', 'end' => '2018-02-02'],
            ['begin' => '2018-01-01', 'end' => '2018-03-02'],
            ['begin' => '2018-01-01', 'end' => '2018-04-02'],
            ['begin' => '2018-01-01', 'end' => '2018-05-02'],
            ['begin' => '2018-01-01', 'end' => '2018-06-02'],
            ['begin' => '2018-01-01', 'end' => '2018-07-02'],
            ['begin' => '2018-01-01', 'end' => '2018-08-02'],
            ['begin' => '2018-01-01', 'end' => '2018-09-02'],
        ];
        foreach ($date as $item) {
            var_dump($obj->isCrossSeason($item['begin'], $item['end']));
        }
    }

    public function profileAction()
    {
        $p = ProfileSingleton::getInstance();

        for ($i = 0; $i < 3; $i++) {
            // $p->begin('test');
            usleep(100000);
            $p->end('test');
            $p->begin('aaa');
            $p->end('aaa');
            $p->end('aaa');
        }

        echo $p->getHistory('test', true) . "\n";
        echo $p;
    }

    public function logAction()
    {
        DI::getInstance()->get('console_log')->logException(new \Exception('a', 1, new \Exception('b', 3, new \Exception('c'))));
    }

    public function processAction()
    {
        $p = new MultiProcess(4, function () {
            echo 'a';
        });
        $p->run();
    }
}


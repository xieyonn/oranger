<?php
/**
 *@brief test
 *
 *@author xieyong <qxieyongp@163.com>
 *@date 2018-03-19
 */

namespace App\Command;

use App\Library\Console\CommandBase;
use App\Library\Tools\Datehelper;
use App\Library\Tools\DBHelper;
use App\Library\DI\DI;
use App\Library\MultiProcess\Daemon;
use app\Library\Tools\Profile;
use app\Library\Tools\ProfileSingleton;
use App\Library\Process\MultiProcess;
use App\Library\Tools\DateTimeHelper;


class TestCommand extends CommandBase
{
    public function runAction()
    {

        $a = 118083128260344501;
        $b = pow(2, 63);
        var_dump(pow(2, 64));
        var_dump($a > $b);
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


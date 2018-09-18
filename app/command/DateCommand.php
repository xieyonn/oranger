<?php
/**
 * @brief 日期命令行
 *
 * @author xieyong <qxieyongp@163.com>
 * @date 2018-04-07
 */
namespace App\Command;

use App\Library\Console\CommandBase;
use App\Library\Tools\Datehelper;

class DateCommand extends CommandBase
{
    public function nextSeasonDateAction()
    {
        $obj = new Datehelper();
        $start = date('Y-m-d', strtotime('2017-01-01'));
        for($i = 0; $i < 12; $i++) {
            $next = $obj->getNextMonth($start);
            $start = $next;
            var_dump($next);
            var_dump($obj->getNextSeason($start));
        }
    }

    public function getWeeksAction($num = 1)
    {
        $obj = new DateHelper();
        var_dump($obj->genRecentWeek(date(DATE_FMT), $num));
    }
}

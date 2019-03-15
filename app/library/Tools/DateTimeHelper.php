<?php
/**
 * @brief 时间帮助函数
 *
 * @author xieyong <xieyong@xiaomi.com>
 * @date 2018-05-20
 */

namespace Oranger\Library\Tools;

class DateTimeHelper
{
    const DATE_TIME_FORMAT = 'Y-m-d H:i:s';

    /**
     * format unix_timestamp, with specified timezone if provided.
     *
     * @param  int        $unix_timestamp unix_timestamp, default 0.
     * @param  string     $format         date or time formats
     * @param  string     $timezone       timezone, see http://php.net/manual/en/timezones.php
     * @throws \Exception illegal timezone
     * @return string     datetime
     */
    public static function toDateTime(
        $unix_timestamp = 0,
        $timezone = '',
        $format = self::DATE_TIME_FORMAT
    ) {
        if ($unix_timestamp === 0) {
            return '0000-00-00 00:00:00'; // default
        }

        // China Standard Time
        $date_time_cst = date($format, $unix_timestamp);

        if (empty($timezone)) {
            return $date_time_cst;
        }

        $date_obj = new \DateTime($date_time_cst);
        try {
            $timezone_obj = new \DateTimeZone($timezone);
        } catch (\Exception $e) {
            throw new \Exception('illegal timezone');
        }
        $date_obj->setTimezone($timezone_obj);

        return $date_obj->format($format);
    }

    /**
     * convert datetime string to unix_timestamp, with specified timezone if provided.
     *
     * @param  string $datetime datetime string to convert
     * @param  string $timezone datetimezone default determined by php config
     * @return int    unix_timestamp
     */
    public static function toUnixTimeStamp($datetime = '', $timezone = '')
    {
        if ($datetime === '') {
            return 0; // default
        }

        try {
            if (empty($timezone)) {
                $date_obj = new \DateTime($datetime);
            } else {
                $timezone_obj = new \DateTimeZone($timezone);
                $date_obj = new \DateTime($datetime, $timezone_obj);
            }
        } catch (\Exception $e) {
            throw new \Exception('unixtimestamp convert faild');
        }

        return $date_obj->getTimestamp();
    }
}

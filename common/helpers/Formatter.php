<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 2015/8/4 14:19
 * description:
 */

namespace common\helpers;

class Formatter
{
    const DATE_FORMAT = 'php:Y-m-d';
    const DATETIME_FORMAT = 'php:Y-m-d H:i:s';
    const TIME_FORMAT = 'php:H:i:s';

    public static function convert($dateStr, $type = 'date', $format = null)
    {
        if ($type === 'datetime') {
            $fmt = ($format == null) ? self::DATETIME_FORMAT : $format;
        } elseif ($type === 'time') {
            $fmt = ($format == null) ? self::TIME_FORMAT : $format;
        } else {
            $fmt = ($format == null) ? self::DATE_FORMAT : $format;
        }
        return \Yii::$app->formatter->asDate($dateStr, $fmt);
    }

    /**
     * 相对时间
     * @param $dateStr
     * @return string
     */
    public static function relative($dateStr)
    {
        return \Yii::$app->formatter->asRelativeTime($dateStr);
    }
}
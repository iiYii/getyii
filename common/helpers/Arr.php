<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 16/3/19 上午9:57
 * description:
 */

namespace common\helpers;


use yii\helpers\ArrayHelper;

class Arr extends ArrayHelper
{
    /**
     * 随机筛选$num个数组
     * @param array $arr
     * @param int $num
     * @return array
     */
    public static function arrayRandomAssoc(Array $arr, $num = 1)
    {
        if (!$arr) {
            return false;
        }
        $keys = array_keys($arr);
        shuffle($keys);

        $r = [];
        for ($i = 0; $i < $num; $i++) {
            $r[$keys[$i]] = $arr[$keys[$i]];
        }
        return $r;
    }
}
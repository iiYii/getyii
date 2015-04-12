<?php

use yii\db\Schema;
use common\components\db\Migration;

class m150412_034147_update_site_setting extends Migration
{
    public function up()
    {
    	$this->execute($this->delSettingSql());
    	$this->execute($this->updateSettingSql());
    	$this->execute($this->getSettingSql());
    }

    /**
     * @return string SQL to insert first user
     */
    private function getSettingSql()
    {
        return "INSERT INTO {{%setting}} (`id`, `parent_id`, `code`, `type`, `store_range`, `store_dir`, `value`, `sort_order`) VALUES
            (1114, 11, 'siteAnalytics', 'text', '', '', 'Your Site Analytics', '50'),
            (4114, 41, 'googleLogin', 'select', '0,1', '', '1', '50'),
            (4115, 41, 'googleClientId', 'text', '', '', '', '50'),
            (4116, 41, 'googleClientSecret', 'text', '', '', '', '50'),
            (4117, 41, 'weiboLogin', 'select', '0,1', '', '1', '50'),
            (4118, 41, 'weiboClientId', 'text', '', '', '', '50'),
            (4119, 41, 'weiboClientSecret', 'text', '', '', '', '50'),
            (4120, 41, 'qqLogin', 'select', '0,1', '', '1', '50'),
            (4121, 41, 'qqClientId', 'text', '', '', '', '50'),
            (4122, 41, 'qqClientSecret', 'text', '', '', '', '50')
            ";
    }

    private function updateSettingSql()
    {
        return "UPDATE {{%setting}} SET `code` = 'account' WHERE `id` = 41";
    }

    private function delSettingSql()
    {
        return "DELETE FROM {{%setting}} WHERE `id` IN (
				51, 5111, 5112, 5113
        	)";
    }
}

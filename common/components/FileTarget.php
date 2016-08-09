<?php

/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 2015/12/22 18:13
 * description:
 */
namespace common\components;

use Yii;
use yii\helpers\FileHelper;

class FileTarget extends \yii\log\FileTarget
{
    /**
     * @var bool 是否启用日志前缀 (@app/runtime/logs/error/20151223_app.log)
     */
    public $enableDatePrefix = false;

    /**
     * @var bool 启用日志等级目录
     */
    public $enableCategoryDir = false;

    private $_logFilePath = '';

    public function init()
    {
        if ($this->logFile === null) {
            $this->logFile = Yii::$app->getRuntimePath() . '/logs/app.log';
        } else {
            $this->logFile = Yii::getAlias($this->logFile);
        }
        $this->_logFilePath = dirname($this->logFile);

        // 启用日志前缀
        if ($this->enableDatePrefix) {
            $filename = basename($this->logFile);
            $this->logFile = $this->_logFilePath . '/' . date('Ymd') . '_' . $filename;
        }

        if (!is_dir($this->_logFilePath)) {
            FileHelper::createDirectory($this->_logFilePath, $this->dirMode, true);
        }

        if ($this->maxLogFiles < 1) {
            $this->maxLogFiles = 1;
        }
        if ($this->maxFileSize < 1) {
            $this->maxFileSize = 1;
        }

    }
}
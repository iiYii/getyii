<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 16/8/7 上午10:44
 * description:
 */

namespace common\components;

use yii\composer\Installer;

class ComposerInstaller extends Installer
{
    public static function initProject($event)
    {
        foreach (['formatAdminLTE'] as $method) {
            call_user_func_array([__CLASS__, $method], [$event]);
        }
    }

    /**
     * 替换 AmdinLTE 模板的google api, 原因嘛....
     * @link http://www.cmsky.com/google-fonts-ssl-ustc/
     * @param $event
     */
    public static function formatAdminLTE($event)
    {
        $composer = $event->getComposer();
        $extra = $composer->getPackage()->getExtra();
        if (isset($extra['asset-installer-paths']['bower-asset-library'])) {
            $bowerAssetDir = $extra['asset-installer-paths']['bower-asset-library'];
            $cssFile[] = rtrim($bowerAssetDir, '/') . '/../almasaeed2010/adminlte/dist/css/AdminLTE.css';
            $cssFile[] = rtrim($bowerAssetDir, '/') . '/../almasaeed2010/adminlte/dist/css/AdminLTE.min.css';
            foreach ($cssFile as $css) {
                self::replaceCss($css);
            }
        } else {
            echo "'npm-asset-library' is not set.\n";
        }
    }

    /**
     * @param $cssFile
     */
    public static function replaceCss($cssFile)
    {
        if (file_exists($cssFile)) {
            $content = file_get_contents($cssFile);
            if ($content = str_replace('fonts.googleapis.com', 'fonts.css.network', $content)) {
                file_put_contents($cssFile, $content);
                echo "'{$cssFile}' google api replace success.\n";
            }
        } else {
            echo "'{$cssFile}' file is not exists.\n";
        }
    }
}
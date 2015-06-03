<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 15/5/17 下午4:14
 * description:
 */

namespace common\helpers;

class Avatar
{
    public $email;
    public $size;

    public function __construct($email, $size = 50)
    {
        $this->email = $email;
        $this->size = $size;
    }

    public function getAvater()
    {
        // 说明： Gravatar 随机头像太丑了 所以使用 Identicon 随机头像
        // TODO 保存头像图片 加缓存
        // return $this->getGravatar();
        $identicon = new \Identicon\Identicon();
        return $identicon->getImageDataUri($this->email, $this->size);
    }

    /**
     * 根据 email 获取 gravatar 头像的地址
     * @return string
     */
    private function getGravatar()
    {
        $hash = md5(strtolower(trim($this->email)));
        return sprintf('http://gravatar.com/avatar/%s?s=%d&d=%s', $hash, $this->size, 'identicon');
    }

    /**
     * 验证email是否有对应的 Gravatar 头像（效率太低）
     * @return bool
     */
    private function validateGravatar()
    {
        $hash = md5(strtolower(trim($this->email)));
        $uri = 'http://gravatar.com/avatar/' . $hash . '?d=404';
        $headers = @get_headers($uri);
        if (!preg_match("|200|", $headers[0])) {
            return false;
        } else {
            return true;
        }
    }
}
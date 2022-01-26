<?php

namespace Mrwanghongda\OssSdk;

use Mrwanghongda\OssSdk\Exception\NonsupportOssException;
use Mrwanghongda\OssSdk\Service\Aliyun;
use Mrwanghongda\OssSdk\Service\Qiniu;
use Mrwanghongda\OssSdk\Service\Tencent;

class OssFactory
{
    /**
     * 七牛云
     */
    const OSS_QINIU = 'qiniu';

    /**
     * 腾讯云
     */
    const OSS_TENCENT = 'tencent';

    /**
     * 阿里云
     */
    const OSS_ALIYUN = 'aliyun';

    //私有属性
    private $ossType;

    public function __construct($type)
    {
        $this->smsType = $type;
    }

    public function getOssService()
    {
        $storage = null;

        switch ($this->smsType) {
            case self::OSS_QINIU:
                //短信宝
                $storage = new Qiniu();
                break;
            case self::OSS_TENCENT:
                //腾讯云
                $storage = new Tencent();
                break;
            case self::OSS_ALIYUN:
                //阿里云
                $storage = new Aliyun();
                break;
            default:
                throw new NonsupportOssException();
        }

        return $storage;
    }
}
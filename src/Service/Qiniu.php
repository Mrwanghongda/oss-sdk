<?php

namespace Mrwanghongda\OssSdk\Service;


use Qiniu\Auth;
use Qiniu\Storage\BucketManager;
use Qiniu\Storage\UploadManager;
use Mrwanghongda\OssSdk\config\OssConfig;
use Mrwanghongda\OssSdk\Interfaces\OssInterface;


class Qiniu implements OssInterface
{

    /**
     * @var Auth
     */
    private $auth;

    /**
     * @var string;
     */
    private $bucket;

    public function init(OssConfig $config)
    {
        // TODO: Implement init() method.
        $config->checkParams();

        $this->auth = new Auth($config->getAppId(), $config->getAppKey());
        return $this;
    }

    public function bucket(string $bucket)
    {
        // TODO: Implement bucket() method.
        $this->bucket = $bucket;
        return $this;
    }

    public function get(int $limit, string $delimiter = '', string $prefix = '', string $marker = '')
    {
        // TODO: Implement get() method.
        $bucketManager = new BucketManager($this->auth);
        list($ret, $err) = $bucketManager->listFiles($this->bucket, $prefix, $marker, $limit, $delimiter);

        return $err ?: $ret;
    }

    public function put(string $key, string $path)
    {
        // TODO: Implement put() method.
        $token = $this->auth->uploadToken($this->bucket);
        $uploadMgr = new UploadManager();

        list($ret, $err) = $uploadMgr->putFile($token, $key, $path);

        return $err ?: $ret;
    }

    public function delete(array $keys)
    {
        // TODO: Implement delete() method.
        $bucketManager = new BucketManager($this->auth);
        $ops = $bucketManager->buildBatchDelete($this->bucket, $keys);
        list($ret, $err) = $bucketManager->batch($ops);

        return $err ?: $ret;
    }
}
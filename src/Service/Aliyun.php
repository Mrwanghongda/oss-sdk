<?php

namespace Mrwanghongda\OssSdk\Service;

use Mrwanghongda\OssSdk\config\OssConfig;
use Mrwanghongda\OssSdk\Exception\ConfigException;
use Mrwanghongda\OssSdk\Interfaces\OssInterface;
use OSS\OssClient;

class Aliyun implements OssInterface
{
    /**
     * @var OssClient
     */
    private $ossClient;

    /**
     * @var string;
     */
    private $bucket;

    public function init(OssConfig $config)
    {
        $config->checkParams();

        $this->ossClient = new OssClient($config->getAppId(), $config->getAppKey(), $config->getRegion());

        return $this;
    }

    public function bucket(string $bucket)
    {
        $this->bucket = $bucket;
        return $this;
    }

    public function get(int $limit, string $delimiter = '', string $prefix = '', string $marker = '')
    {
        $options = [
            'delimiter' => $delimiter,
            'prefix' => $prefix,
            'max-keys' => $limit,
            'marker' => $marker,
        ];
        return $this->ossClient->listObjects($this->bucket, $options);
    }

    public function put(string $key, string $path)
    {
        if (!is_file($path)) {
            throw new ConfigException("Parameter 2 must be a valid file path");
        }

        return $this->ossClient->uploadFile($this->bucket, $key, $path);
    }

    public function delete(array $keys)
    {
        return $this->ossClient->deleteObjects($this->bucket, $keys);
    }
}
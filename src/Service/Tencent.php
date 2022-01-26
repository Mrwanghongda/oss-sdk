<?php

namespace Mrwanghongda\OssSdk\Service;


use Mrwanghongda\OssSdk\config\OssConfig;
use Mrwanghongda\OssSdk\Exception\ConfigException;
use Mrwanghongda\OssSdk\Interfaces\OssInterface;
use Qcloud\Cos\Client;


class Tencent implements OssInterface
{
    /**
     * @var Client
     */
    private $ossClient;

    /**
     * @var string;
     */
    private $bucket;

    public function init(OssConfig $config)
    {
        $config->checkParams();

        $this->ossClient = new Client([
            'region' => $config->getRegion(),
            'schema' => 'https', //协议头部，默认为http
            'credentials' => [
                'secretId' => $config->getAppId(),
                'secretKey' => $config->getAppKey()
            ]
        ]);

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
            'Bucket' => $this->bucket,
            'Delimiter' => $delimiter,
            'Prefix' => $prefix,
            'MaxKeys' => $limit,
            'Marker' => $marker,
        ];
        return $this->ossClient->listObjects($options);
    }

    public function put(string $key, string $path)
    {
        if (!is_file($path)) {
            throw new ConfigException("Parameter 2 must be a valid file path");
        }

        $file = fopen($path, 'rb');

        return $this->ossClient->upload($this->bucket, $key, $file);
    }

    public function delete(array $keys)
    {
        $objects = array_map(function ($key) {
            return ['Key' => $key];
        }, $keys);

        $options = [
            'Bucket' => $this->bucket,
            'Objects' => $objects,
        ];

        return $this->ossClient->deleteObjects($options);
    }
}
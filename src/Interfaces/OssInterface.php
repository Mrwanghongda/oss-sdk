<?php

namespace Mrwanghongda\OssSdk\Interfaces;



use Mrwanghongda\OssSdk\config\OssConfig;

interface OssInterface
{
    /**
     * 根据配置类初始化云API
     * @param OssConfig $config
     * @return mixed
     */
    public function init(OssConfig $config);

    /**
     * 指定操作的存储桶
     * @param string $bucket 存储桶名称
     * @return mixed
     */
    public function bucket(string $bucket);

    /**
     * 文件列表查询
     * @param int $limit 查询条目数
     * @param string $delimiter 要分隔符分组结果
     * @param string $prefix 指定key前缀查询
     * @param string $marker 标明本次列举文件的起点
     * @return mixed
     */
    public function get(int $limit, string $delimiter = '', string $prefix = '', string $marker = '');

    /**
     * 单文件上传
     * @param string $key 指定唯一的文件key
     * @param string $path 包含扩展名的完整文件路径
     */
    public function put(string $key, string $path);

    /**
     * 删除指定key的文件
     * @param array $keys 待删除的key数组
     */
    public function delete(array $keys);
}
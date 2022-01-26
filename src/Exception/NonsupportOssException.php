<?php

namespace Mrwanghongda\OssSdk\Exception;

class NonsupportOssException extends \Exception
{
    protected $message = '未匹配到云存储媒介，请检查参数是否正确！';
}
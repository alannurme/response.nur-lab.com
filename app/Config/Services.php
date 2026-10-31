<?php

namespace Config;

use CodeIgniter\Cache\CacheFactory;
use CodeIgniter\Cache\CacheInterface;
use CodeIgniter\Cache\Handlers\DummyHandler;
use CodeIgniter\Config\BaseService;
use Config\Cache;

/**
 * Services Configuration file.
 *
 * Services are simply other classes/libraries that the system uses
 * to do its job. This is used by CodeIgniter to allow the core of the
 * framework to be swapped out easily without affecting the usage within
 * the rest of your application.
 *
 * This file holds any application-specific services, or service overrides
 * that you might need. An example has been included with the general
 * method format you should use for your service methods. For more examples,
 * see the core Services file at system/Config/Services.php.
 */
class Services extends BaseService
{
    /**
     * Bulletproof Cache Service: Never throw unhandled CacheException
     * if the cache directory is unwritable or corrupt. Automatically fallback to DummyHandler.
     */
    public static function cache(?Cache $config = null, bool $getShared = true): CacheInterface
    {
        if ($getShared) {
            return static::getSharedInstance('cache', $config);
        }

        $config ??= config(Cache::class);

        // Always ensure writable/cache path matches the current running system root
        $runtimeCachePath = rtrim(WRITEPATH . 'cache', '\\/') . '/';
        $config->file['storePath'] = $runtimeCachePath;

        try {
            return CacheFactory::getHandler($config);
        } catch (\Throwable $e) {
            return new DummyHandler();
        }
    }
}

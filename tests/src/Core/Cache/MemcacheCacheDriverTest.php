<?php


namespace Friendica\Test\src\Core\Cache;

use Friendica\Core\Cache\CacheDriverFactory;

/**
 * @requires extension memcache
 */
class MemcacheCacheDriverTest extends MemoryCacheTest
{
	protected function getInstance()
	{
		$this->configCache
			->shouldReceive('get')
			->with('system', 'memcache_host', NULL, false)
			->andReturn('localhost');

		$this->configCache
			->shouldReceive('get')
			->with('system', 'memcache_port', NULL, false)
			->andReturn(11211);

		$this->cache = CacheDriverFactory::create('memcache');
		return $this->cache;

	}

	public function tearDown()
	{
		$this->cache->clear(false);
		parent::tearDown();
	}
}

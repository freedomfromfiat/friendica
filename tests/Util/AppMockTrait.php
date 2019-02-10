<?php

namespace Friendica\Test\Util;

use Friendica\App;
use Friendica\BaseObject;
use Friendica\Core\Config;
use Friendica\Render\FriendicaSmartyEngine;
use Mockery\MockInterface;
use org\bovigo\vfs\vfsStreamDirectory;

/**
 * Trait to Mock the global App instance
 */
trait AppMockTrait
{
	/**
	 * @var MockInterface|App The mocked Friendica\App
	 */
	protected $app;

	/**
	 * @var MockInterface|Config\Configuration The mocked Config Cache
	 */
	protected $configCache;

	/**
	 * Mock the App
	 *
	 * @param vfsStreamDirectory $root The root directory
	 * @param MockInterface|Config\Configuration $config The config cache
	 */
	public function mockApp($root, Config\Configuration $config)
	{
		$this->configCache = $config;
		// Mocking App and most used functions
		$this->app = \Mockery::mock(App::class);
		$this->app
			->shouldReceive('getBasePath')
			->andReturn($root->url());

		$config
			->shouldReceive('get')
			->with('database', 'hostname')
			->andReturn(getenv('MYSQL_HOST'));
		$config
			->shouldReceive('get')
			->with('database', 'username')
			->andReturn(getenv('MYSQL_USERNAME'));
		$config
			->shouldReceive('get')
			->with('database', 'password')
			->andReturn(getenv('MYSQL_PASSWORD'));
		$config
			->shouldReceive('get')
			->with('database', 'database')
			->andReturn(getenv('MYSQL_DATABASE'));
		$config
			->shouldReceive('get')
			->with('config', 'hostname')
			->andReturn('localhost');
		$config
			->shouldReceive('get')
			->with('system', 'theme', NULL, false)
			->andReturn('system_theme');
		$config
			->shouldReceive('getConfig')
			->andReturn($config);

		$this->app
			->shouldReceive('getConfigCache')
			->andReturn($config);

		$this->app
			->shouldReceive('getTemplateEngine')
			->andReturn(new FriendicaSmartyEngine());
		$this->app
			->shouldReceive('getCurrentTheme')
			->andReturn('Smarty3');
		$this->app
			->shouldReceive('saveTimestamp')
			->andReturn(true);
		$this->app
			->shouldReceive('getBaseUrl')
			->andReturn('http://friendica.local');

		// Initialize empty Config
		Config::init($config);

		BaseObject::setApp($this->app);
	}
}

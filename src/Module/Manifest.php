<?php

namespace Friendica\Module;

use Friendica\BaseModule;
use Friendica\Core\Renderer;

class Manifest extends BaseModule
{
	public static function rawContent()
	{
		$app = self::getApp();
		$config = $app->getConfig();

		$tpl = Renderer::getMarkupTemplate('manifest.tpl');

		header('Content-type: application/manifest+json');

		$touch_icon = $config->get('system', 'touch_icon', 'images/friendica-128.png');
		if ($touch_icon == '') {
			$touch_icon = 'images/friendica-128.png';
		}

		$output = Renderer::replaceMacros($tpl, [
			'$baseurl' => $app->getBaseURL(),
			'$touch_icon' => $touch_icon,
			'$title' => $config->get('config', 'sitename', 'Friendica'),
		]);

		echo $output;

		exit();
	}
}

<?php declare(strict_types=1);

namespace Blueweb\Instagram\DI;

use Blueweb\Instagram\Client\InstagramClient;
use Nette\DI\CompilerExtension;
use Nette\Schema\Expect;
use Nette\Schema\Schema;
use Nette\Utils\Validators;

class InstagramExtension extends CompilerExtension
{

	/** @var mixed[] */
	protected $defaults = [
			'apiKey' => null
	];

	public function loadConfiguration(): void
	{
		$builder = $this->getContainerBuilder();
		$config = $this->validateConfig($this->defaults);

		Validators::assertField($config, 'apiKey', 'string', 'instagram api_key');

		$builder->addDefinition($this->prefix('instagram'))
			->setFactory(InstagramClient::class, [
				$config['apiKey'],
			])->setAutowired(true);

	}

}

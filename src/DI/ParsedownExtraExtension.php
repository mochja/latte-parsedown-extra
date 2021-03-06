<?php

namespace Contributte\Parsedown\DI;

use Contributte\Parsedown\ParsedownExtraAdapter;
use Nette\DI\CompilerExtension;
use Nette\InvalidStateException;

/**
 * ParsedownExtra Extension
 *
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 */
class ParsedownExtraExtension extends CompilerExtension
{

	/** @var array */
	private $defaults = [
		'helper' => 'parsedown',
	];

	/**
	 * Register services
	 *
	 * @return void
	 */
	public function loadConfiguration()
	{
		$config = $this->validateConfig($this->defaults);
		$builder = $this->getContainerBuilder();

		$builder->addDefinition($this->prefix('parsedown'))
			->setClass(ParsedownExtraAdapter::class);
	}

	/**
	 * Decorate services
	 *
	 * @return void
	 */
	public function beforeCompile()
	{
		$config = $this->validateConfig($this->defaults);
		$builder = $this->getContainerBuilder();

		$templateFactory = $builder->getByType('Nette\Bridges\ApplicationLatte\ILatteFactory');
		if (!$templateFactory) {
			throw new InvalidStateException('Service implemented ILatteFactory not found.');
		}

		$builder->getDefinition($templateFactory)
			->addSetup('addFilter', [$config['helper'], ['@' . $this->prefix('parsedown'), 'process']]);
	}

}

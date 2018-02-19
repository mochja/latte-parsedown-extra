<?php

namespace Contributte\Parsedown;

use Latte\Runtime\FilterInfo;
use Nette\SmartObject;
use ParsedownExtra;

/**
 * ParsedownExtra Adapter
 *
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 * @method void onProcess(string $text, ParsedownExtraAdapter $adapter)
 */
class ParsedownExtraAdapter
{

	use SmartObject;

	/** @var ParsedownExtra */
	private $parsedown;

	/** @var array */
	public $onProcess = [];

	/**
	 * Creates adapter
	 */
	public function __construct()
	{
		$this->parsedown = new ParsedownExtra();
	}

	/**
	 * @param FilterInfo $info
	 * @param mixed $text
	 * @return mixed
	 */
	public function process(FilterInfo $info, $text)
	{
		$this->onProcess($text, $this);

		return $this->parsedown->parse($text);
	}

	/**
	 * @param FilterInfo $info
	 * @param mixed $line
	 * @return string
	 */
	public function processLine(FilterInfo $info, $line)
	{
		$this->onProcess($line, $this);

		return $this->parsedown->line($line);
	}

}

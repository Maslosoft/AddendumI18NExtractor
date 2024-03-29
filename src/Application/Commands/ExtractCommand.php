<?php

/**
 * This software package is licensed under `BSD-3-Clause` license[s].
 *
 * @package maslosoft/addendum-i18n-extractor
 * @license BSD-3-Clause
 *
 * @copyright Copyright (c) Peter Maselkowski <peter@maslosoft.com>
 * @link https://maslosoft.com/
 */

namespace Maslosoft\AddendumI18NExtractor\Application\Commands;

use Maslosoft\Addendum\Interfaces\AnnotatedInterface;
use Maslosoft\AddendumI18NExtractor\DirectoryExtractor;
use Maslosoft\Sitcom\Command;
use Symfony\Component\Console\Command\Command as ConsoleCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ExtractCommand extends ConsoleCommand implements AnnotatedInterface
{

	protected function configure(): void
	{
		$this->setName("extract");
		$this->setDescription("Extract i18n data from annotations");
		$this->setDefinition([
		]);

		$help = <<<EOT
The <info>extract</info> command will scan sources and extract i18n strings from annotations.
EOT;
		$this->setHelp($help);
	}

	protected function execute(InputInterface $input, OutputInterface $output): int
	{
		(new DirectoryExtractor)->extract();
		return 1;
	}

	/**
	 * @SlotFor(Command)
	 * @param Command $signal
	 */
	public function reactOn(Command $signal): void
	{
		$signal->add($this, 'i18n-extractor');
	}

}

<?php

namespace Maslosoft\AddendumI18NExtractor\Application\Commands;

use Maslosoft\Addendum\Interfaces\AnnotatedInterface;
use Maslosoft\AddendumI18NExtractor\DirectoryExtractor;
use Maslosoft\Sitcom\Command;
use Symfony\Component\Console\Command\Command as ConsoleCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ExtractCommand extends ConsoleCommand implements AnnotatedInterface
{

	protected function configure()
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

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		(new DirectoryExtractor)->extract();
	}

	/**
	 * @SlotFor(Command)
	 * @param Command $signal
	 */
	public function reactOn(Command $signal)
	{
		$signal->add($this, 'i18n-extractor');
	}

}

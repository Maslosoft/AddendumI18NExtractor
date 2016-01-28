<?php

namespace Maslosoft\AddendumI18NExtractor\Application\Commands;

use Maslosoft\AddendumI18NExtractor\DirectoryContextFiller;
use Maslosoft\Sitcom\Command;
use Symfony\Component\Console\Command\Command as ConsoleCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FillContextCommand extends ConsoleCommand
{

	protected function configure()
	{
		$this->setName("fill-context");
		$this->setDescription("Fill empty context in sources");
		$this->setDefinition([
		]);

		$help = <<<EOT
The <info>fill-context</info> command will scan sources and fill empty translation functions context.
EOT;
		$this->setHelp($help);
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		(new DirectoryContextFiller)->fill();
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

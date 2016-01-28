<?php

namespace Maslosoft\AddendumI18NExtractor\Application\Commands;

use Maslosoft\AddendumI18NExtractor\ReceivingExtractor;
use Maslosoft\Sitcom\Command;
use Symfony\Component\Console\Command\Command as ConsoleCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SignalExtractCommand extends ConsoleCommand
{

	protected function configure()
	{
		$this->setName("signal-extract");
		$this->setDescription("Extract i18n data from annotations via signals");
		$this->setDefinition([
		]);

		$help = <<<EOT
The <info>signal-extract</info> command send signal to collect i18n data and extract i18n strings from annotations.
EOT;
		$this->setHelp($help);
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		(new ReceivingExtractor)->extract();
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

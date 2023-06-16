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

namespace Maslosoft\AddendumI18NExtractor\Application;

use Maslosoft\AddendumI18NExtractor\Application\Commands\ExtractCommand;
use Maslosoft\AddendumI18NExtractor\Application\Commands\FillContextCommand;
use Maslosoft\AddendumI18NExtractor\Application\Commands\SignalExtractCommand;
use Symfony\Component\Console\Application as ConsoleApplication;
use Symfony\Component\Console\Command\Command;

/**
 * Application
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class Application extends ConsoleApplication
{

	/**
	 * Logo
	 * font: slant
	 */
	public const Logo = <<<LOGO
    ___________  _   __   ______     __                  __
   /  _<  ( __ )/ | / /  / ____/  __/ /__________ ______/ /_____  _____
   / / / / __  /  |/ /  / __/ | |/_/ __/ ___/ __ `/ ___/ __/ __ \/ ___/
 _/ / / / /_/ / /|  /  / /____>  </ /_/ /  / /_/ / /__/ /_/ /_/ / /
/___//_/\____/_/ |_/  /_____/_/|_|\__/_/   \__,_/\___/\__/\____/_/

LOGO;

	public function __construct()
	{
		parent::__construct('Addendum I18N Extractor', require __DIR__ . '/../version.php');
	}

	public function getHelp(): string
	{
		return self::Logo . parent::getHelp();
	}

	/**
	 * Gets the default commands that should always be available.
	 *
	 * @return Command[] An array of default Command instances
	 */
	public function getDefaultCommands(): array
	{
		$commands = parent::getDefaultCommands();

		$commands[] = new ExtractCommand();
		$commands[] = new SignalExtractCommand();
		$commands[] = new FillContextCommand();

		return $commands;
	}

}

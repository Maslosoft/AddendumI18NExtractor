<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Maslosoft\AddendumI18NExtractor;

use Maslosoft\AddendumI18NExtractor\Helpers\Context;
use Maslosoft\AddendumI18NExtractor\Helpers\FileWalker;
use Maslosoft\AddendumI18NExtractor\Interfaces\FillerInterface;
use Maslosoft\Whitelist\Tokenizer\Tokenizer;

/**
 * ContextFiller
 *
 * @author Piotr Maselkowski <pmaselkowski at gmail.com>
 */
class ContextFiller implements FillerInterface
{

	private $searchPaths = [];

	public function fill($searchPaths = [])
	{
		$this->searchPaths = $searchPaths;

		FileWalker::scan([$this, 'walk'], $this->searchPaths);
	}

	public function walk($file, $content)
	{
		$context = Context::create($file, $this->searchPaths);
		$tokenizer = new Tokenizer($content);
		$functions = $tokenizer->getFunctions();
		if (empty($functions))
		{
			return;
		}

		// Translation function names are keys
		// Context param position is value (index starting at 0)
		$txFunctions = [
			'tx' => 1,
			'txp' => 2,
			'ntx' => 2,
			'ntxp' => 3
		];
		$txCalls = [];
		foreach ($functions as $function)
		{
			if (in_array($function->value, array_keys($txFunctions)))
			{
				$txCalls[] = $function;
			}
		}
		if (empty($txCalls))
		{
			return;
		}
		$lines = file($file);
		foreach ($txCalls as $txCall)
		{
			$line = trim($lines[$txCall->line - 1]);

			// Skip opening `(` and get next value, presumably string with message
			$msgToken = $txCall->next()->next();
			if ($txCall->not(T_STRING))
			{
				// TODO Log
				echo "IN: $file, $txCall->line" . PHP_EOL;
				echo "NOT STRING TX CALL: $line " . PHP_EOL;
				continue;
			}

			// Get context position
			$ctxPos = $txFunctions[$txCall->value] + 1;

			// Skip opening brace and message
			$ctxToken = $txCall->next()->next();
			for ($i = 0; $i < $ctxPos; $i++)
			{
				// Skip one value and comma for each position
				$ctxToken = $ctxToken->next();
			}

			// Next one is context
//			$ctxToken = $ctxToken->next();
			$msg = $msgToken->value;
			$ctx = $ctxToken->value;


			// TODO Walk around arrays... See Tokenizer class for exampe with array tokens


			if ($ctxToken->is(T_ENCAPSED_AND_WHITESPACE))
			{
//				echo 'CTXE: ' . $ctx . PHP_EOL;
				continue;
			}
			if ($ctxToken->is(T_CONSTANT_ENCAPSED_STRING))
			{
//				echo 'CTXC: ' . $ctx . PHP_EOL;
				continue;
			}
			echo "IN : $file, $txCall->line" . PHP_EOL;
			echo 'MSG: ' . $msg . PHP_EOL;
//			echo 'CTX: ' . $ctx . PHP_EOL;
//			echo $line . PHP_EOL;
		}
	}

}

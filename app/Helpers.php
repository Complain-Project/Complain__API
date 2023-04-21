<?php

use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Output\ConsoleOutput;

if (!function_exists("service_path")) {
	function service_path(): string
	{
		return app_path() . "\Services";
	}
}

if (!function_exists("console_output")) {
	function console_output($message = "", $type = null): void
	{
		$output = new ConsoleOutput();

		switch($type) {
			case "error":
				$style = new OutputFormatterStyle("white", "red", ['bold']);
				$output->getFormatter()->setStyle("error", $style);
				$output->writeln("\n<error> Error </error> \n\n $message");

				break;

			case "success":
				$style = new OutputFormatterStyle("green", null, ['bold']);
				$output->getFormatter()->setStyle("success", $style);
				$output->writeln("\n<success> $message </success>");

				break;
			default:
		}

	}
}
<?php

use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Output\ConsoleOutput;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

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

if (!function_exists('getActiveMenuClass')) {
    function getActiveMenuClass($routeName): string
    {
        if (is_array($routeName)) {
            return in_array(Route::currentRouteName(), $routeName) ? 'active' : '';
        }
        return (Route::currentRouteName() === $routeName )? 'active' : '';
    }
}

if (!function_exists('createSlug')) {
    function createSlug($model, $title, $id) {
        $slug = Str::slug($title);

        $allSlugs = call_user_func(array($model, 'select'), 'slug')->where('slug', 'like', $slug . '%')
            ->where('_id', '<>', $id)
            ->get();

        if (!$allSlugs->contains('slug', $slug)) {
            return $slug;
        }

        for ($i = 1; $i <= 1000; $i++) {
            $newSlug = $slug . '-' . $i;
            if (!$allSlugs->contains('slug', $newSlug)) {
                return $newSlug;
            }
        }
    }
}

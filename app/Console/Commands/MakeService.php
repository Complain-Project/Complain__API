<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use File;
use Illuminate\Support\Stringable;

class MakeService extends Command
{
	protected string $path;
	protected bool $option;

	/**
	 * @var string
	 */
	protected $signature = "make:service {service} {--resource}";

	/**
	 * @var string
	 */
	protected $description = "Tạo cấu trúc file service";

	/**
	 * @return void
	 */
	public function handle(): void
	{
		$path = $this->argument("service");
		$this->path = preg_replace("/^\W+|\W+$/", "", $path);
		$this->option = $this->option("resource");

		$fullPath = $this->handlePath();
		$this->handleStoreFileService($fullPath);
	}

	/**
	 * @return string
	 */
	private function handlePath(): string
	{
		$directoryPath = Str::beforeLast($this->path, "/");
		$fileName = class_basename($this->path);

		return service_path() . "\\" . $directoryPath . "\\" . $fileName . ".php";
	}

	/**
	 * @param $path
	 *
	 * @return void
	 */
	private function handleStoreFileService($path): void
	{
		$exists = File::exists($path);

		if (!$exists) {
			$content = $this->handleContentFile();

			File::makeDirectory(
				service_path() . "/" . Str::beforeLast($this->path, "/"),
				0777, true, true
			);
			File::put($path, $content);
		} else {
			console_output("File đã tồn tại", "error");
		}
	}

	/**
	 * @return Stringable
	 */
	private function handleContentFile(): Stringable
	{
		$content = File::get(service_path() . "/Service.php");

		if (!$this->option) {
			$firstIndex = strpos($content, "{");
			$lastIndex = strrpos($content, "}");
			$useFacade = Str::of($content)->between("App\Services;\r\n", "\r\nclass");

			$content = Str::of($content)->substrReplace(
				"\n\t\n",
				$firstIndex + 1,
				$lastIndex - $firstIndex - 1
			)->replace($useFacade, "");
		}

		$directoryPath = Str::beforeLast($this->path, "/");
		$directoryPath = Str::of($directoryPath)->replace("/", "\\");

		return Str::of($content)->replace(
			"App\Services",
			"App\Services\\" . $directoryPath
		)->replace(
			"class Service",
			"class " . class_basename($this->path)
		);
	}
}

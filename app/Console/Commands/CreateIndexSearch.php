<?php

namespace App\Console\Commands;

use App\Models\Admins\Employee;
use App\Models\Admins\Role;
use Illuminate\Console\Command;

class CreateIndexSearch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "create:index-search";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Tạo index cho các bảng hỗ trợ tìm kiến toàn văn (full-text)";

	/**
	 * @return void
	 */
    public function handle(): void
    {
	    Employee::query()->raw()->createIndex(["keyword" => "text"]);
	    Role::query()->raw()->createIndex(["name" => "text"]);
    }
}

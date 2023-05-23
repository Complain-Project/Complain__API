<?php

namespace Database\Seeders\Admins;

use App\Models\Admins\PostCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        self::updateOrCreate([
            "name" => "Pháp luật",
            "slug" => "phap-luat",
        ]);
        self::updateOrCreate([
            "name" => "Đời sống",
            "slug" => "doi-song",
        ]);
        self::updateOrCreate([
            "name" => "Đất đai",
            "slug" => "dat-dai",
        ]);
    }

    /**
     * @param $data
     * @return void
     */
    public function updateOrCreate($data): void
    {
        PostCategory::query()->updateOrCreate(
            [
                "name" => $data["name"]
            ],
            [
                "name"          => $data["name"],
                "slug"          => $data["slug"],
            ]
        );
    }
}

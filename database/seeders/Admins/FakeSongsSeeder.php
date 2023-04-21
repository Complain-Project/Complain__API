<?php

namespace Database\Seeders\Admins;

use App\Models\Admins\Song;
use App\Models\Clients\User;
use Illuminate\Database\Seeder;

class FakeSongsSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        //Fake Artist
        $user = new User();
        $user->code = "USER1";
        $user->name = "Anh tu";
        $user->email = "gm@gm.cm";
        $user->save();
        //Fake Songs
        $songs = [
            [
                "name" => "Lạc trôi",
                "status" => 1,
                "lyrics" => "Lạc",
                "slug" => "lac-troi",
                "code" => "LACTROI",
                "author" => $user->_id,
                "singer_ids" => $user->_id,
                "creator_id" => $user->_id,
                "music_genres_ids" => "",
                "nation_id" => "",
                "duration" => 123,
                "release_date" => "",
                "playlist_ids" => "",
                "path" => "http://surl.li/glasu"
            ],
            [
                "name" => "Dont' Côi",
                "status" => 1,
                "lyrics" => "DONT",
                "slug" => "Dont Coi",
                "code" => "DONCOI",
                "author" => $user->_id,
                "singer_ids" => $user->_id,
                "creator_id" => $user->_id,
                "music_genres_ids" => "",
                "nation_id" => "",
                "duration" => 123,
                "release_date" => "",
                "playlist_ids" => "",
                "path" => "http://surl.li/glasu"
            ],
        ];
        foreach ($songs as $song){
            Song::create([
                "name" => $song["name"],
                "status" => $song["status"],
                "lyrics" => $song["lyrics"],
                "slug" => $song["slug"],
                "code" => $song["code"],
                "author" => $song["author"],
                "singer_ids" => $song["singer_ids"],
                "creator_id" => $song["creator_id"],
                "music_genres_ids" => $song["music_genres_ids"],
                "nation_id" => $song["nation_id"],
                "duration" => $song["duration"],
                "release_date" => $song["release_date"],
                "playlist_ids" => $song["playlist_ids"],
                "path" => $song["path"],
            ]);
        }
    }
}

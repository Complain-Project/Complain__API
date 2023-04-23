<?php

namespace Database\Seeders\Admins;

use App\Models\Admins\District;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Database\Seeder;

class DistrictTableSeeder extends Seeder
{
	/**
	 * @return void
	 * @throws GuzzleException
	 */
    public function run(): void
    {
	    $client = new Client();
	    $crawlKeywordUri = "https://provinces.open-api.vn";
	    $uri = $crawlKeywordUri . '/api/?depth=2';

	    $responseDistrict = $client->request('GET', $uri);

	    if ($responseDistrict->getStatusCode() == 200) {
		    $response = json_decode($responseDistrict->getBody()->getContents(), true);

		    $data = collect($response)->first(function ($value) {
			    return $value["code"] === 38;
		    });

		    if ($data) {
			    foreach ($data["districts"] as $district) {
				    District::query()->updateOrCreate(
					    [
						    "code" => strval($district["code"])
					    ],
					    [
						    "code" => strval($district["code"]),
						    "name" => $district["name"]
					    ]
				    );
			    }
		    }
	    }
    }
}

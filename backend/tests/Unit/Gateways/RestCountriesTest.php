<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Gateways\RestCountries;

class RestCountriesTest extends TestCase
{
    private const NR_OF_FLAGS = 250;

    /**
     * A basic test RestCountries.
     *
     * @return void
     */
    public function test_getData()
    {
        $gw = new RestCountries();
        $data = $gw->getData();
        $this->assertCount(self::NR_OF_FLAGS, $data, 'Number of flags should be '.self::NR_OF_FLAGS);
        foreach ($data as $item) {
            $this->assertNotEmpty($item['name'],'name must not empty');
            $this->assertNotEmpty($item['flag'],'flag must not empty');
        }
    }
}

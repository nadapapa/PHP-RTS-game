<?php

use App\User;

class UserTest extends TestCase
{

    /**
     * Test
     *
     * @return void
     */
    public function testUserHasCity()
    {
        /** @var User $user */
        $user = User::where('id', 1)->first();
        /** @var \Illuminate\Support\Collection $cities */
        $cities = $user->cities;

        $this->assertInstanceOf('\Illuminate\Support\Collection', $cities);
    }



}
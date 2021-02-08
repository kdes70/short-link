<?php

namespace Tests\Unit;

use App\Models\ShortLink\ShortLink;
use App\Models\User;
use Tests\TestCase;

class ShortLinkTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreateUniqueCode()
    {
        $code = '11111111';

        $user = User::factory()->create();
        $link = 'https://www.youtube.com';

        ShortLink::factory([
            'code' => $code
        ])->create();

        $newLink = ShortLink::create([
            'user_id' => $user->id,
            'link'    => $link,
            'code'    => $code
        ]);

        $this->assertTrue($newLink->code !== $code);
        $this->assertEquals($newLink->link, $link);
    }

    public function testSaveUniqueCode()
    {
        $code = '11111111';

        $user = User::factory()->create();
        $link = 'https://www.youtube.com';

        ShortLink::factory([
            'code' => $code
        ])->create();

        $newLink = new ShortLink;
        $newLink->user_id = $user->id;
        $newLink->link = $link;
        $newLink->code = $code;
        $newLink->save();

        $this->assertTrue($newLink->code !== $code);
        $this->assertEquals($newLink->link, $link);
    }

    public function testSaveUniqueNotCode()
    {
        $code = '11111111';

        $user = User::factory()->create();
        $link = 'https://www.youtube.com';

        ShortLink::factory([
            'code' => $code
        ])->create();

        $newLink = new ShortLink;
        $newLink->user_id = $user->id;
        $newLink->link = $link;
        $newLink->save();

        $this->assertTrue($newLink->code !== $code);
        $this->assertEquals($newLink->link, $link);
    }
}

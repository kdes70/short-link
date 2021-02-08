<?php

namespace Tests\Feature;

use App\Models\ShortLink\ShortLink;
use App\Models\User;
use Illuminate\Http\Response;
use Tests\TestCase;

class ShortLinkControllerTest extends TestCase
{
    public $structure = [
        'id',
        'user_id',
        'link',
        'code',
        'created_at',
        'updated_at',
    ];

    public function testShortLinkUnauthorized()
    {
        $this->getJson(route('short-link.index'))->assertUnauthorized();
        $this->postJson(route('short-link.store'))->assertUnauthorized();
        $this->getJson(route('short-link.show', ShortLink::factory()->create()))->assertUnauthorized();
    }

    public function testGetListSuccess()
    {
        $user = User::factory()
            ->has(ShortLink::factory()->count(3), 'links')
            ->create();

        $this->actingAs($user)
            ->getJson(route('short-link.index'))
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'data' => [$this->structure],
            ]);

        $this->assertEquals(3, $user->links->count());
    }

    public function testStorageLinkSuccess()
    {
        $user = User::factory()->create();

        $link = 'https://www.youtube.com';

        $this->actingAs($user)
            ->postJson(route('short-link.store'), ['link' => $link])
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure([
                'data' => $this->structure,
            ]);

        $this->assertDatabaseHas((new ShortLink)->getTable(), [
            'link' => $link
        ]);
    }

    public function testStorageLinkNotValid()
    {
        $user = User::factory()->create();

        $link = 'www.youtube.com';

        $this->actingAs($user)
            ->postJson(route('short-link.store'), ['link' => $link])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'link',
                ]
            ]);
    }

    public function testShowShortLink()
    {
        /** @var User $user */
        $user = User::factory()
            ->has(ShortLink::factory(), 'links')
            ->create();

        $this->actingAs($user)
            ->getJson(route('short-link.show', $user->links()->first()))
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'data' => array_merge($this->structure, ['visits']),
            ]);
    }

    public function testShowShortLinkNotAuthor()
    {
        /** @var User $user */
        $user = User::factory()->create();

        $link = ShortLink::factory()->create();

        $this->actingAs($user)
            ->getJson(route('short-link.show', $link))
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function testUpdateShortLink()
    {
        /** @var User $user */
        $user = User::factory()
            ->has(ShortLink::factory(), 'links')
            ->create();

        $link = 'https://www.google.ru';

        $this->actingAs($user)
            ->putJson(route('short-link.update', $user->links()->first()), ['link' => $link])
            ->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseHas((new ShortLink)->getTable(), [
            'link' => $link
        ]);
    }

    public function testUpdateShortLinkNotAuthor()
    {
        /** @var User $user */
        $user = User::factory()->create();

        $link = ShortLink::factory()->create();

        $this->actingAs($user)
            ->getJson(route('short-link.show', $link), ['link' => 'https://www.google.ru'])
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function testDeleteShortLink()
    {
        $user = User::factory()
            ->has(ShortLink::factory(), 'links')
            ->create();

        $this->actingAs($user)
            ->deleteJson(route('short-link.destroy', $user->links()->first()))
            ->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseCount((new ShortLink)->getTable(), 0);
    }

    public function testDeleteShortLinkNotAuthor()
    {
        /** @var User $user */
        $user = User::factory()->create();

        $link = ShortLink::factory()->create();

        $this->actingAs($user)
            ->deleteJson(route('short-link.destroy', $link))
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }
}

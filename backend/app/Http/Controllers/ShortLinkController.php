<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShortLinkRequest;
use App\Http\Resources\ShortLinkResource;
use App\Models\ShortLink\ShortLink;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ShortLinkController extends Controller
{
    /**
     * Create a new ShortLinkController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
        $this->middleware('can:author,short_link')->only(['show', 'update', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        /** @var User $user */
        $user = auth()->user();

        $links = $user->links()->withCount('visits')->paginate(5);

        return ShortLinkResource::collection($links);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ShortLinkRequest $request
     * @return ShortLinkResource
     */
    public function store(ShortLinkRequest $request)
    {
        $user = auth()->user();

        $link = ShortLink::create([
            'user_id' => $user->id,
            'link'    => $request->link,
            'state'   => $request->state,
        ]);

        return new ShortLinkResource($link);
    }

    /**
     * Display the specified resource.
     *
     * @param ShortLink $shortLink
     * @return ShortLinkResource
     */
    public function show(ShortLink $shortLink)
    {
        $shortLink->load('visits');

        return new ShortLinkResource($shortLink);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ShortLinkRequest $request
     * @param ShortLink $shortLink
     * @return ShortLinkResource
     */
    public function update(ShortLinkRequest $request, ShortLink $shortLink)
    {
        $shortLink->link = $request->link;
        $shortLink->state = $request->state;
        $shortLink->save();

        return new ShortLinkResource($shortLink);
    }

    /**
     * @param Request $request
     * @param string $code
     * @return ?string
     */
    public function visit(Request $request, string $code): ?string
    {
        $shortLink = ShortLink::whereCode($code)->whereState(ShortLink::STATE_ACTIVE)->first();

        if ($shortLink) {
            $shortLink->visits()->create([
                'referer' => $request->referrer,
                'ip'      => $request->ip,
            ]);

            return $shortLink->link;
        }

        return null;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ShortLink $shortLink
     * @return void
     * @throws \Exception
     */
    public function destroy(ShortLink $shortLink)
    {
        $shortLink->delete();
    }
}

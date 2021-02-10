<?php

namespace App\Http\Resources;

use App\Models\ShortLink\ShortLink;
use Illuminate\Http\Resources\Json\JsonResource;

class ShortLinkResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $model = $this->resource;

        if (empty($model) || !($model instanceof ShortLink)) {
            return null;
        }

        $data = [
            'id'           => $model->id,
            'user_id'      => $model->user_id,
            'link'         => $model->link,
            'code'         => $model->code,
            'state'        => $model->state,
            'visits_count' => (isset($model->visits_count)) ? $model->visits_count : 0,
            'created_at'   => $model->created_at,
            'updated_at'   => $model->updated_at,
        ];

        if ($model->relationLoaded('visits')) {
            $data['visits'] = VisitResource::collection($model->visits);
        }

        return $data;
    }
}

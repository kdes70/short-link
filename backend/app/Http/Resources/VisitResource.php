<?php

namespace App\Http\Resources;

use App\Models\Visit;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class VisitResource
 */
class VisitResource extends JsonResource
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

        if (empty($model) || !($model instanceof Visit)) {
            return null;
        }

        return [
            'id'      => $model->id,
            'referer' => $model->referer,
            'ip'      => $model->ip,
        ];
    }
}

<?php

namespace App\Modules\Ulises\Product\Transformers;

use App\Modules\Base\Transformers\BaseTransformer;
use App\Modules\Ulises\Product\Domain\ComplementTaxon as ComplementTaxonModel;

class ComplementTaxonSummary extends BaseTransformer
{
    /**
     * The resource instance.
     *
     * @var mixed|ComplementTaxonModel
     */
    public $resource;

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'description' => $this->description,
            'short_description' => $this->short_description,
            'creator_id' => $this->creator->id,
            'order' => $this->order,
        ];
    }
}

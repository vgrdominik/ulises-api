<?php

namespace App\Modules\Ulises\Product\Transformers;

use App\Modules\Base\Transformers\BaseTransformer;
use App\Modules\Ulises\Product\Domain\Complement as ComplementModel;

class ComplementSummary extends BaseTransformer
{
    /**
     * The resource instance.
     *
     * @var mixed|ComplementModel
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
            'details' => $this->details,
            'creator_id' => $this->creator->id,
            'complement_taxon_id' => $this->complement_taxon_id,
            'product_id' => $this->product_id,
            'complement_of_id' => $this->complement_of_id,
            'quantity_inventory' => $this->quantity_inventory,
            'retail_price' => $this->retail_price,
            'margin' => $this->margin,
            'include' => $this->include,
            'unique' => $this->unique,
            'by_default' => $this->by_default,
            'is_available' => $this->isAvailable(),
            'order' => $this->order,
        ];
    }
}

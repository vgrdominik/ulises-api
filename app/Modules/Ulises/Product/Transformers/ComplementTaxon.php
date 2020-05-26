<?php

namespace App\Modules\Ulises\Product\Transformers;

use App\Modules\Base\Transformers\BaseTransformer;
use App\Modules\Ulises\Product\Domain\ComplementTaxon as ComplementTaxonModel;

class ComplementTaxon extends BaseTransformer
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
            $this->merge(parent::toArray($request)),
            'creator' => new BaseTransformer($this->creator),
            'details' => $this->details,
            'order' => $this->order,
        ];
    }
}

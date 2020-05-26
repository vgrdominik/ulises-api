<?php

namespace App\Modules\Ulises\Taxon\Transformers;

use App\Modules\Base\Transformers\BaseTransformer;
use App\Modules\Ulises\Taxon\Domain\Taxon as TaxonModel;

class Taxon extends BaseTransformer
{
    /**
     * The resource instance.
     *
     * @var mixed|TaxonModel
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
            'details' => $this->details,
            'creator' => new BaseTransformer($this->creator),
            'channel' => new BaseTransformer($this->channel),
            'is_available' => $this->isAvailable(),
            'photo' => $this->photo,
            'parent_taxon' => new BaseTransformer($this->parentTaxon),
            'order' => $this->order,
        ];
    }
}

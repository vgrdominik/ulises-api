<?php

namespace App\Modules\Ulises\Taxon\Transformers;

use App\Modules\Base\Transformers\BaseTransformer;
use App\Modules\Ulises\Taxon\Domain\Taxon as TaxonModel;

class TaxonSummary extends BaseTransformer
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
            'id' => $this->id,
            'description' => $this->description,
            'creator_id' => $this->creator_id,
            'is_available' => $this->isAvailable(),
            'photo' => $this->photo,
            'parent_taxon' => $this->parent_taxon_id,
            'order' => $this->order,
        ];
    }
}

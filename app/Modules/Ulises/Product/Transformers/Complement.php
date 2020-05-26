<?php

namespace App\Modules\Ulises\Product\Transformers;

use App\Modules\Base\Transformers\BaseTransformer;
use App\Modules\Ulises\Product\Domain\Complement as ComplementModel;

class Complement extends BaseTransformer
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
            $this->merge(parent::toArray($request)),
            'creator' => new BaseTransformer($this->creator),
            'product' => new BaseTransformer($this->product),
            'complement_of' => new BaseTransformer($this->complementOf),
            'details' => $this->details,
            'quantity_inventory' => $this->quantity_inventory,
            'retail_price' => $this->retail_price,
            'margin' => $this->margin,
            'include' => $this->send,
            'unique' => $this->send,
            'by_default' => $this->send,
            'is_available' => $this->isAvailable(),
            'order' => $this->order,
        ];
    }
}

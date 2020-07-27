<?php

namespace App\Modules\Ulises\Vendor\Transformers;

use App\Modules\Base\Transformers\BaseTransformer;
use App\Modules\Ulises\Vendor\Domain\Vendor as VendorModel;

class VendorSummary extends BaseTransformer
{
    /**
     * The resource instance.
     *
     * @var mixed|VendorModel
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
            'creator_id' => $this->creator->id,
            'details' => $this->details,
            'nif' => $this->nif,
            'address' => $this->address,
            'postal_code' => $this->postal_code,
            'city' => $this->city,
            'province' => $this->province,
            'mobile' => $this->mobile,
            'email' => $this->email,
            'default_rate' => $this->default_rate,
            'type' => $this->type,
        ];
    }
}

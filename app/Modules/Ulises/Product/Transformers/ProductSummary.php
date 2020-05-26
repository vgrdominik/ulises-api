<?php

namespace App\Modules\Ulises\Product\Transformers;

use App\Modules\Base\Transformers\BaseTransformer;
use App\Modules\Ulises\Product\Domain\Product as ProductModel;

class ProductSummary extends BaseTransformer
{
    /**
     * The resource instance.
     *
     * @var mixed|ProductModel
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
        $complements = [];
        foreach ($this->complements as $complement) {
            $complements[] = new ComplementSummary($complement);
        }
        $asComplement = [];
        foreach ($this->asComplements as $asComplement) {
            $asComplement[] = new ComplementSummary($asComplement);
        }
        return [
            'id' => $this->id,
            'description' => $this->description,
            'short_description' => $this->short_description,
            'creator_id' => $this->creator->id,
            'vendor_id' => $this->vendor->id,
            'complements' => $complements,
            'as_complement' => $asComplement,
            'barcode' => $this->barcode,
            'sku' => $this->sku,
            'iva' => $this->iva,
            'inventory' => $this->inventory,
            'quantity_inventory' => $this->quantity_inventory,
            'photo' => $this->photo,
            'retail_price' => $this->retail_price,
            'retail_price2' => $this->retail_price2,
            'retail_price3' => $this->retail_price3,
            'retail_price4' => $this->retail_price4,
            'handling_fee' => $this->handling_fee,
            'product_cost' => $this->product_cost,
            'margin' => $this->margin,
            'compulsory_complements' => $this->compulsory_complements,
            'send' => $this->send,
            'is_available' => $this->isAvailable(),
            'order' => $this->order,
        ];
    }
}

<?php


namespace App\Modules\Ulises\Product\Infrastructure\Controller;

use App\Modules\Base\Infrastructure\Controller\ResourceController;
use App\Modules\Ulises\Product\Transformers\ProductSummary;
use Illuminate\Http\JsonResponse;

class Api extends ResourceController
{
    protected function getModelName(): string
    {
        return 'Ulises\\Product';
    }

    /**
     * Display a listing of summary resource.
     *
     * @return JsonResponse
     */
    public function productSummary()
    {
        return response()->json(ProductSummary::collection(($this->getModelClass())::available()->ordered()->get()));
    }
}

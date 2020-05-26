<?php


namespace App\Modules\Ulises\Product\Infrastructure\Controller;

use App\Modules\Base\Infrastructure\Controller\ResourceController;
use App\Modules\Ulises\Product\Transformers\ComplementTaxonSummary;
use Illuminate\Http\JsonResponse;

class ApiComplementTaxon extends ResourceController
{
    protected function getModelName(): string
    {
        return 'Ulises\\ComplementTaxon';
    }

    /**
     * Display a listing of summary resource.
     *
     * @return JsonResponse
     */
    public function complementTaxonSummary()
    {
        return response()->json(ComplementTaxonSummary::collection(($this->getModelClass())::all()));
    }
}

<?php


namespace App\Modules\Ulises\Taxon\Infrastructure\Controller;

use App\Modules\Base\Infrastructure\Controller\ResourceController;
use App\Modules\Ulises\Taxon\Transformers\TaxonSummary;
use Illuminate\Http\JsonResponse;

class Api extends ResourceController
{
    protected function getModelName(): string
    {
        return 'Ulises\\Taxon';
    }

    /**
     * Display a listing of summary resource.
     *
     * @return JsonResponse
     */
    public function taxonSummary()
    {
        return response()->json(TaxonSummary::collection(($this->getModelClass())::all()));
    }
}

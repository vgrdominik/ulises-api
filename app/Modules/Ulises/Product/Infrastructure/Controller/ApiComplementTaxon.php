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

    protected function getModelClass(): string
    {
        $modelName = $this->getModelName();
        $lastModelName = explode('\\', $modelName);
        $lastModelName = array_pop($lastModelName);

        return '\\App\\Modules\\Ulises\\Product\\Domain\\' . $lastModelName;
    }

    protected function getTransformerClass(): string
    {
        $modelName = $this->getModelName();
        $lastModelName = explode('\\', $modelName);
        $lastModelName = array_pop($lastModelName);

        return '\\App\\Modules\\Ulises\\Product\\Transformers\\' . $lastModelName;
    }

    /**
     * Display a listing of summary resource.
     *
     * @return JsonResponse
     */
    public function complementTaxonSummary()
    {
        return response()->json(ComplementTaxonSummary::collection(($this->getModelClass())::ordered()->get()));
    }
}

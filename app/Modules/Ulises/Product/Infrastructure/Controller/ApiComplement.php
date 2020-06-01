<?php


namespace App\Modules\Ulises\Product\Infrastructure\Controller;

use App\Modules\Base\Infrastructure\Controller\ResourceController;
use App\Modules\Ulises\Product\Transformers\ComplementSummary;
use Illuminate\Http\JsonResponse;

class ApiComplement extends ResourceController
{
    protected function getModelName(): string
    {
        return 'Ulises\\Complement';
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
    public function complementSummary()
    {
        return response()->json(ComplementSummary::collection(($this->getModelClass())::available()->ordered()->get()));
    }
}

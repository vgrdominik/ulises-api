<?php


namespace App\Modules\Ulises\Taxon\Infrastructure\Controller;

use App\Modules\Base\Infrastructure\Controller\ResourceController;
use App\Modules\Ulises\Taxon\Transformers\TaxonSummary;
use App\Modules\User\Domain\User;
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
        /** @var User $user */
        $user = User::findOrFail(request()->get('account_id'));
        $this->setToCustomerDB($user);

        return response()->json(TaxonSummary::collection(($this->getModelClass())::available()->ordered()->get()));
    }
}

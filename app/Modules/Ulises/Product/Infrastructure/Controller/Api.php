<?php


namespace App\Modules\Ulises\Product\Infrastructure\Controller;

use App\Modules\Base\Infrastructure\Controller\ResourceController;
use App\Modules\Ulises\Product\Transformers\ProductSummary;
use App\Modules\User\Domain\User;
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
        /** @var User $user */
        $user = User::findOrFail(request()->get('account_id'));
        $this->setToCustomerDB($user);

        return response()->json(ProductSummary::collection(($this->getModelClass())::available()->ordered()->get()));
    }
}

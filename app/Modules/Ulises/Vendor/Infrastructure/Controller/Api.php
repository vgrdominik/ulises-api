<?php


namespace App\Modules\Ulises\Vendor\Infrastructure\Controller;

use App\Modules\Base\Infrastructure\Controller\ResourceController;
use App\Modules\Ulises\Vendor\Transformers\VendorSummary;
use App\Modules\User\Domain\User;
use Illuminate\Http\JsonResponse;

class Api extends ResourceController
{
    protected function getModelName(): string
    {
        return 'Ulises\\Vendor';
    }

    /**
     * Display a listing of summary resource.
     *
     * @return JsonResponse
     */
    public function vendorSummary()
    {
        /** @var User $user */
        $user = User::findOrFail(request()->get('account_id'));
        $this->setToCustomerDB($user);

        return response()->json(VendorSummary::collection(($this->getModelClass())::all()));
    }
}

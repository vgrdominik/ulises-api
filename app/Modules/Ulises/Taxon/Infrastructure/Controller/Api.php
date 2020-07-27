<?php


namespace App\Modules\Ulises\Taxon\Infrastructure\Controller;

use App\Modules\Base\Infrastructure\Controller\ResourceController;
use App\Modules\Ulises\Taxon\Domain\Taxon;
use App\Modules\Ulises\Taxon\Transformers\TaxonSummary;
use App\Modules\User\Domain\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class Api extends ResourceController
{
    protected function getModelName(): string
    {
        return 'Ulises\\Taxon';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        /** @var User $user */
        $user = Auth::user();
        $this->setToCustomerDB($user);

        /** @var Taxon $model */
        $model = ($this->getModelClass())::findOrFail($id);

        foreach ($model->taxons() as $taxon) {
            $taxon->remove();
        }

        return response()->json($model->remove());
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

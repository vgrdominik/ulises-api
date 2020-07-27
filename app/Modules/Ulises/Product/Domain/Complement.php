<?php
namespace App\Modules\Ulises\Product\Domain;

use App\Modules\Base\Domain\BaseDomain;
use App\Modules\Base\Traits\Availability;
use App\Modules\Base\Traits\AvailabilityInterface;
use App\Modules\Base\Traits\Sortable;
use App\Modules\Base\Traits\SortableInterface;

class Complement extends BaseDomain implements AvailabilityInterface, SortableInterface
{
    use Availability;
    use Sortable;

    const VALIDATION_COTNEXT = [
        'creator_id' => ['required', 'integer', 'exists:users,id'],
        'complement_taxon_id' => ['required', 'integer', 'exists:complement_taxons,id'],
        'product_id' => ['required', 'integer', 'exists:products,id'], // Product as complement
        'complement_of_id' => ['required', 'integer', 'exists:products,id'], // Complement of product
        'description' => ['required', 'string', 'min:4', 'max:255'],
        'details' => ['required', 'string', 'max:2000'],
        'retail_price' => ['required', 'numeric', 'between:-10000000.999,10000000.999'],
        'margin' => ['required', 'numeric', 'between:-10000000.999,10000000.999'],
        'quantity_inventory' => ['required', 'numeric', 'between:-10000000.999,10000000.999'],
        'include' => ['required', 'boolean'],
        'unique' => ['required', 'boolean'],
        'by_default' => ['required', 'boolean'],
        'is_available' => ['required', 'boolean'],
        'order' => ['required', 'string', 'max:25'],
    ];

    protected $fillable = [
        'description',
        'details',
        'retail_price',
        'margin',
        'quantity_inventory',
        'include',
        'unique',
        'by_default',
        'is_available',
        'complement_taxon_id',
        'product_id',
        'complement_of_id',
        'order',
        'creator_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    // RELATIONS

    public function creator()
    {
        return $this->belongsTo('App\Modules\User\Domain\User', 'creator_id');
    }

    public function complementTaxon()
    {
        return $this->belongsTo('App\Modules\Ulises\Product\Domain\ComplementTaxon', 'complement_taxon_id');
    }

    public function product()
    {
        return $this->belongsTo('App\Modules\Ulises\Product\Domain\Product', 'product_id');
    }

    public function complementOf()
    {
        return $this->belongsTo('App\Modules\Ulises\Product\Domain\Product', 'complement_of_id');
    }

    // GETTERS

    public function getValidationContext(): array
    {
        return self::VALIDATION_COTNEXT;
    }

    public function getIcon(): string
    {
        return 'cube';
    }

    // Others

    public function remove(): bool
    {
        return $this->delete();
    }
}

<?php
namespace App\Modules\Ulises\Product\Domain;

use App\Modules\Base\Domain\BaseDomain;
use App\Modules\Base\Traits\Photo;
use App\Modules\Base\Traits\Availability;
use App\Modules\Base\Traits\AvailabilityInterface;
use App\Modules\Base\Traits\PhotoInterface;
use App\Modules\Base\Traits\Sortable;
use App\Modules\Base\Traits\SortableInterface;

class Product extends BaseDomain implements AvailabilityInterface, SortableInterface, PhotoInterface
{
    use Availability;
    use Sortable;
    use Photo;

    const VALIDATION_COTNEXT = [
        'creator_id' => ['required', 'integer', 'exists:users,id'],
        'vendor_id' => ['required', 'integer', 'exists:vendors,id'],
        'taxon_id' => ['required', 'integer', 'exists:vendors,id'],
        'description' => ['required', 'string', 'min:4', 'max:255'],
        'short_description' => ['required', 'string', 'max:255'],
        'details' => ['required', 'string', 'max:2000'],
        'barcode' => ['required', 'string', 'max:255'],
        'sku' => ['required', 'string', 'max:255'],
        'photo' => ['required', 'string', 'max:255'],
        'retail_price' => ['required', 'numeric', 'between:-10000000.999,10000000.999'],
        'retail_price2' => ['required', 'numeric', 'between:-10000000.999,10000000.999'],
        'retail_price3' => ['required', 'numeric', 'between:-10000000.999,10000000.999'],
        'retail_price4' => ['required', 'numeric', 'between:-10000000.999,10000000.999'],
        'iva' => ['required', 'numeric', 'between:0,100'],
        'handling_fee' => ['required', 'numeric', 'between:-10000000.999,10000000.999'],
        'product_cost' => ['required', 'numeric', 'between:-10000000.999,10000000.999'],
        'margin' => ['required', 'numeric', 'between:-10000000.999,10000000.999'],
        'inventory' => ['required', 'boolean'],
        'quantity_inventory' => ['required', 'numeric', 'between:-10000000.999,10000000.999'],
        'compulsory_complements' => ['required', 'boolean'],
        'send' => ['required', 'boolean'],
        'is_available' => ['required', 'boolean'],
        'order' => ['required', 'string', 'max:25'],
    ];

    protected $fillable = [
        'description',
        'short_description',
        'details',
        'barcode',
        'sku',
        'photo',
        'retail_price',
        'retail_price2',
        'retail_price3',
        'retail_price4',
        'iva',
        'handling_fee',
        'product_cost',
        'margin',
        'inventory',
        'quantity_inventory',
        'compulsory_complements',
        'send',
        'is_available',
        'vendor_id',
        'taxon_id',
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

    public function vendor()
    {
        return $this->belongsTo('App\Modules\Ulises\Vendor\Domain\Vendor', 'vendor_id');
    }

    public function taxon()
    {
        return $this->belongsTo('App\Modules\Ulises\Taxon\Domain\Taxon', 'taxon_id');
    }

    public function asComplements() // Is complement of...
    {
        return $this->hasMany('App\Modules\Ulises\Product\Domain\Complement', 'product_id');
    }

    public function complements() // Has complements
    {
        return $this->hasMany('App\Modules\Ulises\Product\Domain\Complement', 'complement_of_id');
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

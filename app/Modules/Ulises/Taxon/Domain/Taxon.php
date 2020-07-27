<?php
namespace App\Modules\Ulises\Taxon\Domain;

use App\Modules\Base\Domain\BaseDomain;
use App\Modules\Base\Traits\Availability;
use App\Modules\Base\Traits\AvailabilityInterface;
use App\Modules\Base\Traits\Photo;
use App\Modules\Base\Traits\PhotoInterface;
use App\Modules\Base\Traits\Sortable;
use App\Modules\Base\Traits\SortableInterface;
use Illuminate\Validation\ValidationException;

class Taxon extends BaseDomain implements AvailabilityInterface, SortableInterface, PhotoInterface
{
    use Availability;
    use Sortable;
    use Photo;

    const VALIDATION_COTNEXT = [
        'creator_id' => ['required', 'integer', 'exists:users,id'],
        'description' => ['required', 'string', 'min:4', 'max:30'],
        'is_available' => ['required', 'boolean'],
        'parent_taxon_id' => ['nullable', 'integer', 'exists:taxons,id'],
        'order' => ['required', 'string', 'min:1', 'max:25'],
        'photo' => ['nullable', 'string', 'min:4', 'max:255'],
    ];

    protected $fillable = [
        'description',
        'is_available',
        'parent_taxon_id',
        'order',
        'photo',
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

    public function parentTaxon()
    {
        return $this->belongsTo('App\Modules\Ulises\Taxon\Domain\Taxon', 'parent_taxon_id');
    }

    public function taxons() // Has taxons
    {
        return $this->hasMany('App\Modules\Ulises\Taxon\Domain\Taxon', 'parent_taxon_id');
    }

    public function products() // Has products
    {
        return $this->hasMany('App\Modules\Ulises\Product\Domain\Product', 'taxon_id');
    }

    // Boot

    protected static function boot()
    {
        parent::boot();

        // Protect from relations.
        static::deleting(function($telco) {
            $relationMethods = ['products'];

            foreach ($relationMethods as $relationMethod) {
                if ($telco->$relationMethod()->count() > 0) {
                    throw ValidationException::withMessages([
                        $relationMethod => ['La categoría contiene ' . $relationMethod . ' por lo que no se puede eliminar.'],
                    ]);
                }
            }
        });
    }

    // GETTERS

    public function getValidationContext(): array
    {
        return self::VALIDATION_COTNEXT;
    }

    public function getIcon(): string
    {
        return 'user';
    }

    // Others

    public function remove(): bool
    {
        return $this->delete();
    }
}

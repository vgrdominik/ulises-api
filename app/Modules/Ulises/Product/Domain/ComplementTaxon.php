<?php
namespace App\Modules\Ulises\Product\Domain;

use App\Modules\Base\Domain\BaseDomain;
use App\Modules\Base\Traits\Sortable;
use App\Modules\Base\Traits\SortableInterface;
use Illuminate\Validation\ValidationException;

class ComplementTaxon extends BaseDomain implements SortableInterface
{
    use Sortable;

    const VALIDATION_COTNEXT = [
        'creator_id' => ['required', 'integer', 'exists:users,id'],
        'description' => ['required', 'string', 'min:4', 'max:255'],
        'details' => ['required', 'string', 'max:2000'],
        'order' => ['required', 'string', 'max:25'],
    ];

    protected $fillable = [
        'description',
        'details',
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

    public function complements() // Has products
    {
        return $this->hasMany('App\Modules\Ulises\Product\Domain\Complement', 'complement_taxon_id');
    }

    // Boot

    protected static function boot()
    {
        parent::boot();

        // Protect from relations.
        static::deleting(function($telco) {
            $relationMethods = ['complements'];

            foreach ($relationMethods as $relationMethod) {
                if ($telco->$relationMethod()->count() > 0) {
                    throw ValidationException::withMessages([
                        $relationMethod => ['El complemento contiene ' . $relationMethod . ' por lo que no se puede eliminar.'],
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
        return 'cube';
    }

    // Others

    public function remove(): bool
    {
        return $this->delete();
    }
}

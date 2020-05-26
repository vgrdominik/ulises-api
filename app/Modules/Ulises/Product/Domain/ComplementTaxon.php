<?php
namespace App\Modules\Ulises\Product\Domain;

use App\Modules\Base\Domain\BaseDomain;
use App\Modules\Base\Traits\Sortable;
use App\Modules\Base\Traits\SortableInterface;

class ComplementTaxon extends BaseDomain implements SortableInterface
{
    use Sortable;

    const VALIDATION_COTNEXT = [
        'creator_id' => ['required', 'integer', 'exists:users,id'],
        'description' => ['required', 'string', 'min:4', 'max:255'],
        'short_description' => ['required', 'string', 'max:255'],
        'details' => ['required', 'string', 'max:2000'],
        'order' => ['required', 'string', 'max:25'],
    ];

    protected $fillable = [
        'description',
        'short_description',
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

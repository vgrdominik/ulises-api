<?php
namespace App\Modules\Ulises\Taxon\Domain;

use App\Modules\Base\Domain\BaseDomain;
use App\Modules\Base\Traits\Availability;
use App\Modules\Base\Traits\AvailabilityInterface;
use App\Modules\Base\Traits\Photo;
use App\Modules\Base\Traits\PhotoInterface;
use App\Modules\Base\Traits\Sortable;
use App\Modules\Base\Traits\SortableInterface;

class Taxon extends BaseDomain implements AvailabilityInterface, SortableInterface, PhotoInterface
{
    use Availability;
    use Sortable;
    use Photo;

    const VALIDATION_COTNEXT = [
        'creator_id' => ['required', 'integer', 'exists:users,id'],
        'description' => ['required', 'string', 'min:4', 'max:255'],
        'short_description' => ['required', 'string', 'max:255'],
        'is_available' => ['required', 'boolean'],
        'details' => ['required', 'string', 'min:8', 'max:2000'],
        'channel_id' => ['required', 'integer', 'exists:channels,id'],
        'parent_taxon_id' => ['required', 'integer', 'exists:taxons,id'],
        'order' => ['required', 'string', 'min:1', 'max:25'],
        'photo' => ['required', 'string', 'min:4', 'max:255'],
    ];

    protected $fillable = [
        'description',
        'short_description',
        'details',
        'is_available',
        'channel_id',
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

    public function channel()
    {
        return $this->belongsTo('App\Modules\Ulises\Channel\Domain\Channel', 'channel_id');
    }

    public function parentTaxon()
    {
        return $this->belongsTo('App\Modules\Ulises\Taxon\Domain\Taxon', 'parent_taxon_id');
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

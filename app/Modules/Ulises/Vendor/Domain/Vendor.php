<?php
namespace App\Modules\Ulises\Vendor\Domain;

use App\Modules\Base\Domain\BaseDomain;

class Vendor extends BaseDomain
{
    const VALIDATION_COTNEXT = [
        'creator_id' => ['required', 'integer', 'exists:users,id'],
        'description' => ['required', 'string', 'min:4', 'max:255'],
        'short_description' => ['required', 'string', 'max:255'],
        'details' => ['required', 'string', 'max:2000'],
        'nif' => ['required', 'string', 'max:50'],
        'address' => ['required', 'string', 'max:255'],
        'postal_code' => ['required', 'string', 'max:25'],
        'city' => ['required', 'string', 'max:50'],
        'province' => ['required', 'string', 'max:50'],
        'mobile' => ['required', 'string', 'max:25'],
        'email' => ['required', 'string', 'max:50'],
        'password' => ['required', 'string', 'max:255'],
        'default_rate' => ['required', 'string', 'max:25'],
        'type' => ['required', 'string', 'max:255'],
        'token' => ['required', 'string', 'min:4', 'max:255'],
    ];

    protected $fillable = [
        'description',
        'short_description',
        'details',
        'nif',
        'address',
        'postal_code',
        'city',
        'province',
        'mobile',
        'email',
        'password',
        'default_rate',
        'type',
        'token',
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

    public function insideProducts()
    {
        return $this->hasMany('App\Modules\Ulises\Product\Domain\Product', 'vendor_id');
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

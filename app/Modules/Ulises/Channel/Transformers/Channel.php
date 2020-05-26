<?php

namespace App\Modules\Ulises\Channel\Transformers;

use App\Modules\Base\Transformers\BaseTransformer;
use App\Modules\Ulises\Channel\Domain\Channel as ChannelModel;

class Channel extends BaseTransformer
{
    /**
     * The resource instance.
     *
     * @var mixed|ChannelModel
     */
    public $resource;

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            $this->merge(parent::toArray($request)),
            'details' => $this->details,
            'creator' => new BaseTransformer($this->creator),
            'token' => $this->token,
        ];
    }
}

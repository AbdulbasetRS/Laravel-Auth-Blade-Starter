<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = parent::toArray($request);
        
        $data['avatar_url'] = \App\Helpers\PathHelper::userAvatarUrl($this->user_id, $this->avatar);
        $data['created_at'] = Carbon::parse($this->created_at)->format('Y-m-d H:i:s');
        $data['updated_at'] = Carbon::parse($this->updated_at)->format('Y-m-d H:i:s');

        return $data;
    }
}

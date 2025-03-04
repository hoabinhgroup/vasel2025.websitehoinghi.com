<?php

namespace Modules\Media\Http\Resources;

use File;
use Illuminate\Http\Resources\Json\JsonResource;
use LouisMedia;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;

class FileResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'basename'   => File::basename($this->url),
            'url'        => $this->url,
            'full_url'   => URL::asset(LouisMedia::url($this->url)),
            'type'       => $this->type,
            'icon'       => $this->icon,
            'thumb'      => $this->type == 'image' ? get_image_url($this->url, 'thumb') : null,
            'size'       => $this->human_size,
            'mime_type'  => $this->mime_type,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::parse($this->updated_at)->format('Y-m-d H:i:s'),
            'options'    => $this->options,
            'folder_id'  => $this->folder_id,
        ];
    }
}

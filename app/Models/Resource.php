<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'link_in_new_tab' => 'boolean',
    ];

    public function toArray()
    {
        return $this->only([
            'id',
            'link',
            'link_in_new_tab',
            'resource_type',
            'title',
            'snippet_description',
            'snippet_html',
            'file'
        ]);
    }

}

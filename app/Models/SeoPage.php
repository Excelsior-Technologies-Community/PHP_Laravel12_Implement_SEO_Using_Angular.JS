<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class SeoPage extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'slug',
        'title',
        'description',
        'keywords',
        'status'
    ];
}

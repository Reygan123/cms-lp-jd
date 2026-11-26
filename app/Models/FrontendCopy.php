<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FrontendCopy extends Model
{
    use Concerns\HasContentTranslations;

    protected $guarded = ['id'];
}

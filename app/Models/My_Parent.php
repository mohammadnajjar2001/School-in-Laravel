<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens; // ✅ أضف هذا
use Spatie\Translatable\HasTranslations;

class My_Parent extends Authenticatable
{
    use HasApiTokens; // ✅ أضف هذا
    use HasTranslations;

    public $translatable = ['Name_Father', 'Job_Father', 'Name_Mother', 'Job_Mother'];
    protected $table = 'my__parents';
    protected $guarded = [];
}


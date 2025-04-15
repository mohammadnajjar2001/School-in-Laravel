<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static get()
 */
class Question extends Model
{
    public function quizze()
    {
        return $this->belongsTo('App\Models\Quizze');
    }
}

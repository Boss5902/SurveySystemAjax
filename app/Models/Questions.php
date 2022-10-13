<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questions extends Model
{
    use HasFactory;

    protected $table='questions';
    protected $fillable = [
        'question',
        'type'
    ];
    public function answer(){
        return $this->hasMany(Answer::class,'question_id','id'); 
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkersMail extends Model
{
    use HasFactory;
    protected $table="mails";
    public function user(){
        return $this->belongsTo(User::class);
    }
}

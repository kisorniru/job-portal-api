<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobPost extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'job_title', 'job_description', 'salary', 'location', 'country', 'deadline'
    ];

    public function user()
    {
        $userDetails = $this->belongsTo('App\Models\User');
        
        return $userDetails;
    }
}

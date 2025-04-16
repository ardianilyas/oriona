<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectMember extends Model
{
    /** @use HasFactory<\Database\Factories\ProjectMemberFactory> */
    use HasFactory, HasUuids;
    
    protected $guarded = ['id'];
}

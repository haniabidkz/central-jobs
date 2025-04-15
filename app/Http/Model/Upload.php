<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'uploads';

    protected $fillable = ['name', 'uploads_type', 'user_id', 'description', 'location','org_name', 'created_at', 'updated_at', 'deleted_at', 'type_id', 'type', 'job_id'];
}

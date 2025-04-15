<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class BestAdvertisements extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'best_advertisements';

    protected $fillable = ['initial_text', 'position', 'requirment', 'ref_no', 'status', 'created_at', 'updated_at', 'deleted_at'];
    
}

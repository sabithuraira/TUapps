<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KnowledgeInfo extends Model
{
    protected $table = 'knowledge_info';

    protected $fillable = [
        'title',
        'content',
        'category',
        'tag',
        'created_by',
        'updated_by',
    ];

    /**
     * Get the user who created this record
     */
    public function createdBy()
    {
        return $this->belongsTo('App\UserModel', 'created_by', 'id');
    }

    /**
     * Get the user who last updated this record
     */
    public function updatedBy()
    {
        return $this->belongsTo('App\UserModel', 'updated_by', 'id');
    }
}

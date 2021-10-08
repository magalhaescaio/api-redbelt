<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncidentModel extends Model
{

    protected $table = 'incident';

   
    protected $fillable = [
        'title', 
        'description',
        'criticality', 
        'type', 
        'status'
    ];

    public function rules()
    {
        return [
            'title' => 'required|max:155',
            'description' => 'required|max:1000',
            'criticality' => 'required',
            'type' => 'required',
            'status' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Title is required', 
            'title.max' => 'Title exceeds the 155 character limit', 
            'description.required' => 'Description is required', 
            'description.max' => 'Description exceeds the 155 character limit', 
            'criticality.required' => 'Criticality is required', 
            'type.required' => 'Type is required', 
            'status.required' => 'Status is required', 
        ];
    }

}

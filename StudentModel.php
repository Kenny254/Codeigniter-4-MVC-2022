<?php

namespace App\Models;

use App\Models\BaseModel;

class StudentModel extends BaseModel
{
    protected $table      = 'students';
    protected $primaryKey = 'id';

    // protected $useAutoIncrement = true;

    protected $returnType     = 'object';
    // protected $useSoftDeletes = false;
    
    protected $allowedFields = ['applicant_name`', 'gender', 'dob', 'primary_school', 'county', 'religion', 'parents_income', 'parents_contacts', 'headmasters_contacts','chief_deo_religion','grade_4','grade_5','grade_6','missing_documents', 'reference_mode'];
    
    
    // protected $useTimestamps = true;
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';

    // protected $validationRules    = [];
    // protected $validationMessages = [];
    // protected $skipValidation     = false;
}


<?php

//invoked Libaraies
namespace App\Controllers;
use App\Controllers\AdminBaseController;
use App\Models\StudentModel;

 //Start of class
class students extends AdminBaseController //class name is lower case and is used in the lisp.php
{
    
  //Page title and Menu name
    public $title = 'Students Management';
    public $menu = 'students';
 
   //Ponits to students page
    public function index()
    {
        $this->permissionCheck('students_list');
        $viewInfo = (new StudentModel)->findAll();
        return view('admin/students/list', compact('viewInfo'));
    }
    
   //Ponits to students add page
    public function add()
	{
        $this->permissionCheck('students_add');
		return view('admin/students/add');
	}
	
	// Saves data collected from students add form
	public function save()
	{
        $this->permissionCheck('students_add');
		postAllowed();

		$id = (new StudentModel)->create([
			'applicant_name' => post('applicant_name'),
			'gender' => post('gender'),
			'dob' => post('dob'),
			'primary_school' => post('primary_school'),
			'county' => post('county'),
			'religion' => post('religion'),
			'parents_income' => post('parents_income'),
			'parents_contacts' => post('parents_contacts'),
			'headmasters_contacts' => post('headmasters_contacts'),
			'chief_deo_religion' => (int) post('chief_deo_religion'),
			'grade_4' => (int) post('grade_4'),
			'grade_5' => (int) post('grade_5'),
			'grade_6' => (int) post('grade_6'),
			'missing_documents' => post('missing_documents'),
			'reference_mode' => post('reference_mode'),
		]);


    //Uploads images
		if (!empty($_FILES['image']['applicant_name'])) {
			$img = $this->request->getFile('image');
			$ext = $img->getExtension();
			$upload = $img->move( FCPATH.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'students', $id.'.'.$ext, true );
			$data['img_type'] = $ext;
			if(!$upload){
				copy(FCPATH.'uploads/students/default.png', 'uploads/students/'.$id.'.png');
				$data['img_type'] = "png";
			}

			(new StudentModel)->update($id, ['img_type' => $ext]);
		}else{
			copy(FCPATH.'uploads/students/default.png', 'uploads/students/'.$id.'.png');

		}

		model('App\Models\ActivityLogModel')->add('New User $'.$id.' Created by User:'.logged('name'), logged('id'));
		
		return redirect()->to('students')->with('notifySuccess', 'New User Created Successfully');

       	}
	
	
	
	// Points to the students edit page
    	public function edit($id)
    	{

        $this->permissionCheck('students_edit');

		$editableData = (new StudentModel)->getById($id);
		return view('admin/students/edit', compact('editableData'));

	   }
	
	 
	
    // Facilitates students update
     	public function update($id)
    	{

        $this->permissionCheck('students_edit');
		postAllowed();

		$data = [
			'applicant_name' => post('applicant_name'),
			'gender' => post('gender'),
			'dob' => post('dob'),
			'primary_school' => post('primary_school'),
			'county' => post('county'),
			'religion' => post('religion'),
			'parents_income' => post('parents_income'),
			'parents_contacts' => post('parents_contacts'),
			'headmasters_contacts' => post('headmasters_contacts'),
			'chief_deo_religion' => (int) post('chief_deo_religion'),
			'grade_4' => (int) post('grade_4'),
			'grade_5' => (int) post('grade_5'),
			'grade_6' => (int) post('grade_6'),
			'missing_documents' => post('missing_documents'),
			'reference_mode' => post('reference_mode'),
		];
         
        //Inserts Hashed Password
      	//$password = post('password');
     	//if(logged('id')!=$id)
	    //$data['status'] = post('status')==1;
    	//if(!empty($password))
    	//$data['password'] = hash( "sha256", $password );


		$img = $this->request->getFile('image');
		
		if (!empty($_FILES['image']['name'])) {

			$ext = $img->getExtension();
			$upload = $img->move( FCPATH.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'students', $id.'.'.$ext, true );
			if(!$upload){
				return redirect()->back()->with('notifyError', 'Server Error Occured while Uploading Image !');
			}
			$data['img_type'] = $ext;

			$id = (new StudentModel)->update($id, $data);
		}else{
			$id = (new StudentModel)->update($id, $data);
		}

		model('App\Models\ActivityLogModel')->add("User #$id Updated by User:".logged('name'));
		
		return redirect()->to('students')->with('notifySuccess', 'New student Created Successfully');

    	}
	
	
	// Facilitates students view
    	public function view($id)
    	{

        $this->permissionCheck('students_view');
		$viewData = (new StudentModel)->getById($id);
		$viewData->activity = model('App\Models\ActivityLogModel')->getByWhere([
			'user'=> $id
		], [ 'order' => ['id', 'desc'] ]);

		return view('admin/students/view', compact('viewData'));

     	}


	// check if email exists
    	public function check()
    	{
		$applicant_name = !empty(get('applicant_name')) ? get('applicant_name') : false;
		$primary_school = !empty(get('primary_school')) ? get('primary_school') : false;
		$notId = !empty(get('notId')) ? get('notId') : 0;

		if($applicant_name)
			$exists = count((new StudentModel)->getByWhere([
					'applicant_name' => $applicant_name,
					'id !=' => $notId,
				])) > 0 ? true : false;

		if($primary_school)
			$exists = count((new StudentModel)->getByWhere([
					'primary_school' => $primary_school,
					'id !=' => $notId,
				])) > 0 ? true : false;

		echo $exists ? 'false' : 'true';
    	}
    	
    	
    // Facilitates deletion of rows
    	public function delete($id)
	{

        $this->permissionCheck('students_delete');

		if($id!==1 && $id!=logged('id')){ }else{
			return redirect()->to('students');
		}

		(new StudentModel)->delete($id);

		model('App\Models\ActivityLogModel')->add("User #$id Deleted by User:".logged('name'));
		
		return redirect()->to('students')->with('notifySuccess', 'User has been Deleted Successfully');

	}

}

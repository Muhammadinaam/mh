<?php namespace App\Http\Controllers;

	use Session;
	use Request;
	use DB;
	use CRUDBooster;

	class AdminOpdVisitsController extends \crocodicstudio\crudbooster\controllers\CBController {

	    public function cbInit() {

			# START CONFIGURATION DO NOT REMOVE THIS LINE
			$this->title_field = "patient_name";
			$this->limit = "20";
			$this->orderby = "id,desc";
			$this->global_privilege = false;
			$this->button_table_action = true;
			$this->button_bulk_action = true;
			$this->button_action_style = "button_icon";
			$this->button_add = true;
			$this->button_edit = true;
			$this->button_delete = true;
			$this->button_detail = false;
			$this->button_show = true;
			$this->button_filter = true;
			$this->button_import = false;
			$this->button_export = false;
			$this->table = "opd_visits";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];
			$this->col[] = ["label"=>"Doctor","name"=>"doctor_id","join"=>"doctors,name"];
			$this->col[] = ["label"=>"Visit Date","name"=>"visit_date"];
			$this->col[] = ["label"=>"Token Number","name"=>"token_number"];
			$this->col[] = ["label"=>"Patient Name","name"=>"patient_name"];
			$this->col[] = ["label"=>"Patient Age","name"=>"patient_age"];
			$this->col[] = ["label"=>"Doctor Fee","name"=>"doctor_fee"];
			$this->col[] = ["label"=>"Total Fee","name"=>"total_fee"];
			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
			$this->form = [];
			$this->form[] = ['label'=>'Visit Date','name'=>'visit_date','type'=>'date','validation'=>'required','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Doctor','name'=>'doctor_id','type'=>'select','validation'=>'required','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Token Number','name'=>'token_number','type'=>'number','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Doctor Fee','name'=>'doctor_fee','type'=>'number','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Patient Name','name'=>'patient_name','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Patient Age','name'=>'patient_age','type'=>'number','width'=>'col-sm-10','readonly'=>'true','validation'=>'numeric'];
			$this->form[] = ['label'=>'Blood Pressure','name'=>'patient_blood_pressure','type'=>'text','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Patient Temperature','name'=>'patient_temperature','type'=>'number','width'=>'col-sm-10'];
			# END FORM DO NOT REMOVE THIS LINE

			# OLD START FORM
			//$this->form = [];
			//$this->form[] = ['label'=>'Visit Date','name'=>'visit_date','type'=>'date','validation'=>'required','width'=>'col-sm-10','datatable'=>'doctors,name','datatable_where'=>'is_activated=1'];
			//$this->form[] = ['label'=>'Doctor Id','name'=>'doctor_id','type'=>'select','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Token Number','name'=>'token_number','type'=>'number','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Doctor Fee','name'=>'doctor_fee','type'=>'number','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Patient Name','name'=>'patient_name','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Patient Age','name'=>'patient_age','type'=>'number','width'=>'col-sm-10','readonly'=>'true'];
			//$this->form[] = ['label'=>'Blood Pressure','name'=>'patient_blood_pressure','type'=>'text','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Patient Temperature','name'=>'patient_temperature','type'=>'number','width'=>'col-sm-10'];
			# OLD END FORM

			/* 
	        | ---------------------------------------------------------------------- 
	        | Sub Module
	        | ----------------------------------------------------------------------     
			| @label          = Label of action 
			| @path           = Path of sub module
			| @foreign_key 	  = foreign key of sub table/module
			| @button_color   = Bootstrap Class (primary,success,warning,danger)
			| @button_icon    = Font Awesome Class  
			| @parent_columns = Sparate with comma, e.g : name,created_at
	        | 
	        */
	        $this->sub_module = array();


	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add More Action Button / Menu
	        | ----------------------------------------------------------------------     
	        | @label       = Label of action 
	        | @url         = Target URL, you can use field alias. e.g : [id], [name], [title], etc
	        | @icon        = Font awesome class icon. e.g : fa fa-bars
	        | @color 	   = Default is primary. (primary, warning, succecss, info)     
	        | @showIf 	   = If condition when action show. Use field alias. e.g : [id] == 1
	        | 
	        */
	        $this->addaction = array();


	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add More Button Selected
	        | ----------------------------------------------------------------------     
	        | @label       = Label of action 
	        | @icon 	   = Icon from fontawesome
	        | @name 	   = Name of button 
	        | Then about the action, you should code at actionButtonSelected method 
	        | 
	        */
	        $this->button_selected = array();

	                
	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add alert message to this module at overheader
	        | ----------------------------------------------------------------------     
	        | @message = Text of message 
	        | @type    = warning,success,danger,info        
	        | 
	        */
	        $this->alert        = array();
	                

	        
	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add more button to header button 
	        | ----------------------------------------------------------------------     
	        | @label = Name of button 
	        | @url   = URL Target
	        | @icon  = Icon from Awesome.
	        | 
	        */
	        $this->index_button = array();



	        /* 
	        | ---------------------------------------------------------------------- 
	        | Customize Table Row Color
	        | ----------------------------------------------------------------------     
	        | @condition = If condition. You may use field alias. E.g : [id] == 1
	        | @color = Default is none. You can use bootstrap success,info,warning,danger,primary.        
	        | 
	        */
	        $this->table_row_color = array();     	          

	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | You may use this bellow array to add statistic at dashboard 
	        | ---------------------------------------------------------------------- 
	        | @label, @count, @icon, @color 
	        |
	        */
	        $this->index_statistic = array();



	        /*
	        | ---------------------------------------------------------------------- 
	        | Add javascript at body 
	        | ---------------------------------------------------------------------- 
	        | javascript code in the variable 
	        | $this->script_js = "function() { ... }";
	        |
	        */
	        $this->script_js = NULL;


            /*
	        | ---------------------------------------------------------------------- 
	        | Include HTML Code before index table 
	        | ---------------------------------------------------------------------- 
	        | html code to display it before index table
	        | $this->pre_index_html = "<p>test</p>";
	        |
	        */
	        $this->pre_index_html = null;
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Include HTML Code after index table 
	        | ---------------------------------------------------------------------- 
	        | html code to display it after index table
	        | $this->post_index_html = "<p>test</p>";
	        |
	        */
	        $this->post_index_html = null;
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Include Javascript File 
	        | ---------------------------------------------------------------------- 
	        | URL of your javascript each array 
	        | $this->load_js[] = asset("myfile.js");
	        |
	        */
	        $this->load_js = array();
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Add css style at body 
	        | ---------------------------------------------------------------------- 
	        | css code in the variable 
	        | $this->style_css = ".style{....}";
	        |
	        */
	        $this->style_css = NULL;
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Include css File 
	        | ---------------------------------------------------------------------- 
	        | URL of your css each array 
	        | $this->load_css[] = asset("myfile.css");
	        |
	        */
	        $this->load_css = array();
	        
	        
	    }


	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for button selected
	    | ---------------------------------------------------------------------- 
	    | @id_selected = the id selected
	    | @button_name = the name of button
	    |
	    */
	    public function actionButtonSelected($id_selected,$button_name) {
	        //Your code here
	            
	    }


	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate query of index result 
	    | ---------------------------------------------------------------------- 
	    | @query = current sql query 
	    |
	    */
	    public function hook_query_index(&$query) {
	        //Your code here
	            
	    }

	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate row of index table html 
	    | ---------------------------------------------------------------------- 
	    |
	    */    
	    public function hook_row_index($column_index,&$column_value) {	        
	    	//Your code here
	    }

	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate data input before add data is execute
	    | ---------------------------------------------------------------------- 
	    | @arr
	    |
	    */
	    public function hook_before_add(&$postdata) {        
	        //Your code here

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after add public static function called 
	    | ---------------------------------------------------------------------- 
	    | @id = last insert id
	    | 
	    */
	    public function hook_after_add($id) {        
	        //Your code here

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate data input before update data is execute
	    | ---------------------------------------------------------------------- 
	    | @postdata = input post data 
	    | @id       = current id 
	    | 
	    */
	    public function hook_before_edit(&$postdata,$id) {        
	        //Your code here

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after edit public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	    public function hook_after_edit($id) {
	        //Your code here 

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command before delete public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	    public function hook_before_delete($id) {
	        //Your code here

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after delete public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	    public function hook_after_delete($id) {
	        //Your code here

	    }



	    //By the way, you can still create your own method in here... :) 

		public function getAdd() {
			//Create an Auth
			if(!CRUDBooster::isCreate() && $this->global_privilege==FALSE || $this->button_add==FALSE) {    
				CRUDBooster::redirect(CRUDBooster::adminPath(),trans("crudbooster.denied_access"));
			}
			
			$data['page_title'] = 'New OPD Visit';

			$data['doctors'] = DB::table('doctors')->where('is_activated', '1')->orderBy('name', 'asc')->get();
			
			//Please use cbView method instead view method from laravel
			return $this->cbView('opd_visits.add_edit', $data);
		}

		public function postAddSave()
		{
			$this->cbLoader();
			if(!CRUDBooster::isCreate() && $this->global_privilege==FALSE) {
				CRUDBooster::insertLog(trans('crudbooster.log_try_add_save',['name'=>Request::input($this->title_field),'module'=>CRUDBooster::getCurrentModule()->name ]));
				CRUDBooster::redirect(CRUDBooster::adminPath(),trans("crudbooster.denied_access"));
			}

			$this->validation();

			try {

				DB::beginTransaction();

				$id = DB::table('opd_visits')->insertGetId([
					'doctor_id' => request()->doctor_id,
					'visit_date' => \Carbon\Carbon::parse(request()->visit_date)->format('Y-m-d') . ' ' .\Carbon\Carbon::now()->format('H:i:s'),
					'token_number' => request()->token_number,
					'patient_name' => request()->patient_name,
					'patient_age' => request()->patient_age,
					'patient_blood_pressure' => request()->patient_blood_pressure,
					'patient_temperature' => request()->patient_temperature,
					'doctor_fee' => request()->doctor_fee,
					'total_fee' => request()->doctor_fee,
					'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
					'created_by' => CRUDBooster::myId(),
				]);

				DB::table('doctors')->where('id', request()->doctor_id)->update(['opd_current_token_number'=>request()->token_number+1]);


				DB::commit();

				$this->afterPostAddSave($id);
				
			} catch (\Exception $e) {
				
				DB::rollBack();
				throw $e;
				
			}
		}

		public function getEdit($id) {
			//Create an Auth
			if(!CRUDBooster::isUpdate() && $this->global_privilege==FALSE || $this->button_add==FALSE) {    
				CRUDBooster::redirect(CRUDBooster::adminPath(),trans("crudbooster.denied_access"));
			}
			
			$data['page_title'] = 'Edit OPD Visit';

			$this->getOpdVisitData($data, $id);
			
			//Please use cbView method instead view method from laravel
			return $this->cbView('opd_visits.add_edit', $data);
		}

		public function getOpdVisitData(&$data, $id)
		{
			$data['opd_visit'] = DB::table('opd_visits')->where('id', $id)->first();

			$opd_visit_facilities = DB::table('opd_visit_facilities')
										->leftJoin('facilities', 'facilities.id', '=', 'opd_visit_facilities.facility_id')
										->select('opd_visit_facilities.*', 'facilities.price', 'facilities.name')
										->where('opd_visit_id', $id)->get();



			$all_facilities = DB::table('facilities')->whereNotIn('id', $opd_visit_facilities->pluck('facility_id'))->get();

			$facilities = array();

			foreach ($opd_visit_facilities as $opd_visit_facility) {
				
				$facilities[] = [
					'id' => $opd_visit_facility->facility_id,
					'name' => $opd_visit_facility->name,
					'amount' => $opd_visit_facility->amount,
					'default_price' => $opd_visit_facility->price,
				];
			}
			
			

			foreach ($all_facilities as $facility) {
				
				$facilities[] = [
					'id' => $facility->id,
					'name' => $facility->name,
					'amount' => '',
					'default_price' => $facility->price,
				];
			}

			$facilities = collect($facilities)->sortBy('name');


			$data['facilities'] = $facilities;

			$data['doctors'] = DB::table('doctors')->where('is_activated', '1')->orderBy('name', 'asc')->get();
		}

		public function postEditSave($id)
		{
			

			$this->cbLoader();
			$row = DB::table($this->table)->where($this->primary_key,$id)->first();

			if(!CRUDBooster::isUpdate() && $this->global_privilege==FALSE) {
				CRUDBooster::insertLog(trans("crudbooster.log_try_add",['name'=>$row->{$this->title_field},'module'=>CRUDBooster::getCurrentModule()->name]));
				CRUDBooster::redirect(CRUDBooster::adminPath(),trans('crudbooster.denied_access'));
			}

			$this->validation($id);

			

			try {

				DB::beginTransaction();

				

				DB::table('opd_visit_facilities')->where('opd_visit_id', $id)->delete();

				$facilities_total_amount = 0;
				foreach (request()->facility as $key => $facility_id) {
					
					if(request()->facility_amount[$key] != '' && request()->facility_amount[$key] != 0)
					DB::table('opd_visit_facilities')->insert([
						'opd_visit_id' => $id,
						'facility_id' => $facility_id,
						'amount' => request()->facility_amount[$key],
					]);

					$facilities_total_amount += request()->facility_amount[$key];
				}


				DB::table('opd_visits')->where('id', $id)->update([
					'doctor_id' => request()->doctor_id,
					'visit_date' => \Carbon\Carbon::parse(request()->visit_date)->format('Y-m-d') . ' ' .\Carbon\Carbon::now()->format('H:i:s'),
					'token_number' => request()->token_number,
					'patient_name' => request()->patient_name,
					'patient_age' => request()->patient_age,
					'patient_blood_pressure' => request()->patient_blood_pressure,
					'patient_temperature' => request()->patient_temperature,
					'doctor_fee' => request()->doctor_fee,
					'total_fee' => request()->doctor_fee + $facilities_total_amount,
					'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
					'updated_by' => CRUDBooster::myId(),
				]);



				DB::commit();

				$this->afterPostAddSave($id);
				
			} catch (\Exception $e) {
				
				DB::rollBack();
				throw $e;
				
			}
		}

		public function getDelete($id) {
			$this->cbLoader();
			$row = DB::table($this->table)->where($this->primary_key,$id)->first();

			if(!CRUDBooster::isDelete() && $this->global_privilege==FALSE || $this->button_delete==FALSE) {
				CRUDBooster::insertLog(trans("crudbooster.log_try_delete",['name'=>$row->{$this->title_field},'module'=>CRUDBooster::getCurrentModule()->name]));
				CRUDBooster::redirect(CRUDBooster::adminPath(),trans('crudbooster.denied_access'));
			}


			try
			{
				DB::beginTransaction();

				//insert log
				CRUDBooster::insertLog(trans("crudbooster.log_delete",['name'=>$row->{$this->title_field},'module'=>CRUDBooster::getCurrentModule()->name]));

				DB::table('opd_visits')->where('id', $id)->delete();

				DB::table('opd_visit_facilities')->where('opd_visit_id', $id)->delete();

				DB::commit();
			}
			catch(\Exception $ex)
			{
				DB::rollBack();
				throw $ex;
			}

			$url = g('return_url')?:CRUDBooster::referer();

			CRUDBooster::redirect($url,trans("crudbooster.alert_delete_data_success"),'success');
		}

		public function afterPostAddSave($id)
		{
			if( request()->has('save_and_print') == false )
			{
				CRUDBooster::redirect(CRUDBooster::mainpath('add'),trans("crudbooster.alert_add_data_success"),'success');
			}
			else
			{
				CRUDBooster::redirect(CRUDBooster::mainpath($id.'/print'),trans("crudbooster.alert_add_data_success"),'success');
			}
		}

		public function print_opd_visit($id)
		{
			$data = array();

			$this->getOpdVisitData($data, $id);

			return view('opd_visits.print', compact('data'));
		}

	}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ReportsController extends Controller
{
    //

  	public function totalCollectionReport(Request $request)
  	{
  		
  		$header_info['page_title'] = __('Total Collection Report');
        $header_info['page_icon'] = 'fa fa-money';

        $header_info['breadcrumb_items'] = [
            [
                'icon' => $header_info['page_icon'],
                'name' => $header_info['page_title'],
                'url' => \CRUDbooster::adminPath('admin/reports/collection_by_users'),
            ],
        ];

        $doctors_collection = null;
        $facilities_collection = null;

        $from_date = null;
        $to_date = null;


        if( $request->has('from_date') == false )
        {
          $request->merge( ['from_date' => \Carbon\Carbon::now()->format('Y-m-d') ] );
        }       

        if( $request->has('to_date') == false )
        {
          $request->merge( ['to_date' => \Carbon\Carbon::now()->format('Y-m-d') ] );
        }       

        if($request->has('from_date') && $request->has('to_date'))
        {
        	$from_date = \Carbon\Carbon::parse($request->from_date)->format('Y-m-d');
        	$to_date = \Carbon\Carbon::parse($request->to_date)->format('Y-m-d');

	        $doctors_collection = DB::table('opd_visits')
	        							->join('doctors', 'doctors.id', '=', 'opd_visits.doctor_id')
	        							->select('doctors.name', 'doctors.qualification', 
	        								DB::raw('sum(opd_visits.doctor_fee) as total_doctor_fee'))
	        							->groupBy('doctors.id')
	        							->whereBetween(DB::raw('date(opd_visits.visit_date)'), [
                          $from_date,
                          $to_date,
                          ])
	        							->get();

	        $facilities_collection = DB::table('opd_visit_facilities')
	        							->join('opd_visits', 'opd_visits.id', '=', 'opd_visit_facilities.opd_visit_id')
	        							->join('facilities', 'facilities.id', '=', 'opd_visit_facilities.facility_id')
	        							->select('facilities.name', DB::raw('opd_visit_facilities.amount as total_facility_collection'))
	        							->groupBy('facilities.id')
	        							->whereBetween(DB::raw('date(opd_visits.visit_date)'), [
	        								$from_date,
	        								$to_date,
	        								])
	        							->get();
	    }

        return view('reports.total_collection_report', compact('header_info', 'doctors_collection', 'facilities_collection', 'from_date', 'to_date'));

  	}

  	public function collectionByUsers(Request $request)
  	{
  		dd($request->all());
  	}
}

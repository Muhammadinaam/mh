@extends('crudbooster::admin_template')
@section('content')

<style type="text/css">

	@media print {
	
		#print_div {
			font-size: 0.8em;
		}

		.col-sm-1, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-10, .col-sm-11, .col-sm-12 {
	        float: left;
	   }
	   .col-sm-12 {
	        width: 100%;
	   }
	   .col-sm-11 {
	        width: 91.66666667%;
	   }
	   .col-sm-10 {
	        width: 83.33333333%;
	   }
	   .col-sm-9 {
	        width: 75%;
	   }
	   .col-sm-8 {
	        width: 66.66666667%;
	   }
	   .col-sm-7 {
	        width: 58.33333333%;
	   }
	   .col-sm-6 {
	        width: 50%;
	   }
	   .col-sm-5 {
	        width: 41.66666667%;
	   }
	   .col-sm-4 {
	        width: 33.33333333%;
	   }
	   .col-sm-3 {
	        width: 25%;
	   }
	   .col-sm-2 {
	        width: 16.66666667%;
	   }
	   .col-sm-1 {
	        width: 8.33333333%;
	   }

	}

	

	.td_info {
		border-bottom: 1px solid black !important;
		font-weight: bold;
	}

	.td_info2 {
		border: 1px solid black !important;
	}

	td {
		padding: 0px !important;
		vertical-align: bottom !important;
	}

</style>

<div id="print_div" style="background-color: white; padding: 5px;">

	<img src="{{asset(CRUDBooster::getSetting('print_header_image', 'OPD Visit Settings'))}}" width="100%">

	<br><br>

	<table class="table">
		<tr>
			<td class="col-sm-2">Name</td><td class="col-sm-4 td_info text-center">{{$data['opd_visit']->patient_name}}</td>
			<td class="col-sm-2">Token #</td><td class="col-sm-4 td_info text-center">{{$data['opd_visit']->token_number}}</td>
		</tr>

		<tr>
			<td class="col-sm-1">Age</td><td class="col-sm-5 td_info text-center">{{$data['opd_visit']->patient_age}}</td>
			<td class="col-sm-6" style="padding: 0px;" colspan="2">
				<table style="margin-bottom: 0px; margin-top: 10px;" class="table">
					<tr>
						<td class="col-sm-4">B.P</td> <td class="col-sm-8 td_info2 text-center">&nbsp;{{$data['opd_visit']->patient_blood_pressure}}</td>
					</tr>

					<tr>
						<td class="col-sm-4">Temp.</td> <td class="col-sm-8 td_info2 text-center">&nbsp;{{$data['opd_visit']->patient_temperature}}</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>

	<table class="col-sm-5 table table-bordered">
		@foreach($data['facilities']->all() as $facility)
		<tr>
			<td style="padding: 5px 0 5px 0 !important;" class="col-sm-5">{{$facility['name']}}</td>
			<td style="padding: 5px 0 5px 0 !important;" class="col-sm-7">{{$facility['amount']}}</td>
		</tr>
		@endforeach
	</table>
	

	<div style="clear: both;"></div>

</div>

@endsection
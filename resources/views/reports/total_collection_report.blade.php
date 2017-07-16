@extends('crudbooster::admin_template')
@section('content')


<style type="text/css">
  .total-row {
    background-color: lightblue;
    font-weight: bold;
  }

  thead tr {
    background-color: lightgray;
    font-weight: bold;
  }

</style>

<div class="box">

  

  <div class="box-body">

    <div class="row">

      <div class="col-md-12">
        @include('partials.dates_filter', compact('from_date', 'to_date'))        
      </div>

      <div class="col-md-12">
        
        @if(isset($doctors_collection))
        <h3 class="text-center">Doctors Collection</h3>
        <table class="table table-condensed table-bordered">
          <thead>
            <tr>
              <th class="col-md-10">Doctor</th>
              <th class="col-md-2 text-right">Amount</th>
            </tr>
          </thead>

          <tbody>

          @php
            $total_doctor_collection = 0;
          @endphp

            @foreach($doctors_collection as $doc_collection)

            @php
            $total_doctor_collection += $doc_collection->total_doctor_fee;
            @endphp

            <tr>
              <td><b>{{$doc_collection->name}}</b><br>{{$doc_collection->qualification}}</td>
              <td class="text-right">{{$doc_collection->total_doctor_fee + 0}}</td>
            </tr>
            @endforeach


            <tr class="total-row">
              <td>Total</td>
              <td class="text-right">{{$total_doctor_collection}}</td>
            </tr>

          </tbody>
        </table>
        @endif




        @if(isset($facilities_collection))
        <h3 class="text-center">Facilities Collection</h3>
        <table class="table table-condensed table-bordered">
          <thead>
            <tr>
              <th class="col-md-10">Facility</th>
              <th class="col-md-2 text-right">Amount</th>
            </tr>
          </thead>

          <tbody>

          @php
            $total_facility_collection = 0;
          @endphp

            @foreach($facilities_collection as $facility_collection)

            @php
            $total_facility_collection += $facility_collection->total_facility_collection;
            @endphp

            <tr>
              <td><b>{{$facility_collection->name}}</b></td>
              <td class="text-right">{{$facility_collection->total_facility_collection + 0}}</td>
            </tr>
            @endforeach


            <tr class="total-row">
              <td>Total</td>
              <td class="text-right">{{$total_facility_collection}}</td>
            </tr>

          </tbody>
        </table>
        @endif




        @if(isset($total_doctor_collection) || isset($total_facility_collection) )
        <h3 class="text-center">Total Collection</h3>
        <table class="table table-condensed table-bordered">

            @php
            $total_doctor_collection = isset($total_doctor_collection) ? $total_doctor_collection : 0;
            $total_facility_collection = isset($total_facility_collection) ? $total_facility_collection : 0;
            @endphp

            <tr class="total-row">
              <td class="col-md-10">Total</td>
              <td class="text-right col-md-2">{{ $total_doctor_collection + $total_facility_collection}}</td>
            </tr>

          </tbody>
        </table>
        @endif

      </div>
    </div>

  </div>

</div>



@endsection











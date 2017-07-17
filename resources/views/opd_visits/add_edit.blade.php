@extends('crudbooster::admin_template')
@section('content')


<div >

  @if(CRUDBooster::getCurrentMethod() != 'getProfile' && $button_cancel)
  @if(g('return_url'))
  <p><a title='Return' href='{{g("return_url")}}'><i class='fa fa-chevron-circle-left '></i> &nbsp; {{trans("crudbooster.form_back_to_list",['module'=>CRUDBooster::getCurrentModule()->name])}}</a></p>       
  @else
  <p><a title='Main Module' href='{{CRUDBooster::mainpath()}}'><i class='fa fa-chevron-circle-left '></i> &nbsp; {{trans("crudbooster.form_back_to_list",['module'=>CRUDBooster::getCurrentModule()->name])}}</a></p>       
  @endif
  @endif

  <div class="panel panel-default">
   <div class="panel-heading">

     <strong><i class='{{CRUDBooster::getCurrentModule()->icon}}'></i> {!! $data['page_title'] or "Page Title" !!}</strong>
   </div> 

   <div class="panel-body" style="padding:20px 0px 0px 0px">
    <?php                               
    $action = (@$data['opd_visit'])?CRUDBooster::mainpath("edit-save/".$data['opd_visit']->id):CRUDBooster::mainpath("add-save");
    $return_url = ($return_url)?:g('return_url');          
    ?>

    <form class='form-horizontal' method='post' id="form" enctype="multipart/form-data" action='{{$action}}'>
      <input type="hidden" name="_token" value="{{ csrf_token() }}">    
      <input type='hidden' name='return_url' value='{{ @$return_url }}'/>                      
      <input type='hidden' name='ref_mainpath' value='{{ CRUDBooster::mainpath() }}'/>      
      <input type='hidden' name='ref_parameter' value='{{urldecode(http_build_query(@$_GET))}}'/>
      @if($hide_form)
      <input type="hidden" name="hide_form" value='{!! serialize($hide_form) !!}'>
      @endif
      <div class="box-body" id="parent-form-area">

        {{csrf_field()}}

        
        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-2" for="patient_name">Name</label>  
          <div class="col-md-4">
            <input id="patient_name" name="patient_name" type="text" placeholder="Patient Name" class="form-control input-md" required=""
            value="{{ isset($data['opd_visit']->patient_name) ? $data['opd_visit']->patient_name : '' }}">    
          </div>
        
          <label class="col-md-2" for="patient_age">Age</label>  
          <div class="col-md-4">
            <input id="patient_age" name="patient_age" type="number" step="any" placeholder="Patient Age" class="form-control input-md"
            value="{{ isset($data['opd_visit']->patient_age) ? $data['opd_visit']->patient_age : '' }}" min="0" max="150">
          </div>
        </div>

        <!-- Text input-->
        <!-- <div class="form-group">
          <label class="col-md-2" for="patient_blood_pressure">Blood Pressure</label>  
          <div class="col-md-4">
          <input id="patient_blood_pressure" name="patient_blood_pressure" type="text" placeholder="120 / 80" class="form-control input-md"
          value="{{ isset($data['opd_visit']->patient_blood_pressure) ? $data['opd_visit']->patient_blood_pressure : '' }}">
          </div>
        
          <label class="col-md-2" for="patient_temperature">Temperature</label>  
          <div class="col-md-4">
          <input id="patient_temperature" name="patient_temperature" type="number" placeholder="Patient Temperature (102)" class="form-control input-md"
          value="{{ isset($data['opd_visit']->patient_temperature) ? $data['opd_visit']->patient_temperature : '' }}">
            
          </div>
        </div> -->


        <hr>

        <div class="form-group">
          <label class="col-md-2" for="doctor_id">Doctor</label>  
          <div class="col-md-4">

          <select id="doctor_id" name="doctor_id" class="form-control input-md" required="">
            
            @if( count($data['doctors']) > 1 )
            <option value>Please select Doctor</option>
            @endif
            
            @foreach($data['doctors'] as $doctor)
            <option value="{{$doctor->id}}" {{ isset($data['opd_visit']->doctor_id) && $data['opd_visit']->doctor_id == $doctor->id ? 'selected' : '' }}>{{$doctor->name}}</option>
            @endforeach
          </select>          

          </div>

          @php
          $new_token_number = '';
          $doctor_fee = '';

          if( isset( $data['opd_visit'] ) == false  // new visit
              && count($data['doctors']) == 1 )
              {
                $new_token_number = $data['doctors'][0]->opd_current_token_number;
                $doctor_fee = $data['doctors'][0]->opd_fee;
              }


          @endphp
        
          <label class="col-md-2" for="token_number">Token Number</label>  
          <div class="col-md-4">
          <input id="token_number" name="token_number" type="number" placeholder="" class="form-control input-md"
          value="{{ isset($data['opd_visit']->token_number) ? $data['opd_visit']->token_number : $new_token_number }}" required="">
            
          </div>
        </div>


        
        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-2">Doctor Fee</label>  
          <div class="col-md-4">
          <input id="doctor_fee" name="doctor_fee" type="number"  class="form-control input-md"
          value="{{ isset($data['opd_visit']->doctor_fee) ? $data['opd_visit']->doctor_fee : $doctor_fee }}">
          </div>
        
            <label class='col-md-2'>Visit Date <span class='text-danger' title='This field is required'>*</span></label>
            <div class="col-md-4">
              <div class="input-group">                 
                <span class="input-group-addon open-datetimepicker"><a><i class='fa fa-calendar '></i></a></span>
                <input type='text' title="Visit Date" readonly required class='form-control notfocus input_date' name="visit_date" id="visit_date" 
                value="{{ isset($data['opd_visit']->visit_date) ? $data['opd_visit']->visit_date : \Carbon\Carbon::now()->format('Y-m-d') }}" />
              </div>
              <div class="text-danger"></div>
              <p class='help-block'></p>
            </div>

        </div>

        @if(isset($data['opd_visit']))

        <hr>
          
        <div class="panel panel-primary">
          <div class="panel-heading">
            Facilities
          </div>

          

          <div class="panel-body">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th class="col-md-8">Facility</th>
                  <th class="col-md-4 text-center">Amount</th>
                </tr>
              </thead>

              <tbody>
                @foreach($data['facilities']->all() as $facility)
                <tr>
                  <td>
                    {{$facility['name']}}
                    <input type="hidden" name="facility[]" value="{{$facility['id']}}">
                  </td>
                  <td> 

                    <div class="input-group">
                      <input type="number" step="any" name="facility_amount[]" value="{{$facility['amount']}}" class="form-control">
                      <span class="input-group-btn">
                        <button class="btn btn-primary" type="button" onclick='setDefaultPrice("{{$facility['default_price']}}", this)'>Default</button>
                      </span>
                    </div>

                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>

        @endif
        

      </div><!-- /.box-body -->

      <div class="box-footer" style="background: #F5F5F5">  

        <div class="form-group">
          <label class="control-label col-md-2"></label>
          <div class="col-md-10">
            @if($button_cancel && CRUDBooster::getCurrentMethod() != 'getDetail')                       
            @if(g('return_url'))
            <a href='{{g("return_url")}}' class='btn btn-default'><i class='fa fa-chevron-circle-left'></i> {{trans("crudbooster.button_back")}}</a>
            @else 
            <a href='{{CRUDBooster::mainpath("?".http_build_query(@$_GET)) }}' class='btn btn-default'><i class='fa fa-chevron-circle-left'></i> {{trans("crudbooster.button_back")}}</a>
            @endif
            @endif
            @if(CRUDBooster::isCreate() || CRUDBooster::isUpdate())

            @if(CRUDBooster::isCreate() && $button_addmore==TRUE && $command == 'add')                                                                                                     
            <input id="button_save_more" type="submit" name="submit" value='{{trans("crudbooster.button_save_more")}}' class='btn btn-success'>
            @endif

            @if($button_save && $command != 'detail')
            <input id="button_save" type="submit" name="submit" value='{{trans("crudbooster.button_save")}}' class='btn btn-success'>
            <button id="button_save_print" type="submit" name="submit" value='Save and Print' class='btn btn-primary'>
              <i class="fa fa-print" aria-hidden="true"></i>
              Save and Print
            </button>
            @endif

            @endif
          </div>
        </div>

      </div><!-- /.box-footer-->

    </form>

  </div>
</div>
</div><!--END AUTO MARGIN-->






<script type="text/javascript">


  var lang = '{{App::getLocale()}}';

  function setDefaultPrice(default_price, element)
  {
    var row = $(element).closest('tr');
    var input = row.find('input[name="facility_amount[]"]');
    input.val(default_price);
  }

  $(document).ready(function(){

    

    $('.box-footer').append($(`<div id='errors' style="display: none;">
                              </div> `));

    $('.box-footer').append($(`<div id="please-wait" style="display: none;">
                                <h3>Please wait...</h3>
                              </div>`));


    $('.input_date').datepicker({
            format: 'yyyy-mm-dd',
            @if (App::getLocale() == 'ar')
            rtl: true,
            @endif
            language: lang
        });
        
        $('.open-datetimepicker').click(function() {
        $(this).next('.input_date').datepicker('show');
    });


    var asset_path = "{{asset('')}}";



    var doctors = {!! $data['doctors'] !!};

    $('[name=doctor_id]').change(function(){
      if( $('[name=doctor_id]').val() != '' )
      {
        $('[name=token_number]').val('');
        $('[name=doctor_fee]').val('');



        for(var i = 0; i < doctors.length; i++)
        {
          if(doctors[i].id == $('[name=doctor_id]').val())
          {
            $('[name=token_number]').val(doctors[i].opd_current_token_number);
            $('[name=doctor_fee]').val(doctors[i].opd_fee);

            break;
          }
        }

        // $.ajax({
        //   type: 'get',
        //   url: 'http://localhost/mh/public/admin/doctors/detail/' + $('[name=doctor_id]').val(),
        //   success: function(data)
        //   {
        //     $('[name=token_number]').val(data.opd_current_token_number);
        //     $('[name=doctor_fee]').val(data.opd_fee);
        //   }
        // })
      }
    });
    

    redirect_url = '';

    $('#button_save_more').click(function(){
      redirect_url = window.location.href;  // back to same page
    });

    $('#button_save').click(function(){
      redirect_url = '';  // unset
    });

    $('#button_save_print').click(function(){
      var sp = $('[name="save_and_print"]');
      if(sp)
      {
        sp.remove();
      }
      $('#form').append('<input type="hidden" name="save_and_print" value="1">');
    });

    $('#form').submit(function(e){

      $('#button_save_more, #button_save, #button_save_print').attr('disabled', true);

      e.preventDefault();

      var formData = new FormData($('#form')[0]);

      $('#errors').hide('slow');

      $('#please-wait').show('slow');

      $.ajax({
        type: 'post',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        url: "{{$action}}",
        success: function(data){
          if(data.message_type != 'success')
          {
            errorsHtml = '<div class="alert alert-danger">'+data.message+'</div>'
            $( '#errors' ).html( errorsHtml );
            $( '#errors' ).show('slow');
            $('#please-wait').hide('slow');
          }
          else if(data.message_type == 'success')
          {
            $( '#errors' ).hide('slow');
            $('#please-wait').hide('slow');


            if(redirect_url == '')
              window.location.href = data.redirect_url;    
            else
              window.location.href = redirect_url;

            // swal({
            //        title: "Success",
            //        text: "Data Saved Successfully",
            //        type: "success",
            //        showCancelButton: false,
            //        confirmButtonColor: "#DD6B55",
            //        confirmButtonText: "Ok",
            //        closeOnConfirm: false 
            //       },
            //         function(){
            //           if(redirect_url == '')
            //             window.location.href = data.redirect_url;    
            //           else
            //             window.location.href = redirect_url;
            //       });
          }
        },
        error: function(jqXHR, exception){
          showErrors(jqXHR, exception, '#errors', '#please-wait');          
        },

      }).always(function(){
        $('#button_save_more, #button_save, #button_save_print').attr('disabled', false);
      });

      var sp = $('[name="save_and_print"]');
      if(sp)
      {
        sp.remove();
      }

    });





    

  });

  </script>

  @endsection











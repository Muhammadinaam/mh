<div class="box">
	
	<div class="box-header with-border">
      <h3 class="box-title">Dates</h3>

      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
        </button>
        
      </div>
    </div>

	<div class="box-body">
		
		<form class="form-horizontal">
			<div class="form-group">
	        
		        <label class='col-md-1'>From <span class='text-danger' title='This field is required'>*</span></label>
		        <div class="col-md-4">
		          <div class="input-group">                 
		            <span class="input-group-addon open-datetimepicker"><a><i class='fa fa-calendar '></i></a></span>
		            <input type='text' title="From" required="" class='form-control notfocus input_date' name="from_date" id="from_date" 
		            value="{{isset($from_date) ? $from_date : \Carbon\Carbon::now()->format('Y-m-d')}}" />
		          </div>
		          <div class="text-danger"></div>
		          <p class='help-block'></p>
		        </div>
	        
		        <label class='col-md-1'>To <span class='text-danger' title='This field is required'>*</span></label>
		        <div class="col-md-4">
		          <div class="input-group">                 
		            <span class="input-group-addon open-datetimepicker"><a><i class='fa fa-calendar '></i></a></span>
		            <input type='text' title="To" required class='form-control notfocus input_date' name="to_date" id="to_date" 
		            value="{{isset($to_date) ? $to_date : \Carbon\Carbon::now()->format('Y-m-d')}}" />
		          </div>
		          <div class="text-danger"></div>
		          <p class='help-block'></p>
		        </div>


		        <div class="col-md-2">
		        	<input class="btn btn-primary flat" type="submit" value="Show">
		        </div>

	        </div>

	        

	    </form>

	</div>

</div>

<script type="text/javascript">
	
	$(document).ready(function(){

		var lang = '{{App::getLocale()}}';

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

	});

</script>
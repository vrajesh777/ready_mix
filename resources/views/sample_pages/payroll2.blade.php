@extends('layout.master')
@section('main_content')

<style type="text/css">
	/*Radio Buttons Start Here*/
.radio-box{display:flex;}
.radio-box .radio-btn{display:block;position:relative;}
.radio-box .radio-btn:last-child{margin-right:0px;}
.radio-box .radio-btn input[type=radio]{position:absolute;visibility:hidden;}
.radio-box .radio-btn .label-action{font-weight: normal;color: #646464;display: block;position: relative;font-size: 16px;padding:20px;margin:0px auto;z-index: 9;cursor: pointer;border:1px solid rgba(0, 0, 0, .125)}
.radio-box input[type=radio]:checked ~ .label-action{background:rgb(159 89 255 / 10%);border-color:#9f59ff;box-shadow: 0px 1px 8px rgb(159 89 255 / 50%);}
.label-action i{width:60px;height:60px;border:1px solid rgba(0, 0, 0, .125);border-radius:50px;font-size:2rem;flex: 0 0 60px;margin-right: 15px;line-height: 58px;text-align:center;background-color: #fff;color:#9f59ff}
.label-action .cont-info h4{color:#000;font-size:1rem;margin:0 0 3px;}
.radio-box input[type=radio]:checked ~ .label-action h4{color:#9f59ff;}
.label-action .cont-info p{font-size:.8rem;margin:0}
.label-action .cont-info p span {text-transform:uppercase;color:#9f59ff;margin:0 0 0 5px}
.account-field{display:none; max-width:500px;width:100%;margin:auto;padding:20px;background-color:#fdfbff;border:1px solid rgba(0, 0, 0, .125)}
.account-field.active{display:block;}
/*Radio Buttons End Here*/
</style>

<div class="card">
	<div class="card-header">
		<h4 class="card-title m-0">Amol's payment information</h4>
	</div>
	<div class="card-body payroll-detail">
		<div class="form-group row radio-box">
			<div class="col-sm-4">
				<div class="radio-btn">
					<a class="label-action d-flex align-items-center" href="">
		              	<i class="fal fa-piggy-bank"></i>
		              	<div class="cont-info">
		              	<h4>Direct Deposit (Automated Process)</h4>
		              	<p>Initiate payment in Zoho Payroll once the pay run is approved <span>Configure Now</span></p>
		              	
		              	</div>
		            </a>
		        </div> 	
			</div>
			<div class="col-sm-4">
	            <div class="radio-btn">
	              <input type="radio" id="f-option" name="selector">
	              <label class="manual-process label-action d-flex align-items-center" for="f-option">
	              	<i class="fal fa-university"></i>
	              	<div class="cont-info">
	              	<h4>Bank Transfer (Manual Process)</h4>
	              	<p>Download Bank Advice and process the payment through your bank's website,</p>
	              	</div>
	         		</label>
	            </div>
			</div>
			<div class="col-sm-4">
				<div class="radio-btn">
	              <input type="radio" id="s-option" name="selector">
	              <label class="label-action d-flex align-items-center" for="s-option">
	              	<i class="fal fa-money-check-alt"></i>
	              	<div class="cont-info">
	              	<h4>Cheque</h4>
	              	</div>
	              </label>
	             
	            </div>
			</div>
		</div>
		<div class="account-field my-5">
			<div class="row">
				<div class="form-group col-md-12">
					<label class="col-form-label">Account Holder Name<span class="text-danger">*</span></label>
					<input type="text" class="form-control">
				</div>
				<div class="form-group col-md-12">
					<label class="col-form-label">Bank Name<span class="text-danger">*</span></label>
					<input type="text" class="form-control">
				</div>
				<div class="form-group col-md-6">
					<label class="col-form-label">Account Number<span class="text-danger">*</span></label>
					<input type="text" class="form-control">
				</div>
				<div class="form-group col-md-6">
					<label class="col-form-label">Re-enter Account Number<span class="text-danger">*</span></label>
					<input type="text" class="form-control">
				</div>
				<div class="form-group col-md-6">
					<label class="col-form-label">IFSC<span class="text-danger">*</span></label>
					<input type="text" class="form-control">
				</div>
				<div class="form-group col-md-6">
					<label class="col-form-label d-block mb-2">Account Type<span class="text-danger">*</span></label>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="radio" name="gender" id="gender_male" value="option1">
						<label class="form-check-label" for="gender_male">Current</label>
					</div>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="radio" name="gender" id="gender_female" value="option2">
						<label class="form-check-label" for="gender_female">Savings</label>
					</div>
				</div>
			</div>
		</div>	
		<div class="text-right">
			<button type="submit" class="border-0 btn btn-primary btn-gradient-primary btn-rounded">Submit</button>
			<button type="button" class="btn btn-secondary btn-rounded closeForm">Cancel</button>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
    $('.label-action').click(function(){
        $('.account-field').removeClass('active');       
    });
    $('.manual-process').click(function(){
        $('.account-field').addClass('active');       
    });
});  
</script>
@endsection
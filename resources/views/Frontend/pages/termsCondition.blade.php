@extends('frontend.master')

@section('mainContent')

<div class="main-container container">
	<div class="row">
		<div class="col-md-12" id="content">
			<h2 class="heading-title">Terms and Conditions</h2>
			<div class="">
				<?php
					echo @$termsCondition->description;
				?>

				<h3 class="contact-us">Contact Us</h3>
				<p>If you have any questions about this Agreement, please contact us filling this <a href="{{url('/contact-us')}}" class='contact-form'>contact form</a></p>
			</div>
		</div>
	</div><!-- /.row -->
</div>

<div style="height: 300px"></div>

<style>
    .heading-title {
        font-weight: 600;
        font-size: 20px;
        margin-top: 20px;
        margin-bottom: 20px;
        font-family: 'Open Sans', sans-serif;
        text-align: center;
    }

    .contact-us {
        font-weight: 500;
         margin-top: 30px;
        font-size: 16px;
        font-family: 'Open Sans', sans-serif;
    }
</style>

@endsection


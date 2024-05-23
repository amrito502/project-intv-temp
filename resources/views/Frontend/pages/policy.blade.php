@extends('frontend.master')

@section('mainContent')
<div class="main-container container">
	<div class="row">
		<div class="col-md-12" id="content">
			<h2 class="heading-title">{{@$paymentPolicy->title}}</h2>

			<?php echo @$paymentPolicy->description; ?>
		</div><!-- /.row -->
	</div><!-- /.container -->

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
</style>
@endsection

@extends('master')
@section('container')
<div class="container margin-top">
 <div class="row">

<div class="col-sm-12">

			<ul class="nav nav-tabs-order">
			  <li class="active"><a data-toggle="tab" href="#particulier">order als  particulier</a></li>
			  <li><a data-toggle="tab" href="#bedrijf">order als bedrijf</a></li>
			</ul>
			
			<div class="tab-content">

			  <div id="particulier" class="tab-pane fade in active">

					<div class="panel panel-primary">

						<div class="panel-body">

							{!! Form::open(['url' => 'payments/method/ondelivery']) !!}

							<div class="form-group col-sm-6">
								{!! Form::label('first_name', 'Voornaam:'); !!}
								{!! Form::text('first_name', null, array('id' => 'first_name', 'class' => 'form-control', 'placeholder' => 'Voornaam')); !!}
							</div>
							<div class="form-group col-sm-6">
								{!! Form::label('last_name', 'Achteernaam:'); !!}
								{!! Form::text('last_name', null, array('id' => 'last_name', 'class' => 'form-control', 'placeholder' => 'Achteernaam')); !!}
							</div>
							<div class="form-group col-sm-6">
								{!! Form::label('email', 'Email:'); !!}
								{!! Form::text('email', null, array('id' => 'email', 'class' => 'form-control', 'placeholder' => 'Email')); !!}
							</div>
							<div class="form-group col-sm-6">
								{!! Form::label('phone', 'Telefoon:'); !!}
								{!! Form::text('phone', null, array('id' => 'phone', 'class' => 'form-control', 'placeholder' => 'Telefoon')); !!}
							</div>
							
							<div class="form-group col-sm-6">
								{!! Form::label('city', 'City:'); !!}
								{!! Form::text('city', null, array('id' => 'city', 'class' => 'form-control', 'placeholder' => 'City')); !!}
							</div>

							<div class="form-group col-sm-6">
								{!! Form::label('address', 'Address:'); !!}
								{!! Form::text('address', null, array('id' => 'address', 'class' => 'form-control', 'placeholder' => 'Address')); !!}
							</div>

							<div class="form-group col-sm-6">
								{!! Form::label('comment', 'Opmerkingen:'); !!}
								{!! Form::textarea('comment', null, array('id' => 'comment', 'class' => 'form-control', 'rows' => 4, 'cols' => 50, 'placeholder' => 'Als u wilt meer info..')); !!}
							</div>


							<div class="col-xs-12 text-right">
								<button class="btn btn-primary">Bevestiging</button>
							</div>

							{!! Form::close() !!}

						</div>

					</div>

			  </div>
			  
			  
			  
			  <div id="bedrijf" class="tab-pane fade">
			  
			  
					<div class="panel panel-primary">

						<div class="panel-body">

							{!! Form::open(['url' => 'payments/method/ondelivery/firm']) !!}

							<div class="form-group col-sm-6">
								{!! Form::label('firm', 'Bedrijfsnaam:'); !!}
								{!! Form::text('firm', null, array('id' => 'firm', 'class' => 'form-control', 'placeholder' => 'Bedrijfsnaam')); !!}
							</div>

                            <div class="form-group col-sm-6">
                                {!! Form::label('first_name', 'Voornaam:'); !!}
                                {!! Form::text('first_name', null, array('id' => 'first_name', 'class' => 'form-control', 'placeholder' => 'Voornaam')); !!}
                            </div>

                            <div class="form-group col-sm-6">
                                {!! Form::label('last_name', 'Achteernaam:'); !!}
                                {!! Form::text('last_name', null, array('id' => 'last_name', 'class' => 'form-control', 'placeholder' => 'Achteernaam')); !!}
                            </div>

                            <div class="form-group col-sm-6">
                                {!! Form::label('email', 'Email:'); !!}
                                {!! Form::text('email', null, array('id' => 'email', 'class' => 'form-control', 'placeholder' => 'Email')); !!}
                            </div>

                            <div class="form-group col-sm-6">
                                {!! Form::label('phone', 'Telefoon:'); !!}
                                {!! Form::text('phone', null, array('id' => 'phone', 'class' => 'form-control', 'placeholder' => 'Telefoon')); !!}
                            </div>

							<div class="form-group col-sm-6">
								{!! Form::label('kvk', 'KVK nummer:'); !!}
								{!! Form::text('kvk', null, array('id' => 'kvk', 'class' => 'form-control', 'placeholder' => 'KVK nummer')); !!}
							</div>

							<div class="form-group col-sm-6">
								{!! Form::label('btw', 'BTW nummer:'); !!}
								{!! Form::text('btw', null, array('id' => 'btw', 'class' => 'form-control', 'placeholder' => 'BTW nummer')); !!}
							</div>
							
							<div class="form-group col-sm-6">
								{!! Form::label('city', 'City:'); !!}
								{!! Form::text('city', null, array('id' => 'city', 'class' => 'form-control', 'placeholder' => 'City')); !!}
							</div>

							<div class="form-group col-sm-6">
								{!! Form::label('address', 'Bedrijfsadres:'); !!}
								{!! Form::text('address', null, array('id' => 'address', 'class' => 'form-control', 'placeholder' => 'Bedrijfsadres')); !!}
							</div>

							<div class="form-group col-sm-6">
								{!! Form::label('comment', 'Opmerkingen:'); !!}
								{!! Form::textarea('comment', null, array('id' => 'comment', 'class' => 'form-control', 'rows' => 4, 'cols' => 50, 'placeholder' => 'Als u wilt meer info..')); !!}
							</div>


							<div class="col-xs-12 text-right">
								<button class="btn btn-primary">Bevestiging</button>
							</div>

							{!! Form::close() !!}

						</div>

					</div>
  
			  </div>
			
			</div>
	



</div>


   </div>
</div>
@stop
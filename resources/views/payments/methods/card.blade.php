@extends('master')
@section('container')
		<div class="container page-content">
		<div class="col-md-10 col-md-offset-1 panel panel-default">
		<h2>Payment:</h2>
		<form class="form-horizontal">
			<fieldset>
			
				<div class="form-group">
					<label for="inputEmail" class="col-lg-14 col-md-14">Card Number:</label>
					
					<div class="col-lg-15 col-md-15">
						<input type="text" class="form-control" id="CardNumber" placeholder="Card Number">
					</div>
				</div>


            <div class="form-group">
                <div class="col-lg-2">
				    <label for="inputEmail">CCV:</label>
                    <input type="text" class="form-control" id="inputEmail" placeholder="Email">
                </div>
                <div class="col-lg-2">
				<label for="select">Exp. Month:</label>
                    <select class="form-control" id="select">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                        <option>6</option>
                        <option>7</option>
                        <option>8</option>
                        <option>9</option>
                        <option>10</option>
                        <option>11</option>
                        <option>12</option>
                    </select>
                </div>
                
                <div class="col-lg-2">
				<label for="select">Exp. Year:</label>
                    <select class="form-control" id="select">
                        <option>2016</option>
                        <option>2017</option>
                        <option>2018</option>
                        <option>2019</option>
                        <option>2020</option>
                    </select>
                </div>
				
				
                <div class="col-lg-3">
				    <label for="inputEmail">First Name:</label>
                    <input type="text" class="form-control" id="inputEmail" placeholder="First Name">
                </div>
                <div class="col-lg-3">
				    <label for="inputEmail">Last Name:</label>
                    <input type="text" class="form-control" id="inputEmail" placeholder="Last Name">
                </div>
				
            </div>
			

            <div class="form-group cards">
			    <div class="col-lg-12">
                <label for="inputEmail">Card Type:</label>
				</div>
                <div class="col-lg-4 card active" id="Visa">
                    <h1><i class="fa fa-cc-visa"></i></h1>
                </div>
                <div class="col-lg-4 card" id="Master">
                    <h1><i class="fa fa-cc-mastercard"></i></h1>
                </div>
                <div class="col-lg-4 card" id="Amex">
                    <h1><i class="fa fa-cc-amex"></i></h1>
                </div>
            </div>

            <div class="form-group">
                <div class="col-lg-12 text-right">
                    <button type="reset" class="btn btn-primary">Cancel</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </fieldset>
		</form>
	   </div>
	</div>
@stop
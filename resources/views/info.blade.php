@extends('master')
@section('container')
<section class="page-content">
    <div class="container">
        <div class="row">

            @if(isset($categories))
            <div class="col-md-3 col-sm-4">
                <div class="left-sidebar">
                    <h2>Categorieën</h2>

                    @include('sections.categories')

                </div>
            </div>
            @endif


            <div class="col-md-9 col-sm-8">

                <h2 style="margin-bottom: 30px;">@lang('fields.conditional_terms.title')</h2>

                <div class="panel-group" id="accordion">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse1" class="panel-title"><i
                            class="fa fa-phone"></i> @lang('fields.conditional_terms.contacts.title')</a>

                    <div id="collapse1" class="panel-collapse collapse">

                        <div class="col-sm-6">
                            <h2>@lang('fields.conditional_terms.contacts.subtitle')</h2>

                            <p><strong>Zuiddiijk 101<br>1501 Zaandam</strong></p>

                            <p><i class="fa fa-phone"></i>: +31 75 615 2379</p>

                            <p><i class="fa fa-mobile"></i>: +31611530353</p>

                            <p><i class="fa fa-envelope"></i>: <a href="mailto:office@maxverf.nl">office@maxverf.nl</a>
                            </p>

                            <p><strong>{{{ ucfirst(Lang::get('fields.conditional_terms.contacts.worktime'))
                                    }}}:</strong></p>

                            <p>ma t/m zat: &nbsp; &nbsp;07.00 uur - 18.00 uur</p>

                            <p><strong>@lang('fields.conditional_terms.contacts.coc'):</strong> 63363690</p>

                            <p><strong>@lang('fields.conditional_terms.contacts.vat'): </strong>NL819481488 B01</p>

                            <p><strong>@lang('fields.conditional_terms.contacts.iban'):</strong><br>Bank: ING BANK<br>IBAN
                                nummer: NL05INGB0006859091<br><br></p>
                        </div>

                        <div class="col-sm-6">
                            <p><img alt="" src="{!! asset('images/about.jpg') !!}" class="img-responsive pull-right"
                                    style="margin-bottom: 30px;"></p>

                            <p><strong></strong></p>
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2432.2628216691924!2d4.827474306115704!3d52.438153635947295!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c5fd2a302a6671%3A0xa82c556684423c31!2zWnVpZGRpamsgMTAxLCAxNTAxIENEIFphYW5kYW0sINCd0LjQtNC10YDQu9Cw0L3QtNC40Y8!5e0!3m2!1sbg!2sbg!4v1448015932401"
                                width="100%" height="400" frameborder="0" style="border:0;"></iframe>
                        </div>

                        <div style="clear: both;"></div>

                    </div>

                </div>

                <div class="panel-group" id="accordion">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse2" class="panel-title"><i
                            class="fa fa-bus"></i> @lang('fields.conditional_terms.courier.title')</a>

                    <div id="collapse2" class="panel-collapse collapse">
                        <?php
                        $rows = Lang::get('fields.conditional_terms.courier.text');
                        ?>
                        @foreach($rows as $row)
                        <p>{!! $row !!}</p>
                        <p>&nbsp;</p>
                        @endforeach
                    </div>
                </div>

                <div class="panel-group" id="accordion">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse3" class="panel-title"><i
                            class="fa fa-database"></i> @lang('fields.conditional_terms.payment.title')</a>

                    <div id="collapse3" class="panel-collapse collapse">

                        <p>
                            <strong>@lang('fields.conditional_terms.payment.text.0')</strong>

                            <p>&nbsp;</p>
                        @lang('fields.conditional_terms.payment.text.1')
                        </p>


                        <p><strong>@lang('fields.conditional_terms.payment.ideal.title')</strong></p>
                        <ul>
                            <li>@lang('fields.conditional_terms.payment.ideal.elements.0')</li>
                            <li>@lang('fields.conditional_terms.payment.ideal.elements.1')</li>
                            <li>@lang('fields.conditional_terms.payment.ideal.elements.2')</li>
                            <li>@lang('fields.conditional_terms.payment.ideal.elements.3')</li>
                            <li>@lang('fields.conditional_terms.payment.ideal.elements.4')</li>
                        </ul>


                        <p><strong>@lang('fields.conditional_terms.payment.bank.title')</strong></p>
                        <ul>
                            <li>@lang('fields.conditional_terms.payment.bank.elements.0')</li>
                            <li>@lang('fields.conditional_terms.payment.bank.elements.1')</li>
                            <li>@lang('fields.conditional_terms.payment.bank.elements.2')</li>
                        </ul>

                        <p><strong>@lang('fields.conditional_terms.payment.delivery.title')</strong></p>
                        <ul>
                            <li>@lang('fields.conditional_terms.payment.delivery.elements.0')</li>
                            <li>@lang('fields.conditional_terms.payment.delivery.elements.1')</li>
                        </ul>

                        <p><strong>@lang('fields.conditional_terms.payment.cash.title')</strong></p>
                        <ul>
                            <li>@lang('fields.conditional_terms.payment.cash.elements.0')</li>
                            <li>@lang('fields.conditional_terms.payment.cash.elements.1')</li>
                        </ul>


                    </div>
                </div>


            </div>

</section>
@stop
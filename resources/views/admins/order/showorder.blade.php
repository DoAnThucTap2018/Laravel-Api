@extends('backpack::layout')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1>
                <span class="text-capitalize">Orders</span>
                <small>Edit order.</small>
            </h1>
            <a href="{{ backpack_url('order') }}">
                <i class="fa fa-angle-double-left"></i> Back to all <span>orders</span></a>
            <div class="box box-default">
                <div class="box-header with-border">
                    <div class="box-title"><p>Order # {{$order[0]->id}} details</p></div>
                </div>
                <div class="box box-body ">
                    <form class="form-horizontal" role="form" method="POST" action="{{route('update',$order[0]->id)}}">
                        {!! csrf_field() !!}
                        <div class="row">
                            <div class="col-sm-4">Customer Detalls
                                <div>First Name:</div>
                                    <div {{ $errors->has('firstname') ? ' has-error' : '' }}>
                                        <div class="">
                                            <input class="form-control" type="text" name="firstname" value="{{$order[0]->first_name}}"
                                                   placeholder="First name">
                                        </div>
                                        @if ($errors->has('firstname'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('firstname') }}</strong>
                                    </span>
                                        @endif
                                        <div>Last Name:</div>
                                        <div {{ $errors->has('lastname') ? ' has-error' : '' }}>
                                                <input class="form-control" type="text" name="lastname"
                                                       value="{{$order[0]->last_name}}"
                                                       placeholder="Last name">

                                            @if ($errors->has('lastname'))
                                                <span class="help-block">
                                        <strong>{{ $errors->first('lastname') }}</strong>
                                    </span>
                                            @endif
                                        </div>
                                    </div>
                                <div> Email address:
                                    <div class="{{ $errors->has(backpack_authentication_column()) ? ' has-error' : '' }}">
                                        <input class="form-control" type="email" name="email"
                                               value="{{$order[0]->email}}"
                                               placeholder="Email">
                                        @if ($errors->has(backpack_authentication_column()))
                                            <span class="help-block">
                                 <strong>{{ $errors->first(backpack_authentication_column()) }}</strong>
                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div>Phone:</div>
                                <div {{ $errors->has('mobile') ? ' has-error' : '' }}>
                                    <input class="form-control" type="text" name="mobile"
                                           value="{{$order[0]->mobile}}"
                                           placeholder="Mobile">
                                    @if ($errors->has('mobile'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('mobile') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-4">General Detalls
                                <div>Order date:</div>
                                <div {{ $errors->has('date') ? ' has-error' : '' }}>
                                <input class="form-control" name="date" type="text" id="date"
                                       value="{{$order[0]->created_at}}">
                                    @if ($errors->has('date'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('date') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div>Order status:</div>
                                <select name="status" class="form-control" style="width: 84%">
                                    @foreach (\App\Models\OrderStatus::pluck('name','id') as $key=>$value)

                                        @if($key==$order[0]->order_status_id)
                                            <option value="{{$key}}" selected>{{$value}}</option>
                                        @else
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4">Shipping details
                                <div>Address:</div>
                                <div {{ $errors->has('address') ? ' has-error' : '' }}>
                                    <input class="form-control" type="text" name="address"
                                           value="{{$order[0]->order_address_name}}" placeholder="Address">
                                    @if ($errors->has('address'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div>Customer provided note:</div>
                                <textarea class="tx" rows="2" cols="40" type="text" name='note'
                                          value='{{$order[0]->notes}}'>{{$order[0]->notes}}</textarea>
                            </div>
                        </div>
                        <div class="col-sm-2 pull-right">
                            <button type="submit" class="btn btn-primary btn-block btn-flat">
                                <i class="fa fa-btn fa-pencil"></i> <span>Update</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="box box-default">
                <div class="box-header with-border">
                    <div class="box-title"><p>List Products </p></div>
                </div>
                <div class="box box-body ">
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-md-3">Product</div>
                            <div class="col-md-3">Title</div>
                            <div class="col-md-2">Cost</div>
                            <div class="col-md-2">Qty</div>
                            <div class="col-md-2">Total</div>
                        </div>
                        @foreach($order_detail as $od)
                            <div class="row">
                                <div class="col-sm-3"><img src="{{url('images/'.$od->image)}}"
                                                           type="image" style="width: 150px;height: 100px">
                                </div>
                                <div class="col-sm-3"><span class="pull-left">
                                    <p>{{$od->title}}</p></span>
                                </div>
                                <div class="col-sm-2">
                                    <p>{{$od->price}}</p>
                                </div>
                                <div class="col-sm-2">
                                    <p>{{$od->quantity}}</p>
                                </div>
                                <div class="col-sm-2">
                                    <p>{{$od->total_price}}</p>
                                </div>
                            </div>
                            <br>
                        @endforeach
                    </div>


                    <div class="col-md-12">
                        <div class="col-md-10"><span class="pull-right">Total</span></div>
                        <div class="col-md-2"><span class="pull-middle">{{$total}}</span></div>
                    </div>
                </div>

            </div>
            <div>

            </div>
        </div>
    </div>
    </div>

@endsection
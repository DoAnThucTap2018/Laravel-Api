@extends('backpack::layout')

@section('header')
    <section class="content-header">
        <h1>
            {{ trans('backpack::base.dashboard') }}<small>{{ trans('backpack::base.first_page_you_see') }}</small>
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-dashboard"></i>  <a href="{{ backpack_url() }}">Home</a></li>
            <li class="active">{{ trans('backpack::base.dashboard') }}</li>
        </ol>
    </section>
@endsection


@section('content')
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{{\App\Models\Item::all()->count()}}</h3>
                    <p>Product Number</p>
                </div>
                <div class="icon">
                    <i class="fa fa-suitcase"></i>
                </div>
                <a href="{{ url('admin/product') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{\App\Models\Order::all()->count()}}</h3>

                    <p>Order Number</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="{{ url('admin/order') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>{{\App\Models\TaxonomyItem::all()->count()}}</h3>

                    <p>Number of categories</p>
                </div>
                <div class="icon">
                    <i class="fa fa-puzzle-piece"></i>
                </div>
                <a href="{{ url('admin/taxonomy_item') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>{{\App\Models\User::all()->count()}}</h3>

                    <p>User Number</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="{{ url('admin/user') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
    </div>

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Latest Orders</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="table-responsive">
                <table class="table no-margin">
                    <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Product</th>
                        <th>Status</th>
                        <th>Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($order_detail as $odr)
                    <tr>
                        <td><a href="{{ url('admin/order') }}">{{$odr->id}}</a></td>
                        <td>{{$odr->title}}</td>
                        <td><span class="label label-warning">{{$odr->name}}</span></td>
                        <td>
                            <div class="sparkbar" data-color="#00a65a" data-height="20">{{$odr->total_price}}</div>
                        </td>
                    </tr>

                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.table-responsive -->
        </div>
        <!-- /.box-body -->
        <div class="box-footer clearfix">
            <a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-left">Place New Order</a>
            <a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-right">View All Orders</a>
        </div>
        <!-- /.box-footer -->
    </div>
    <!-- /.box -->
    </div>
@endsection

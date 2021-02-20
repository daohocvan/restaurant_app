@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Main Functions</a></li>
                        <li class="breadcrumb-item" aria-current="page"><a href="/report">Report</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Result</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
        <div class="col-md-12">
        @if($sales->count() > 0)
          <div class="alert alert-success" role="alert">
            <p>Total amount from {{$dateStart}} to {{$dateEnd}} is ${{number_format($totalSale, 2)}}</p>
            <p>Total result: {{$sales->total()}}</p>
          </div>
          <table class="table">
            <thead>
                <tr class="bg-primary text-light">
                    <th>#</th>
                    <th>Receipt ID</th>
                    <th>Date</th>
                    <th>Table</th>
                    <th>Staff</th>
                    <th>Total amount</th>
                </tr>
            </thead>
            <tbody>
                @php
                $count = ($sales->currentPage() -1) * $sales->perPage() + 1;
                @endphp
                @foreach($sales as $sale)
                    <tr class="bg-primary text-light">
                        <td>{{$count++}}</td>
                        <td>{{$sale->id}}</td>
                        <td>{{date("m/d/Y H:i:s", strtotime($sale->updated_at))}}</td>
                        <td>{{$sale->table_name}}</td>
                        <td>{{$sale->user_name}}</td>
                        <td>${{$sale->total_price}}</td>
                    </tr>
                    <tr>
                        <th></th>
                        <th>Menu ID</th>
                        <th>Menu</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total price</th>
                    </tr>
                    @foreach($sale->saleDetails as $saleDetail)
                    <tr>
                        <td></td>
                        <td>{{$saleDetail->id}}</td>
                        <td>{{$saleDetail->menu_name}}</td>
                        <td>{{$saleDetail->quantity}}</td>
                        <td>${{number_format($saleDetail->menu_price, 2)}}</td>
                        <td>${{number_format($saleDetail->quantity * $saleDetail->menu_price, 2)}}</td>
                    </tr>
                    @endforeach
                @endforeach
            </tbody>
          </table>
          {{$sales->appends($_GET)->links()}}
          <form action="/report/show/export" method="get">
            <input type="hidden" name="dateStart" value={{$dateStart}}>
            <input type="hidden" name="dateEnd" value={{$dateEnd}}>
            <input type="submit" value="Export to Excel" class="btn btn-success">
          </form>
          @else
          <div class="alert alert-danger" role="alert">
            Not found report
          </div>
          @endif
        </div>
        </div>
    </div>
@endsection

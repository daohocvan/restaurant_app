@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row" id="table-detail"></div>
        <div class="row justify-content-center">
           <div class="col-md-5">
            <button class="btn btn-primary btn-block" id="btn-show-tables">View All Tables</button>
            <div id="selected-table"></div>
            <div id="order-detail"></div>
           </div>

           <div class="col-md-7">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    @foreach($categories as $category)
                        <a class="nav-item nav-link" data-toggle="tab" id="{{$category->id}}">
                            {{$category->name}}
                        </a>
                    @endforeach
                </div>
            </nav>
            <div id="list-menu"></div>
           </div>
        </div>

    </div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Payment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h3 class="total"></h3>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">$
                </span>
               
            </div>
            <input type="number" id="recieved-amount" class="form-control" placeholder="Recieved amount">
        
        </div>
        <div class="form-group">
            <label for="payment-type">Payment Type</label><br>
            <select name="payment-type" id="payment-type" class="form-control">
                <option value="cash">Cash</option>
                <option value="credit card">Credit card</option>
            </select>
        </div>
        <h3 class="changeAmount"></h3>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn-save-payment">Save Payment</button>
      </div>
    </div>
  </div>
</div>
    <script>
        $(document).ready(function(){
            $("#table-detail").hide()

            //Show Tables
            $("#btn-show-tables").click(function(){
                if($("#table-detail").is(":hidden")){
                    $.get('/cashier/getTable', function(data){
                    $("#table-detail").html(data)
                    $("#table-detail").slideDown('fast')
                    $("#btn-show-tables").html('Hide Tables').removeClass('btn btn-primary').addClass('btn btn-danger')

                })
                }else{
                    $("#table-detail").slideUp('fast') 
                    $("#btn-show-tables").html('View All Tables').removeClass('btn btn-danger').addClass('btn btn-primary')
                }
              
            })

            //Get menu by category id
            $(".nav-link").click(function(){
                var id = $(this).attr('id');
                $.get('/cashier/getMenuByCategory/'+ id, function(data){
                    $("#list-menu").html(data)
                })
            })
            var table_id = ''
            var table_name = ''
            
            //Table detail
            $("#table-detail").on('click', '.btn-table', function(){
                table_id = $(this).attr('id')
                table_name = $(this).attr('name')
                $("#selected-table").html('<br><h3>Table: ' + table_name + '</h3><hr>')
                $.get("/cashier/getSaleDetail/" + table_id, function(data){
                    $("#order-detail").html(data)
                })
            })

            //Order food
            $("#list-menu").on('click', '.btn-menu', function(){
                if(table_id == ""){
                    alert("You need to select table")
                }
                else{
                   var menu_id = $(this).attr('id')
                   $.ajax({
                       type: 'POST',
                       data:{
                           "_token": $('meta[name="csrf-token"]').attr('content'),
                            "table_id" : table_id,
                            "table_name": table_name,
                            "menu_id": menu_id,
                            "quantity": 1
                       },
                       url: "/cashier/orderFood",
                       success: function(data){
                        $("#order-detail").html(data)
                       }
                   })
                }
                $.get('/cashier/getTable', function(data){
                    $("#table-detail").html(data)
                })
            })

            //Cofirm order status
            $("#order-detail").on('click', '.btn-order', function(){
                var sale_id = $(this).attr('id')
                $.ajax({
                    type: 'post',
                    data: {
                        "_token": $('meta[name="csrf-token"]').attr('content'),
                        "sale_id": sale_id,

                    },
                    url: '/cashier/confirmOrderStatus',
                    success: function(data){
                        $("#order-detail").html(data)
                    }
                })
               
            })

            //Delete order
            $("#order-detail").on('click', '.btn-delete-saledetail', function(){
               var sale_detail_id = $(this).attr('id')
                $.ajax({
                    'type': 'post',
                    'url': '/cashier/deleteSaleDetail',
                    'data': {
                        "_token": $('meta[name="csrf-token"]').attr('content'),
                        "sale_detail_id": sale_detail_id
                    },
                    success: function(data){
                        $("#order-detail").html(data)
                    }
                })
                $.get('/cashier/getTable', function(data){
                    $("#table-detail").html(data)
                })
            })

            //increase Quantity
            $("#order-detail").on('click', '.btn-increase-quantity', function(){
               var sale_detail_id = $(this).attr('id')
                $.ajax({
                    'type': 'post',
                    'url': '/cashier/increaseQuantity',
                    'data': {
                        "_token": $('meta[name="csrf-token"]').attr('content'),
                        "sale_detail_id": sale_detail_id
                    },
                    success: function(data){
                        $("#order-detail").html(data)
                    }
                })
            })

            //Decrease Quantity
            $("#order-detail").on('click', '.btn-decrease-quantity', function(){
               var sale_detail_id = $(this).attr('id')
                $.ajax({
                    'type': 'post',
                    'url': '/cashier/decreaseQuantity',
                    'data': {
                        "_token": $('meta[name="csrf-token"]').attr('content'),
                        "sale_detail_id": sale_detail_id
                    },
                    success: function(data){
                        $("#order-detail").html(data)
                    }
                })
                $.get('/cashier/getTable', function(data){
                    $("#table-detail").html(data)
                })
            })

            //Payment
            $("#order-detail").on('click', '.btn-payment', function(){
                var totalAmount = $(this).attr('totalAmount')
                $(".total").html('Total Amount: $' + totalAmount)
                $('#recieved-amount').val('')
                $(".changeAmount").html('')
            })

            //Recieved amount
            $('#recieved-amount').keyup(function(){
                var totalAmount = $('.btn-payment').attr('totalAmount')
                var recievedAmout = $(this).val()
                var change = recievedAmout - totalAmount
                if(change >= 0){
                    $(".changeAmount").html('Total change: $' + change)
                }
                else{
                    $(".changeAmount").html('')
                }
            })

            //Save payment
            $('.btn-save-payment').click(function(){
                var recievedAmout = $('#recieved-amount').val()
                var paymentType = $('#payment-type').val()
                var saleId = $('.btn-payment').attr('id')
                $.ajax({
                    type: 'POST',
                    url: '/cashier/savePayment',
                    data:{
                        "_token": $('meta[name="csrf-token"]').attr('content'),
                        'saleId': saleId,
                        'paymentType': paymentType,
                        'recievedAmout': recievedAmout,
                    },
                    success: function(data){
                        window.location.href = data
                    }
                })
            })
        })
    </script>
@endsection

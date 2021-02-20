<table>
    <thead>
    <tr>
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
        $count = 1;
    @endphp
    @foreach($sales as $sale)
        <tr>
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
    <tr>
        <td colspan="5">Total amount from {{$dateStart}} to {{$dateEnd}}</td>
        <td>${{number_format($totalSale, 2)}}</td>
    </tr>
    </tbody>
</table>


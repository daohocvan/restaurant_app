<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Menu;
use App\Table;
use App\Category;
use App\Sale;
use App\SaleDetail;
use Illuminate\Support\Facades\Auth;

class CashierController extends Controller
{
    public function index(){
        $categories = Category::all();
        return view('cashier.index', compact('categories'));
    }

    public function getTables(){
        $tables = Table::all()->sortBy('id');
        $html = '';
        foreach($tables as $table){
            $html .= '<div class="col-md-2 mb-4">';
            $html .=
            '<button class="btn btn-primary btn-table" id="' . $table->id .'" name = "' .$table->name .'" >
            <img class="table-image" src="'.url('/images/table.svg').'"/>
            <br>';
            if($table->status == "available"){
                $html .= '<span class="badge badge-success">' .$table->name .'</span>
                </button>';
            }
            else{
                $html .= '<span class="badge badge-danger">' .$table->name .'</span>
                </button>';
            }
            $html .= '</div>';
        }
        return $html;
    }

    public function getMenuByCategory($category_id){
        $menus = Menu::where('category_id', $category_id)->get();
        $html = '<div class="row">';
        foreach ($menus as $menu){
            $html .= '
            <div class="col-md-3 text-center">
                <a class="btn btn-outline-secondary btn-menu" id="'.$menu->id .'">
                <img class="img-fluid" src="'.url('/menu_images/' .$menu->image) .'">
                <br>'
                .$menu->name
                .'<br>
                $' .number_format($menu->price)
                .'</a>
            </div>';
        }
        $html .= "</div>";
        return $html;
    }

    public function orderFoods(Request $request){
        $menu = Menu::find($request->menu_id);
        $table_id = $request->table_id;
        $table_name = $request->table_name;
        $sale = Sale::where('table_id', $table_id)->where('sale_status', 'unpaid')->first();
        if(!$sale){
            $user = Auth::user();
            $sale = new Sale();
            $sale->table_id = $table_id;
            $sale->table_name = $table_name;
            $sale->user_id = $user->id;
            $sale->user_name = $user->name;
            $sale->save();
            $sale_id = $sale->id;
            $table = Table::find($table_id);
            $table->status = "unavailable";
            $table->save();
        }else{
            $sale_id = $sale->id;
        }
        $saleDetail = new SaleDetail();
        $saleDetail->sale_id = $sale_id;
        $saleDetail->menu_id = $menu->id;
        $saleDetail->menu_name = $menu->name;
        $saleDetail->menu_price = $menu->price;
        $saleDetail->quantity = $request->quantity;
        $saleDetail->save();

        $sale->total_price += ($request->quantity * $menu->price);
        $sale->save();
        $html = $this->getSaleDetails($sale_id);

        return $html;
    }

    public function getSaleDetailsByTable($table_id){
        $sale = Sale::where('table_id', $table_id)->where('sale_status', 'unpaid')->first();
        $html = '';
        if($sale){
            $sale_id = $sale->id;
            $html .= $this->getSaleDetails($sale_id);
        }
        else{
            $html .= 'Not found sale detail';
        }
        return $html;

    }

    private function getSaleDetails($sale_id){
        // $html = '<p>Sale ID: ' .$sale_id .'</p>';
        $saleDetails = SaleDetail::where('sale_id', $sale_id)->orderBy('id', 'asc')->get();
        $html = '<div class="table-responsive-md" style="overflow-y: scroll; height: 400px; border: 1px solid #343A40">
        <table class="table table-striped table-dark table-hover">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Menu</th>
                <th scope="col">Quantity</th>
                <th scope="col">Price</th>
                <th scope="col">Total</th>
                <th scope="col">Status</th>
            </tr>
        </thead>
        <tbody>';
        $showBtnPayment = true;
        foreach ($saleDetails as $saleDetail){
            $html .= '
                <tr>
                    <td>' .$saleDetail->id .'</td>
                    <td>' .$saleDetail->menu_name .'</td>
                    <td> <button id="' .$saleDetail->id .'"class="btn btn-primary btn-sm btn-decrease-quantity">-</button>' .$saleDetail->quantity .' <button id="' .$saleDetail->id .'"class="btn btn-primary btn-sm btn-increase-quantity">+</button></td>
                    <td>' .$saleDetail->menu_price .'</td>
                    <td>' .$saleDetail->menu_price * $saleDetail->quantity .'</td>';
                    if($saleDetail->status == 'noConfirm'){
                        $showBtnPayment = false;
                        $html .= '<td><a id="' .$saleDetail->id  .'" class="btn btn-danger btn-delete-saledetail"><i class="far fa-trash-alt"></i></a></td>';}
                    else{
                        $html .= '<td><i class="fas fa-check-circle"></i></td>';
                    }
                 $html .=  '</tr>';
        }
        $html .= '</tbody>
        </table>
        </div>';
        $sale = Sale::find($sale_id);
        $html .= '<hr>';
        $html .= '<h3>Total: $' .number_format($sale->total_price) .'</h3>';
        if($showBtnPayment){
            $html .= '<button id="'.$sale_id .'" totalAmount="' .number_format($sale->total_price) .'"class="btn btn-success btn-block btn-payment" data-toggle="modal" data-target="#exampleModal">Payment</button>';
        }
        else{
            $html .= '<button id="'.$sale_id .'" class="btn btn-primary btn-block btn-order">Confirm Order</button>';
        }
        return $html;
    }

    public function confirmOrderStatus(Request $request){
        $sale_id = $request->sale_id;
        $orderDetail = SaleDetail::where('sale_id', $sale_id)->update(['status' => 'confirm']);
        $html = $this->getSaleDetails($sale_id);
        return $html;
    }

    public function deleteSaleDetail(Request $request){
        $sale_detail_id = $request->sale_detail_id;
        $sale_detail = SaleDetail::find($sale_detail_id);

        $sale_id = $sale_detail->sale_id;
        $menu_price = $sale_detail->menu_price * $sale_detail->quantity;
        $sale_detail->delete();

        $sale = Sale::find($sale_id);
        $sale->total_price -= $menu_price;
        $sale->save();

        $saleDetails = SaleDetail::where('sale_id', $sale_id)->first();
        $count = SaleDetail::where('sale_id', $sale_id)->count();
        if($count == 0){
            $html = "Not found sale detail";
            $sale->delete();
            Table::where('id',$sale->table_id)->update(['status' => 'available']);
        }
        else{
            $html = $this->getSaleDetails($sale_id);
        }
        return $html;
    }

    public function savePayment(Request $request){
        $sale_id = $request->saleId;
        $payment_type = $request->paymentType;
        $received_amount = $request->recievedAmout;
        $sale = Sale::find($sale_id);
        $sale->total_recieved = $received_amount;
        $sale->payment_type = $payment_type;
        $sale->change = $received_amount - $sale->total_price;
        $sale->sale_status = 'paid';
        $sale->save();

        $table = Table::where('id', $sale->table_id)->update(['status' => 'available']);

        return "/cashier/showReceipt/" .$sale_id;
    }

    public function showReceipt($sale_id){
        $sale = Sale::find($sale_id);
        $saleDetails = SaleDetail::where('sale_id', $sale_id)->get();
        return view('cashier.showReceipt', compact('sale', 'saleDetails'));
    }

    public function increaseQuantity(Request $request){
        $sale_detail_id = $request->sale_detail_id;
        $saleDetail = SaleDetail::where('id', $sale_detail_id)->first();
        $saleDetail->quantity += 1;
        $saleDetail->save();

        $sale = Sale::where('id', $saleDetail->sale_id)->first();
        $sale->total_price += $saleDetail->menu_price;
        $sale->save();
        $html = $this->getSaleDetails($saleDetail->sale_id);
        return $html;
    }

    public function decreaseQuantity(Request $request){
        $sale_detail_id = $request->sale_detail_id;
        $saleDetail = SaleDetail::where('id', $sale_detail_id)->first();
        $sale = Sale::where('id', $saleDetail->sale_id)->first();
        if($saleDetail->quantity == 1){
            $saleDetail->delete();
            $count = SaleDetail::where('sale_id',  $saleDetail->sale_id)->count();

            if($count == 0){
                $html = "Not found sale detail";
                $sale->delete();
                Table::where('id',$sale->table_id)->update(['status' => 'available']);
            }
            else{
                $sale->total_price -= $saleDetail->menu_price;
                $sale->save();
                $html = $this->getSaleDetails($saleDetail->sale_id);
            }
        }
        else{
            $saleDetail->quantity -= 1;
            $saleDetail->save();
            $sale->total_price -= $saleDetail->menu_price;
            $sale->save();
            $html = $this->getSaleDetails($saleDetail->sale_id);
        }
        return $html;
    }
}

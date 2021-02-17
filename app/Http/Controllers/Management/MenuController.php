<?php

namespace App\Http\Controllers\Management;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Menu;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menus = Menu::all()->sortBy('id');
        return view("management.menu", compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('management.createMenu', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:menus|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required|numeric',
            'image' => 'required|file|image|mimes:jpeg,png,jpg|max:2000'
        ]);
    
        $imageName = date('dmYHi').uniqid(). '.' . $request->image->extension();
        $request->image->move(public_path('menu_images'), $imageName);
        
        $menu = new Menu;
        $menu->name = $request->name;
        $menu->price = $request->price;
        $menu->image = $imageName;
        $menu->description = $request->description;
        $menu->category_id = $request->category_id;
        $menu->save();
        $request->session()->flash('status', $request->name ." is saved successfully");
        return(redirect('/management/menu'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $menu = Menu::find($id);
        $categories = Category::all();
        return view('management.editMenu', compact('menu', 'categories'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required|numeric',
            'image' => 'file|image|mimes:jpeg,png,jpg|max:2000'
        ]);
        $menu = Menu::find($id);
        if($request->image){
            unlink(public_path('menu_images') .'/' .$menu->image);
            $imageName = date('dmYHi').uniqid(). '.' . $request->image->extension();
            $request->image->move(public_path('menu_images'), $imageName);
        }
        else{
            $imageName = $menu->image;
        }
    
        $menu->name = $request->name;
        $menu->price = $request->price;
        $menu->image = $imageName;
        $menu->description = $request->description;
        $menu->category_id = $request->category_id;
        $menu->save();
        $request->session()->flash('status', $request->name ." is updated successfully");
        return(redirect('/management/menu'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Menu::destroy($id);
        Session()->flash('status', "Menu is deleted successfully");
        return(redirect('/management/menu'));
    }
}

<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;

use App\Products;
use App\Categories;
use App\Sliders;
use App\Baskets;

class AjaxController extends Controller {
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function ReadMessage()
    {
        Messages::where('status',0)->update([
            'status'        => 1,
        ]);
        fopen('hgfhfg.txt','w');
    }
    public function Add_IMG(Request $request)
    {

        if ($request->hasFile('image')){
            $type = $request->file('image')->getClientOriginalExtension();
            $name = Auth::user()->id . '_' . time() . '.' . $type;
            $request->file('image')->move(public_path().'/uploads/images',$name);
            return response($name);
        }

    }
    public function Del_IMG(Request $request)
    {

        if ($request->post('img_name') != '')
        {
            unlink(public_path().'/uploads/images/'.$request->post('img_name'));
        }

    }
    public function Cat_Add_IMG(Request $request)
    {
        if ($request->post('id') != 'n'){
            $category_old_image = Categories::where('id',$request->post('id'))->first();
            @unlink(public_path().'/uploads/category/'.$category_old_image['icon']);
        }

        if ($request->hasFile('image')){

            $type = $request->file('image')->getClientOriginalExtension();
            $name = Auth::user()->id . '_' . time() . '.' . $type;
            $request->file('image')->move(public_path().'/uploads/category',$name);

            return response($name);
        }

    }
    public function Cat_Del_IMG(Request $request)
    {

        if ($request->post('img_name') != '')
        {
            unlink(public_path().'/uploads/category/'.$request->post('img_name'));
        }

    }
    public function Slider_Add_IMG(Request $request)
    {
        if ($request->hasFile('image')){

            $type = $request->file('image')->getClientOriginalExtension();
            $name = Auth::user()->id . '_' . time() . '.' . $type;
            $request->file('image')->move(public_path().'/uploads/slider',$name);

            return response($name);
        }

    }
    public function Slider_Del_IMG(Request $request)
    {
        if ($request->post('img_name') != '')
        {
            unlink(public_path().'/uploads/slider/'.$request->post('img_name'));
        }

    }
    public function Admin_Profile_Add_IMG(Request $request)
    {
        if ($request->hasFile('image')){

            $type = $request->file('image')->getClientOriginalExtension();
            $name = Auth::user()->id . '_' . time() . '.' . $type;
            $request->file('image')->move(public_path().'/Uploads/Admins/' . auth()->user()->id,$name);

            return response($name);
        }

    }

    public function Basket_Show(Request $request)
    {
        $basket = Baskets::where('user_id',$request->post('user_id'))->get();
        $pro_Array = array();
        foreach ($basket as $b){
            $products = Products::where('id',$b['product_id'])->first();
            $warranty_first = Warranties::where('id',$b['warranty_id'])->first();
            if ($products['product_icon'] != ''){
                $products_image = $products['product_icon'];
            }else{
                $products_image_array = json_decode($products['product_images'],true);
                $products_image = $products_image_array[0];
            }
            if (App::isLocale('en')){
                $title = $products['en_title'];
            } elseif(App::isLocale('fa')){
                $title = $products['fa_title'];
            } elseif(App::isLocale('ro')) {
                $title = $products['ro_title'];
            }
            if ($b['warranty_id'] == '0'){
                $warranty = __('GTF.Dont_Have');
            }else{
                $warranty = $warranty_first['company_name'];
            }
            $pro_Array[] = [
                'image'     => $products_image,
                'title'     => $title,
                'warranty'  => $warranty,
            ];
        }
        $data = json_encode($pro_Array,JSON_UNESCAPED_UNICODE);
        return response($data);
    }
    public function Post_Add_IMG(Request $request)
    {

        if ($request->hasFile('image')){
            $type = $request->file('image')->getClientOriginalExtension();
            $name = Auth::user()->id . '_' . time() . '.' . $type;
            $request->file('image')->move(public_path().'/uploads/posts/',$name);
            return response($name);
        }

    }
    public function Post_Del_IMG(Request $request)
    {

        if ($request->post('img_name') != '')
        {
            unlink(public_path().'/uploads/posts/'.$request->post('img_name'));
        }

    }
    public function Logo(Request $request)
    {
        if ($request->post('id') != 'n'){
            $category_old_image = Categories::where('id',$request->post('id'))->first();
            @unlink(public_path().'/uploads/logo/'.$category_old_image['icon']);
        }
        if ($request->hasFile('image')){

            $type = $request->file('image')->getClientOriginalExtension();
            $name = Auth::user()->id . '_' . time() . '.' . $type;
            $request->file('image')->move(public_path().'/uploads/logo',$name);

            return response($name);
        }
    }
    public function Del_Logo(Request $request)
    {

        if ($request->post('img_name') != '')
        {
            unlink(public_path().'/uploads/slider/'.$request->post('img_name'));
        }

    }
}
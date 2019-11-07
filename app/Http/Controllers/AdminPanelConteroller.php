<?php

namespace App\Http\Controllers;
use App\Supports;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controler;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


use Lang;
use App\Tasks;
use App\User;
use Symfony\Component\Console\Question\Question;


class AdminPanelConteroller extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(request $request)
    {
        $Content = Tasks::limit(5)->orderBy('id','DESC')->get();
        return view('auth.Dashboard',['Content' => $Content]);
    }


    public function message()
    {
        return [
            'name.required' => __('GTf.Name_Is_Required'),
            'name.min' => __('GTF.MIN_Name_Is_3'),
            'password.required' => __('GTF.Password_Is_Required'),
            'password.confirmed' => __('GTF.Password_Is_Confirmed'),
            'password.min' => __('GTF.Min_Password_Is_6'),
            'email.email' => __('GTF.Email_Is_Not_Email'),
            'email.unique' => __('GTF.Email_Is_Not_Unique'),
            'title.required' => __('GTF.Title_is_required'),
            'short_description.required' => __('GTF.Short_description_is_required'),
            'long_description.required' => __('GTF.long_description_is_required'),
            'price.required' => __('GTF.price_is_required'),
            'value.required' => __('GTF.image_is_required'),
            'image.required' => __('GTF.image_is_required'),
            'cat.required' => __('GTF.cat_is_required'),
            'tags.required' => __('GTF.Tags_is_required'),
        ];
    }
    /***************** start *****************/
    /******************************* profile **********************************/
    public function Admin_Profile(Request $request)
    {
        if ($request->isMethod('post')){
            if ($request->post('c_p') != ''){
                $request->validate([
                    'old_password'          => 'required',
                    'new_password'          => 'required|min:6',
                ]);
                if (!(Hash::check($request->post('old_password'),auth()->user()->password))){
                    return redirect('Profile')->with('messagee', __('old password is mistake'));
                }
                User::where('id',auth()->user()->id)->update([
                    'password'      => Hash::make($request->post('new_password')),
                ]);
                return redirect('Profile')->with('messages','successfully changed');
            }
            $request->validate([
                'name'          => 'required',
            ], $this->message());
            if ($request->avatar == ''){
                unlink(public_path().'/Uploads/Admins/' . auth()->user()->id.'/' . auth()->user()->avatar);
            }
            User::where('id',auth()->user()->id)->update([
                'name'      => $request->post('name'),
                'bio'       => $request->post('bio'),
                'avatar'    => $request->post('avatar'),
            ]);
            return redirect('Profile');
        }else {
            if (auth()->user()->avatar != '') {
                $admin_avatar_tag = '<div id="Admin_avatar_tag" class="card profile-user-img img-fluid img-circle" style="width:100px; height:100px; border: 0px solid #ccc;padding: 1px;border-radius: 3px;">
                            <img class="profile-user-img img-fluid img-circle" src="'. url('Uploads/Admins/' . auth()->user()->id.'/' . auth()->user()->avatar) .'" alt="">
                                                                                                            <div class="mr_full-width" onclick="ajax_delete()"><i class="fa fa-trash"></i></div>
                            </div>';
            } else {
                $admin_avatar_tag = '<div id="Admin_avatar_tag" class="profile-user-img img-fluid img-circle"><i class="fa fa-user-secret" style="font-size: 80px"></i></div>';
            }
            return view('auth.Admin_Profile', ['user' => auth()->user(), 'admin_avatar_tag' => $admin_avatar_tag]);
        }
    }
    public function Tasks(Request $request,$action = null,$pid = null){
        switch ($action){
            case "Add":
                if (!($request->isMethod('post'))){
                    if (@$request->d != ''){
                        return redirect('Dashboard')->with('messagee','you must send data with method post');
                    }
                    return redirect('Task/Add')->with('messagee','you must send data with method post');
                }
                $request->validate([
                    'title'          => 'required',
                ]);
                Tasks::create([
                    'user_id'       => auth()->user()->id,
                    'title'         => $request->post('title'),
                    'description'   => $request->post('description'),
                    'date'          => $request->post('date'),
                ]);
                if (@$request->d != ''){
                    return redirect('Dashboard')->with('messages','successfully added');
                }
                return redirect('Task/Add')->with('messages','successfully added');
                break;
            case "List":
                if (!($request->isMethod('get'))){
                    if (@$request->d != ''){
                        return redirect('Dashboard')->with('messagee','you must send data with method get');
                    }
                    return redirect('Task/Add')->with('messagee','you must send data with method get');
                }
                $Content = Tasks::get();
                return view('Task.List',['Content' => $Content,'count' => Tasks::count()]);
            case "Done":
                if (!($request->isMethod('get'))){
                    if (@$request->d != ''){
                        return redirect('Dashboard')->with('messagee','you must send data with method get');
                    }
                    return redirect('Task/Add')->with('messagee','you must send data with method get');
                }
                Tasks::where('id',$pid)->update([
                    'done'      => 1,
                ]);
                if (@$request->d != ''){
                    return redirect('Dashboard')->with('messages','successfully changed');
                }
                return redirect('Task/Add')->with('messages','successfully changed');
            case "Delete":
                if (!($request->isMethod('get'))){
                    if (@$request->d != ''){
                        return redirect('Dashboard')->with('messagee','you must send data with method get');
                    }
                    return redirect('Task/Add')->with('messagee','you must send data with method get');
                }
                Tasks::where('id',$pid)->delete();
                if (@$request->d != ''){
                    return redirect('Dashboard')->with('messages','successfully deleted');
                }
                return redirect('Task/Add')->with('messages','successfully deleted');
        }
    }
}
    /********************* created by MR(MohammadReza) **********
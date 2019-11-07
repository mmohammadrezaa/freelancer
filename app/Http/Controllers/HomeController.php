<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controler;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Morilog\Jalali;

use Lang;
use App\User_apps;
use App\User;
use App\Settings;
use App\Messages;
use App\Support_messages;
use App\Categories;
use App\Questions;
use App\Sliders;
use Symfony\Component\Console\Question\Question;


class HomeController extends Controller
{

    public function __construct()
    {
        App::setlocale('fa');
        $this->middleware('auth');
    }

    public function index(request $request)
    {


        return view('auth.Dashboard');
    }




    public function message()
    {
        return [
            'name.required'                     => __('GTf.Name_Is_Required'),
            'name.min'                          => __('GTF.MIN_Name_Is_3'),
            'password.required'                 => __('GTF.Password_Is_Required'),
            'password.confirmed'                => __('GTF.Password_Is_Confirmed'),
            'password.min'                      => __('GTF.Min_Password_Is_6'),
            'email.email'                       => __('GTF.Email_Is_Not_Email'),
            'email.unique'                      => __('GTF.Email_Is_Not_Unique'),
            'title.required'                    => __('GTF.Title_is_required'),
            'short_description.required'        => __('GTF.Short_description_is_required'),
            'long_description.required'         => __('GTF.long_description_is_required'),
            'price.required'                    => __('GTF.price_is_required'),
            'value.required'                    => __('GTF.image_is_required'),
            'image.required'                    => __('GTF.image_is_required'),
            'cat.required'                      => __('GTF.cat_is_required'),
            'tags.required'                     => __('GTF.Tags_is_required'),
            'options.required'                  => 'جواب سوال را وارد کنید',
            'correct.required'                  => 'پتسخ صحیح را انتخاب کنید',
            'active.required'                   => 'سوال را فعال یا غیر فعال کنید',
        ];
    }
    public function check_admin_access($section){
        $id = Auth::user()->id;
        $user = User::where('id',$id)->first();
        $access = json_decode($user['access'],true);
        $num = 0;
        if ($access != '') {
            foreach ($access as $a) {
                if ($a == $section) {
                    $num = 1;
                    break;
                } else {
                    $num = 2;
                }

            }
            if ($num == 1){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }






    /***************** start *****************/
    /***************** Update SQL ************/
    public function UpdateSQL(){
        $DB_HOST = env('DB_HOST', '127.0.0.1');
        $DB_PORT = env('DB_PORT', '3306');

        $DB =  env('DB_DATABASE', 'forge');
        $DB_USERNAME = env('DB_USERNAME', 'forge');
        $DB_PASSWORF = env('DB_PASSWORD', '');

        $content = mysqli_connect($DB_HOST,$DB_USERNAME,$DB_PASSWORF,$DB);
        $output= '';
        $count = 0;
        $file_dtabase = file(url('SQLs/NasimeYar.sql'));
        foreach($file_dtabase as $row){
            $start_char = substr(trim($row),0,2);
            if ($start_char != "--" || $start_char != "/*" || $start_char != "//" || $row != ''){
                $output = $output . $row;
                $end_char = substr(trim($row),-1,1);
                if ($end_char == ';'){
                    if (!mysqli_query($content,$output)){
                        $count++;
                    }
                    $output = "";
                }
            }
        }
        if ($count > 0){
            echo "there is an error in database import";
        }else{
            echo "database successfully imported";
        }
    }
    /***************** UM *******************************/
    public function UserManagement($pid=null)
    {
        if ($this->check_admin_access(7) == false) {
            return redirect('Admin/Dashboard')->with( 'messagee' , __('GTF.Dont_Access') );
        }
        if($pid == ''){
            $id = 0;
        }else{
            $id = ($pid-1)*10;
        }

        $User = User_apps::limit(10)->offset($id)->orderBy('id','DESC')->get();
        return view('auth.UserManagement', ['user_apps' => $User,'pid' => $pid]);
    }
    public function UserManagement_edit(request $request,$id)
    {
        if ($this->check_admin_access(7) == false) {
            return redirect('Admin/Dashboard')->with( 'messagee' , __('GTF.Dont_Access') );
        }
        $User = User_apps::where('id', $id)->first();
        $basket = Baskets::where('user_id',$id)->get();
        $reagent = User_apps::where('reagent', $User['id'])->get();
        if ($request->isMethod('post')) {
            User_apps::where('id', $id)->update([
                'first_name'    => $request->post('first_name'),
                'last_name'     => $request->post('last_name'),
                'birth'         => $request->post('birth'),
                'bank_card'     => $request->post('bank_card'),
                'sex'           => $request->post('gender'),
            ]);
            return redirect('/UserManagement')->with('messages', __('GTF.Successfully_Edited'));
        }
        return view('auth.UserManagementEdit', ['User' => $User,'basket' => $basket,'reagent' => $reagent]);
    }
    public function UserManagement_Deleted($id){
        if ($this->check_admin_access(7) == false) {
            return redirect('Admin/Dashboard')->with( 'messagee' , __('GTF.Dont_Access') );
        }
        if($id != ''){
            User_apps::where('id', $id)->delete();
            return redirect('/UserManagement')->with( 'messages' , __('GTF.Successfully_Deleted') );
        }else{
            return redirect('/UserManagement')->with( 'messagee' , __('GTF.Try_Again') );
        }
    }

    /********************** AUM   *******************************/

    public function AdminUserManagement($pid=null)
    {
        /*if ($this->check_admin_access(1) == false) {
            return redirect('Admin/Dashboard')->with( 'messagee' , __('GTF.Dont_Access') );
        }*/
        if($pid == ''){
            $id = 0;
        }else{
            $id = ($pid-1)*10;
        }
        $Content = User::limit(10)->offset($id)->orderBy('id','DESC')->get();
        return view('auth.A_U.A_U_Management', ['Content' => $Content,'pid' => $pid]);
    }
    public function AdminUserManagement_edit(Request $request,$id = null)
    {
        if ($this->check_admin_access(1) == false) {
            return redirect('Admin/Dashboard')->with( 'messagee' , __('GTF.Dont_Access') );
        }


        if ($id != '') {
            $Edit = User::where('id', $id)->first();
            if ($request->isMethod('post')) {
                $request->validate([
                    'name'                      => 'required|min:3',
                    'email'                     => 'required|email|unique:users',
                ],$this->message());
                User::where('id', $id)->update([
                    'name' => $request->post('name'),
                    'email' => $request->post('email'),
                    'active' => $request->post('active'),
                ]);
                return redirect('Admin/AdminUserManagement')->with('messages', __('GTF.Successfully_Edited'));
            }
            return view('auth.A_U.A_U_ManagementEdit', ['Edit' => $Edit]);
        }else {
            if ($request->isMethod('post')) {
                $request->validate([
                    'name'                      => 'required|min:3',
                    'email'                     => 'required|email|unique:users',
                    'password'                  => 'required|confirmed|min:6',
                ],$this->message());
                User::create([
                    'name'      => $request->post('name'),
                    'email'     => $request->post('email'),
                    'password'  => Hash::make($request->post('password')),
                    'active'    => $request->post('active'),
                ]);
                return redirect('Admin/AdminUserManagement')->with('messages', __('GTF.Successfully_Added'));
            }
            return view('auth.A_U.A_U_ManagementEdit', ['Add' => 1]);
        }
    }


    public function AdminUserManagement_Deleted($id){
        if ($this->check_admin_access(1) == false) {
            return redirect('Admin/Dashboard')->with( 'messagee' , __('GTF.Dont_Access') );
        }
        if($id != ''){
            User::where('id', $id)->delete();
            return redirect('Admin/AdminUserManagement')->with( 'messages' , __('GTF.Successfully_Deleted') );
        }else{
            return redirect('Admin/AdminUserManagement')->with( 'messagee' , __('GTF.Try_Again') );
        }
    }

    public function AdminUserManagement_Filter(request $request){
        if ($this->check_admin_access(1) == false) {
            return redirect('Admin/Dashboard')->with( 'messagee' , __('GTF.Dont_Access') );
        }
        if ($request->post('active') != '') {
            $user = User::where('name', 'like', '%' . $request->post('name') . '%')->where('email', 'like', '%' . $request->post('email') . '%')->where('active',$request->post('active'))->get();
        }else{
            $user = User::where('name', 'like', '%' . $request->post('name') . '%')->where('email', 'like', '%' . $request->post('email') . '%')->get();
        }
        return view('auth.A_U.A_U_Management', ['user' => $user,'f'=>1]);
    }
    public function AdminUserManagement_Access(request $request){
        if ($this->check_admin_access(1) == false) {
            return redirect('Admin/Dashboard')->with( 'messagee' , __('GTF.Dont_Access') );
        }
        User::where('id',$request->post('id'))->update(['access' => json_encode($request->post('access'),JSON_UNESCAPED_UNICODE)]);
        return redirect('Admin/AdminUserManagement')->with( 'messages' , __('GTF.Successfully_Edited') );
    }





    /* ***************************** support *********************************/
    public function Support($pid=null)
    {
        if ($this->check_admin_access(10) == false) {
            return redirect('/Dashboard')->with( 'messagee' , __('GTF.Dont_Access') );
        }
        if($pid == null || $pid == ''){
            $id = 0;
        }else{
            $id = ($pid*15)-1;
        }
        $users = User_apps::get();
        $supports = Support_messages::where('chat_id',0)->orderBy('id','DESC')->limit(15)->offset($id)->get();
        return view('auth.Support',['supports' => $supports,'users' => $users]);

    }
    public function Support_View(request $request,$id=null)
    {
        if ($this->check_admin_access(10) == false) {
            return redirect('/Dashboard')->with( 'messagee' , __('GTF.Dont_Access') );
        }
        if($request->post('send_answer') != ''){
            if($request->post('message') != ''){
                Support_messages::where('id',$id)->update(['status' => 'پاسخ داده شده']);
                Support_messages::create([
                    'message'           => $request->post('message'),
                    'admin_id'          => Auth::user()->id,
                    'chat_id'           => $id
                ]);
                return redirect('/Support_View/'.$id)->with( 'messages' , __('GTF.Successfully_Sent') );
            }else{
                return redirect('/Support_View/'.$id)->with( 'messagee' , __('GTF.Pls_Enter_Replay') );
            }
        }
        Support_messages::where('id',$id)->orwhere('chat_id',$id)->update(['seen' => 0]);
        if($id != 'filter'){
            if($request->get('pid') == ''){
                $pid = 0;
            }else{
                $pid = ($request->get('pid')*15)-1;
            }
            $support = Support_messages::where('id', $id)->first();
            $answers = Support_messages::where('chat_id',$id)->orwhere('id', $id)->limit(15)->offset($pid)->orderBy('id','ASC')->get();
            return view('auth.Answer_Support', ['answer' => $support, 'answers' => $answers,'pid' => $request->get('pid'), 'id' => $id]);
        }
        if ($id == 'filter'){
            if($request->post('title') !=''){
                $Support_filter = Support_messages::where('title','like', '%'.$request->post('title').'%');
            }
            if($request->post('date_az') !='' && $request->post('date_ta') !=''){
                $date1 = explode('/',@$request->post('date_az'));
                $date2 = explode('/',@$request->post('date_ta'));
                $date1 = implode("/",\Morilog\Jalali\CalendarUtils::toGregorian((int)$date1[0],(int)$date1[1],(int)$date1[2]));
                $date2 = implode("/",\Morilog\Jalali\CalendarUtils::toGregorian((int)$date2[0],(int)$date2[1],(int)$date2[2]));
                $Support_filter = Support_messages::where('created_at','>=',$date1)->where('created_at','<=',$date2);
            }
            $Support_filter = $Support_filter->get();
            return view('auth.Support', ['supports' => $Support_filter]);
        }
    }
    public function Support_Deleted(request $request ,$id = null){
        if ($this->check_admin_access(10) == false) {
            return redirect('/Dashboard')->with( 'messagee' , __('GTF.Dont_Access') );
        }
        if($id != ''){
            Support_messages::where('id', $id)->delete();
            Support_messages::where('chat_id', $id)->delete();
            return redirect('/Support')->with( 'messages' , __('GTF.Successfully_Deleted') );
        }else{
            return redirect('/Support')->with( 'messagee' , __('GTF.Try_Again') );
        }
    }
    public function Support_Block($id){
        if ($this->check_admin_access(10) == false) {
            return redirect('/Dashboard')->with( 'messagee' , __('GTF.Dont_Access') );
        }
        if($id != ''){
            Support_messages::where('chat_id', $id)->update(['status' => 3]);
            return redirect('/Support')->with( 'messages' , __('GTF.Successfully_Closed') );
        }else{
            return redirect('/Support')->with( 'messagee' , __('GTF.Try_Again') );
        }
    }
    public function Support_Pending($id){
        if ($this->check_admin_access(10) == false) {
            return redirect('/Dashboard')->with( 'messagee' , __('GTF.Dont_Access') );
        }

        if($id != ''){
            Support_messages::where('chat_id', $id)->update(['status' => 4]);
            return redirect('/Support')->with( 'messages' , __('GTF.Successfully_Closed') );
        }else{
            return redirect('/Support')->with( 'messagee' , __('GTF.Try_Again') );
        }
    }
    public function Support_Filter(request $request){
        if ($this->check_admin_access(10) == false) {
            return redirect('/Dashboard')->with( 'messagee' , __('GTF.Dont_Access') );
        }
        $users = User_apps::get();
        $supports = Support_messages::where('chat_id',0)->filter($request)->get();
        return  view('auth.Support', ['supports' => $supports,'users' => $users,'f' => 1]);
    }

    /************************************ category ****************************/
    public function Add_Category(Request $request,$id = null)
    {
        if ($this->check_admin_access(2) == false) {
            return redirect('/Dashboard')->with( 'messagee' , __('GTF.Dont_Access') );
        }

        $Category = Categories::get();
        if ($id == '') {
            if ($request->isMethod('post')) {
                $request->validate([
                    'title'                  	=> 'required',
                ],$this->message());

                $cat = Categories::create([
                    'admin_id'      => Auth::user()->id,
                    'title'      	=> $request->post('title'),
                    'head_category' => $request->post('head_category'),
                    'icon'          => $request->post('value'),
                    'active'        => $request->post('active'),
                ]);
                return redirect('Admin/Category/Edited/'.$cat['id'])->with('messages', __('GTF.Successfully_Added'));
            }
            return view('auth.Category.Category_Add', ['category' => $Category]);
        }else{
            $Edit = Categories::where('id',$id)->first();
            if ($request->isMethod('post')) {
                Categories::where('id',$id)->update([
                    'admin_id'      => Auth::user()->id,
                    'title'         => $request->post('title'),
                    'head_category' => $request->post('head_category'),
                    'icon'          => $request->post('value'),
                    'active'        => $request->post('active'),
                ]);
                return redirect('Admin/Category/Edited/'.$id)->with('messages', __('GTF.Successfully_Edited'));
            }
            return view('auth.Category.Category_Add', ['category' => $Category,'Edit' => $Edit]);
        }
    }
    public function List_Category($pid = null)
    {
        if ($this->check_admin_access(2) == false) {
            return redirect('/Dashboard')->with( 'messagee' , __('GTF.Dont_Access') );
        }
        if($pid == ''){
            $id = 0;
        }else{
            $id = ($pid-1)*10;
        }

        $cat = Categories::get();
        $Content = Categories::limit(10)->offset($id)->orderBy('id','DESC')->get();
        return view('auth.Category.Category_List', ['Content' => $Content,'cat' => $cat]);
    }
    public function Del_Category($id){
        if ($this->check_admin_access(2) == false) {
            return redirect('/Dashboard')->with( 'messagee' , __('GTF.Dont_Access') );
        }
        if($id != ''){
            Categories::where('id', $id)->delete();
            return redirect('Admin/Category/List')->with( 'messages' , __('GTF.Successfully_Deleted') );
        }else{
            return redirect('Admin/Category/List')->with( 'messagee' , __('GTF.Try_Again') );
        }
    }
    public function Filter_Category(request $request){
        if ($this->check_admin_access(2) == false) {
            return redirect('/Dashboard')->with( 'messagee' , __('GTF.Dont_Access') );
        }
        $cat = Categories::get();
        $Content = Categories::filter($request)->get();
        return view('auth.Category.Category_List', ['Content' => $Content,'f'=>1,'cat' => $cat]);
    }
    /******************** Questions ***********************/


    public function Add_Question(Request $request,$id = null)
    {
        if ($this->check_admin_access(4) === false) {
            return redirect('Admin/Dashboard')->with( 'messagee' , __('GTF.Dont_Access') );
        }


        $Questions = Questions::get();
        $Category = Categories::get();
        if ($id == '') {
            if ($request->isMethod('post')) {
                $request->validate([
                    'title'                     => 'required',
                    'bx'         => 'required',

                    'active'                     => 'required',
                    'categories'                  => "required"
                ],$this->message());

                $pro = Questions::create([
                    'admin_id'                  => Auth::user()->id,
                    'title'                     => $request->post('title'),
                    'options'                   => json_encode($request->post('bx')),
                    "categories"                => json_encode($request->post('categories')),
                    'active'                    => $request->post('active'),
                    "tags"                      => json_encode($request->post('tags')),
                ]);
                return redirect('Admin/Question/Edited/' . $pro['id'])->with('messages', __('GTF.Successfully_Added'));
            }
            return view('auth.Question.Question_Add', ['Question' => $Questions,'Category' => $Category, "Edit" => ""]);
        }else{
            $Edit = Questions::where('id',$id)->first();
            if ($request->isMethod('post')) {
                $request->validate([
                    'title'                     => 'required',
                    'bx'         => 'required',
                    'active'                     => 'required',
                    'categories'                  => "required"
                ],$this->message());
                $pro = Questions::where('id',$id)->update([
                    'admin_id'                  => Auth::user()->id,
                    'title'                     => $request->post('title'),
                    'options'                   => json_encode($request->post('bx')),
                    "categories"                => json_encode($request->post('categories')),
                    'active'                    => $request->post('active'),
                    "tags"                      => json_encode($request->post('tags')),

                ]);
                return redirect('Admin/Question/Edited/' . $id)->with('messages', __('GTF.Successfully_Added'));
            }
            return view('auth.Question.Question_Add', ['Question' => $Questions,'Edit' => $Edit,'Category' => $Category]);
        }
    }
    public function List_Question($pid = null)
    {
        if ($this->check_admin_access(4) == false) {
            return redirect('Admin/Dashboard')->with( 'messagee' , __('GTF.Dont_Access') );
        }
        if($pid == ''){
            $id = 0;
        }else{
            $id = ($pid-1)*10;
        }
        $Category = Categories::get();
        $Content = Questions::limit(10)->offset($id)->orderBy('id','DESC')->get();
        $count = Questions::get();
        return view('auth.Question.Question_List', ['Content' => $Content,'cat' => $Category,"Content_Count" => count($count)]);
    }
    public function Del_Question($id){
        if ($this->check_admin_access(4) == false) {
            return redirect('Admin/Dashboard')->with( 'messagee' , __('GTF.Dont_Access') );
        }
        if($id != ''){
            Questions::where('id', $id)->delete();
            return redirect('Admin/Questions/List')->with( 'messages' , __('GTF.Successfully_Deleted') );
        }else{
            return redirect('Admin/Questions/List')->with( 'messagee' , __('GTF.Try_Again') );
        }
    }
    public function Filter_Question(request $request){
        if ($this->check_admin_access(4) == false) {
            return redirect('Admin/Dashboard')->with( 'messagee' , __('GTF.Dont_Access') );
        }
        $Category = Categories::get();
        $Content = Questions::filter($request)->get();
        return  view('auth.Questions.Questions_List', ['Content' => $Content,'f' => 1,'cat' => $Category]);
    }

    /************************* comments ********************/
    public function Comments($pid = null){
        if ($this->check_admin_access(3) == false) {
            return redirect('Admin/Dashboard')->with( 'messagee' , __('GTF.Dont_Access') );
        }
        if($pid == ''){
            $id = 0;
        }else{
            $id = ($pid-1)*10;
        }
        Comments::where('status',4)->update([
            'status' => 3
        ]);
        Comments::where('status',0)->update([
            'status' => 4
        ]);
        $Comments = Comments::limit(10)->offset($id)->orderBy('id','DESC')->get();
        return view('auth.User_Comments',['Comments' => $Comments]);
    }
    public function Del_Comments($id){
        if ($this->check_admin_access(3) == false) {
            return redirect('/Dashboard')->with( 'messagee' , __('GTF.Dont_Access') );
        }
        if($id != ''){
            Comments::where('id', $id)->delete();
            return redirect('/Comments')->with( 'messages' , __('GTF.Successfully_Deleted') );
        }else{
            return redirect('/Comments')->with( 'messagee' , __('GTF.Try_Again') );
        }
    }
    public function Status_Comments($status,$id){
        if ($this->check_admin_access(3) == false) {
            return redirect('/Dashboard')->with( 'messagee' , __('GTF.Dont_Access') );
        }
        switch ($status){
            case "Deleted":
                Comments::where('id', $id)->delete();
                return redirect('/Comments')->with( 'messages' , __('GTF.Successfully_Deleted') );
                break;
            case "Confirm":
                Comments::where('id', $id)->update(['status' => 1]);
                return redirect('/Comments')->with( 'messages' , __('GTF.Message_Was_Confirmed ') );
                break;
            case "Reject":
                Comments::where('id', $id)->update(['status' => 2]);
                return redirect('/Comments')->with( 'messages' , __('GTF.Message_Was_Rejected') );
                break;
        }
    }
    /************************************ slider ****************************/
    public function Add_Slider(Request $request,$id = null)
    {
        if ($this->check_admin_access(1) == false) {
            return redirect('/Dashboard')->with( 'messagee' , __('GTF.Dont_Access') );
        }
        $this->chech_lan();
        if ($id == '') {

            if ($request->isMethod('post')) {
                $request->validate([
                    'en_title'                  => 'required',
                    'fa_title'                  => 'required',
                    'ro_title'                  => 'required',
                    'image'                     => 'required',
                ],$this->message());
                $sli = Sliders::create([
                    'admin_id'      => Auth::user()->id,
                    'en_title'      => $request->post('en_title'),
                    'fa_title'      => $request->post('fa_title'),
                    'ro_title'      => $request->post('ro_title'),
                    'link'          => $request->post('link'),
                    'view_order'    => $request->post('view_order'),
                    'image'         => $request->post('value'),
                    'active'        => $request->post('active'),
                ]);
                return redirect('/Slider/Edited/'.$sli['id'])->with('messages', __('GTF.Successfully_Added'));
            }
            return view('auth.Slider_Add');
        }else{
            $sli = Sliders::where('id',$id)->first();
            if ($request->isMethod('post')) {
                Sliders::where('id',$id)->update([
                    'admin_id'      => Auth::user()->id,
                    'en_title'      => $request->post('en_title'),
                    'fa_title'      => $request->post('fa_title'),
                    'ro_title'      => $request->post('ro_title'),
                    'link'          => $request->post('link'),
                    'view_order'    => $request->post('view_order'),
                    'image'         => $request->post('value'),
                    'active'        => $request->post('active'),
                ]);
                return redirect('/Slider/Edited/'.$id)->with('messages', __('GTF.Successfully_Edited'));
            }
            return view('auth.Slider_Add', ['sli' => $sli]);
        }
    }
    public function List_Slider($pid = null)
    {
        if ($this->check_admin_access(1) == false) {
            return redirect('/Dashboard')->with( 'messagee' , __('GTF.Dont_Access') );
        }
        if($pid == ''){
            $id = 0;
        }else{
            $id = ($pid-1)*10;
        }
        $this->chech_lan();
        $Slider = Sliders::limit(10)->offset($id)->orderBy('id','DESC')->get();
        return view('auth.Slider_List', ['Sliders' => $Slider]);
    }
    public function Del_Slider($id){
        if ($this->check_admin_access(1) == false) {
            return redirect('/Dashboard')->with( 'messagee' , __('GTF.Dont_Access') );
        }
        if($id != ''){
            Sliders::where('id', $id)->delete();
            return redirect('/Slider/List')->with( 'messages' , __('GTF.Successfully_Deleted') );
        }else{
            return redirect('/Slider/List')->with( 'messagee' , __('GTF.Try_Again') );
        }
    }



    //**************** Setting *********************************/
    public function Setting(request $request)
    {

        $title = Settings::where('key','title')->value('value');
        $logo = Settings::where('key','logo')->value('value');
        return view("auth.Settings.Setting",[
            'title'  => $title ,
            'logo'   => $logo,
        ]);
    }
    public function Setting_Edit(request $request)
    {
        if ($request->post('title') != ''){
            Settings::where('key','title')->update(['value' => $request->post('title')]);
        }

//        if ($request->post('register_gift_rial') != ''){
//            Settings::where('key','register_gift_rial')->update(['value' => $request->post('register_gift_rial')]);
//        }
//        if ($request->post('rules_en') != ''){
//            Settings::where('key','rules_en')->update(['value' => $request->post('rules_en')]);
//        }
//        if ($request->post('rules_ru') != ''){
//            Settings::where('key','rules_ru')->update(['value' => $request->post('rules_ru')]);
//        }
//        if ($request->post('rules_fa') != ''){
//            Settings::where('key','rules_fa')->update(['value' => $request->post('rules_fa')]);
//        }
//        if ($request->post('contact_us_en') != ''){
//            Settings::where('key','contact_us_en')->update(['value' => $request->post('contact_us_en')]);
//        }
//        if ($request->post('contact_us_ru') != ''){
//            Settings::where('key','contact_us_ru')->update(['value' => $request->post('contact_us_ru')]);
//        }
//        if ($request->post('contact_us_fa') != ''){
//            Settings::where('key','contact_us_fa')->update(['value' => $request->post('contact_us_fa')]);
//        }
        return redirect("Admin/Settings");
    }


}
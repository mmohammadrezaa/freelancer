<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 2019-10-16
 * Time: 10:33 PM
 */

namespace App\Libraries;


use App\Categories;

class sub_cat
{
    private $mr_cat_arr = array();
    private $html_code = '';
    private $hid = '';
    private $input_type = '';
    private $num = 0;
    private $sub = -1;
    private $input_name = '';
    public function sub_cat($cid,$input_type=null,$input_name = null,$hid = null){
        $onclick = null;
        $this->num++;
        if ($hid != ''){
            $this->hid = $hid;
        }
        if ($input_type != ''){
            $this->input_type = $input_type;
        }
        if ($input_name != ''){
            $this->input_name = $input_name;
        }
        $self = \App\Categories::where("id",$cid)->first();
        $sub = \App\Categories::where("head_category",$cid)->get();
        if (count($sub) > 0){
            $this->subs_category($cid);
        }

        if ($this->input_type == "checkbox"){
            $onclick = "data=" . $this->num . "|" . $this->sub ."|" . $self['id'];
            //$onclick = 'onclick="category_input_checker('.$this->num.','.$this->sub.')"';
        }
        $this->sub = 0;
        $checked = null;
        if ($this->hid == $self['id']){
            $checked = "checked";
        }
        if (count($sub) <= 0){
            $html = "<li><input id=\"input_category_".$this->num."\" type=\"".$this->input_type."\" class=\"minimal\" name=\"".$this->input_name."\" value=\"".$self['id']."\" ".$checked." ".$onclick."> ".$self['title']."</li>";
            return $html;
        }else{
            return '<li><input id="input_category_'.$this->num.'" type="'.$this->input_type.'" class="minimal" name="'.$this->input_name.'" value="'.$self['id'].'" '.$checked.' '.$onclick.'>  '.$self['title'].'
                                                        <ul class="list mr-4">
                                                        '.$this->loop($sub).'
                                                        </ul>
                                                    </li>';

        }
    }
    public function remove_html_code(){
        $this->html_code = null;
    }
    public function loop($sub){
        $html_code = '';
        foreach ($sub as $S) {
            $html_code .= $this->sub_cat($S['id']);
        }
        return $html_code;
    }
    public function subs_category($id=null){
        $count = Categories::where("head_category",$id)->get();
        if (count($count) <= 0){
            return 1;
        }
        foreach ($count as $C){
            $this->sub += $this->subs_category($C['id']);
        }
        return count($count);
    }
}


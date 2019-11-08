<?php
/* ersadid.com */

namespace App\Libraries;

class Gh_class {
    public function pagination($item_count, $limit, $cur_page, $link){
        if(empty($cur_page)){
            $cur_page = 1;
        }
        $page_count = ceil($item_count/$limit);
        $current_range = array(($cur_page-2 < 1 ? 1 : $cur_page-2), ($cur_page+2 > $page_count ? $page_count : $cur_page+2));

        $first_page = $cur_page > 3 ? '<li class="page-item"><a class="page-link" href="'.sprintf($link, '1').'">1</a></li>'.($cur_page < 5 ? '' : ' <li class="page-item"><a class="page-link" href="#">...</a></li> ') : null;
        $last_page = $cur_page < $page_count-2 ? ($cur_page > $page_count-4 ? '' : ' <li class="page-item"><a href="#">...</a></li> ').'<li class="page-item"><a class="page-link" href="'.sprintf($link, $page_count).'">'.$page_count.'</a></li>' : null;

        $previous_page = $cur_page > 1 ? '<li class="page-item"><a class="page-link" href="'.sprintf($link, ($cur_page-1)).'">&laquo;</a></li>' : null;

        //$previous_page = $cur_page > 1 ? '<li class="page-item"><a  class="page-link" href="'.sprintf($link, ($cur_page-1)).'">قبلی</a></li> ' : null;
        $next_page = $cur_page < $page_count ? '<li class="page-item"><a class="page-link" href="'.sprintf($link, ($cur_page+1)).'">&raquo;</a></li>' : null;

        for ($x=$current_range[0];$x <= $current_range[1]; ++$x)
            $pages[] = '<li class="page-item"><a class="page-link" href="'.sprintf($link, $x).'">'.($x == $cur_page ? '<strong>'.$x.'</strong>' : $x).'</a></li>';

        if ($page_count > 1)
            echo '<div><ul class="pagination pagination-sm m-0">'.$previous_page.$first_page.implode('', $pages).$last_page.$next_page.'</ul></div>';
    }
}
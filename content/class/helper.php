<?php
	function option($key, $value, $selected = NULL){
		return '<option value="'.$value.'" '.($selected!=NULL&&$value==$selected ? 'selected' : '').'>'.$key.'</option>';
	}

	function empty_row($span, $object){
		return '<tr><td colspan="'.$span.'" class="text-center">No '.$object.'(s) found.</td></tr>';
	}

	function row($data, $class = NULL, $id = NULL, $trClass = NULL){
		$row = '<tr'.($id ? ' id="'.$id.'"' : '').''.($trClass ? ' class="'.$trClass.'"' : '').'>';
		for($x=0; $x<sizeof($data); $x++){
			$row.='<td class="'.( $class == NULL ? '' : $class[$x]).'">'.$data[$x].'</td>';
		}
		return $row.'</tr>';
	}

	function hidden($selector, $value = NULL){
		return input($selector, $value, 'hidden');
	} 

	function anchor($url, $str, $class = NULL){
		return '<a href="'.$url.'" class="'.$class.'">'.$str.'</a>';
	}

	function input($selector, $value = NULL, $type = 'text', $class = '', $attr = ''){
		return '<input type="'.$type.'" id="'.$selector.'" name="'.$selector.'" class="'.$class.'" '.$attr.' value="'.$value.'">';
	}

	function checkbox($selector, $value = NULL, $class = '', $attr = ''){
		return input($selector, $value, 'checkbox', $class, $attr);
	}

	function button($selector, $value = NULL, $text = 'Click me', $type = 'button', $attr = '', $class = ''){
		return '<button type="'.$type.'" class="'.$class.'" id="'.$selector.'" name="'.$selector.'" value="'.$value.'" '.$attr.'>'.$text.'</button>';
	}

	function textarea($selector, $value = NULL,  $class = '', $attr = '', $rows = '8'){
		return '<textarea class="'.$class.'" rows="'.$rows.'" id="'.$selector.'" name="'.$selector.'" '.$attr.'>'.$value.'</textarea>';
	}

	function is_form_submitted(){
		if(isset($_POST['submit'])){
			return true;
		}
		else{
			return false;
		}
	}

	function row_specs($caption, $val, $width1 = NULL, $width2 = NULL){
		return '<tr>
			<th '.($width1 ? 'style="width:'.$width1.'%;"' : '').'>'.$caption.'</th>
			<td '.($width2 ? 'style="width:'.$width2.'%;"' : '').'>'.$val.'</td>
		</tr>';
	}

	function array_to_ul($array){
		$str = '<ul>';
		foreach ($array as $data) {
			$str.= '<li>'.$data.'</li>';
		}
		$str.= '</ul>';
		return $str;
	}

	function _export_buttons($url_query, $size = 'btn-md'){
		$output = '<div class="btn-group">';
		$output.= '<a href="'.ROOT.'print.php?'.$url_query.'" class="btn btn-default '.$size.'"><i class="fa fa-fw fa-print"></i> Print</a>';
		$output.= '<a href="'.ROOT.'word.php?'.$url_query.'" class="btn btn-primary '.$size.'"><i class="fa fa-fw fa-file-word-o"></i> Word</a>';
		$output.= '<a href="'.ROOT.'excel.php?'.$url_query.'" class="btn btn-success '.$size.'"><i class="fa fa-fw fa-file-excel-o"></i> Excel</a>';
		$output.= '</div>';
		return $output;
	}

	function export_buttons($url_query){
		return _export_buttons($url_query);
	}

	function export_dropdown($url_query){
		$print = '<a href="'.ROOT.'print.php?'.$url_query.'"><i class="fa fa-fw fa-print"></i> Print</a>';
		$word = '<a href="'.ROOT.'word.php?'.$url_query.'"><i class="fa fa-fw fa-file-word-o"></i> Word</a>';
		$excel = '<a href="'.ROOT.'excel.php?'.$url_query.'"><i class="fa fa-fw fa-file-excel-o"></i> Excel</a>';
		$pdf = '<a href="'.ROOT.'pdf.php?'.$url_query.'"><i class="fa fa-fw fa-file-pdf-o"></i> PDF</a>';
		$links = array($print, $word, $excel, $pdf);
		$_links = ''; 
		foreach ($links as $link) {
			$_links.= '<li>'.$link.'</li>';
		}
		$dropdown = '<div class="dropdown">
                    <button class="btn btn-default btn-md dropdown-toggle" type="button" data-toggle="dropdown">
                        <i class="fa fa-fw fa-file-text-o"></i> Export
                    </button>
                    <ul class="dropdown-menu">
                    '.$_links.'
                    </ul>
                    </div>';
        return $dropdown;
	}

	function dropdown($links){
		$_links = '';
		foreach ($links as $link) {
			$_links.= '<li>'.$link.'</li>';
		}
		$dropdown = '<div class="dropdown">
                    <button class="btn btn-primary btn-xs dropdown-toggle" type="button" data-toggle="dropdown">
                        <i class="fa fa-fw fa-gear"></i>
                    </button>
                    <ul class="dropdown-menu">
                    '.$_links.'
                    </ul>
                    </div>';
        return $dropdown;
	}
	
	function addZero($val, $size=3){
		$str = "";
		$strVal = $val . "";
		for ($x=$size; $x > strlen($strVal) ; $x--) { 
			$str.= "0";
		}
		$str.= $strVal;
		return $str;
	}
?>
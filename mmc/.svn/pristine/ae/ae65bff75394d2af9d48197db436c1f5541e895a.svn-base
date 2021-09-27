<?php
function buildMenu()
{
	$menu = '';
	$CI =& get_instance();    
	$CI->load->model('admin/M_menu','',TRUE);
	
	$datas = $CI->M_menu->get_allowed_menu(0);
	
	foreach($datas->result() as $data)
	{
		if ($data->is_parent == 0){
			$menu.= '<li><a href="#" onClick="return openUrl(\''.site_url($data->url).'\');"><i class="fa fa-'.$data->icon.'"></i> <span>'.$data->title.'</span></a></li>';
		}else{
			$menu.= '<li class="treeview">
						  <a href="#">
							<i class="fa fa-'.$data->icon.'"></i> <span>'.$data->title.'</span> <i class="fa fa-angle-left pull-right"></i>
						  </a>
						  <ul class="treeview-menu">';
			$datasc = $CI->M_menu->get_allowed_menu($data->page_id);
			foreach($datasc->result() as $datac)
			{
				$menu.='<li><a href="#" onClick="return openUrl(\''.site_url($datac->url).'\');">'.$datac->title.'</a></li>';
			}
			$menu.=	'	  </ul>';
			$menu.= '</li>';
		}
	}
	
	return $menu;
}

function buildBreadcrumb()
{
	$out = '<li><a href="'.site_url().'"><i class="fa fa-home"></i> Home</a></li>';
	$CI =& get_instance();    
	$CI->load->model('admin/M_menu','',TRUE);
	$url = $CI->uri->uri_string();
	
	if ($url=='')
		$out.= '<li class="active"> Beranda</li>';
	else
	{
		$datas = $CI->M_menu->get_breadcrumb($url);
		foreach($datas->result() as $data)
		{
			if ($data->parent_id == 0){
				$out.= '<li class="active"> '.$data->title.'</li>';
			}else{
				$out.= '<li><a href="'.site_url($data->url).'">'.$data->ptitle.'</a></li>';
				$out.= '<li class="active">'.$data->title.'</li>';
			}
		}
	}
	return $out;
}

function sortMenu()
{
	$menu = '';
	$CI =& get_instance();    	
	$CI->load->model('admin/M_menu','',TRUE);
	$datas = $CI->M_menu->get_child(0);
	
	foreach($datas->result() as $data)
	{
		$menu.= '<div class="s_panel" id="id_'.$data->page_id.'">
					<div class="h3">'.$data->title.'
						<span class="pull-right">
						<a href="#" title="Edit" onClick="return editMenu('.$data->page_id.');"><i class="fa fa-edit fa-fw"></i></a>
						&nbsp;
						<a href="#" title="Hapus" onClick="return dropMenu('.$data->page_id.');"><i class="fa fa-trash fa-fw"></i></a>
						</span>
					</div>';
		if ($data->is_parent == 1){
			$menu.= '<div>';
			$menu.= '	<ul class="sortable">';
			$datasc = $CI->M_menu->get_child($data->page_id);
			foreach($datasc->result() as $datac)
			{
				$menu.='<li class="ui-state-default" id="id_'.$datac->page_id.'"><span class="ui-icon ui-icon-arrowthick-2-n-s pull-left"></span>'.$datac->title.'
							<span class="pull-right">
								<a href="#" title="Edit" onClick="return editMenu('.$datac->page_id.');"><i class="fa fa-edit fa-fw"></i></a>
								&nbsp;
								<a href="#" title="Hapus" onClick="return dropMenu('.$datac->page_id.');"><i class="fa fa-trash fa-fw"></i></a>
							</span>
						</li>';
			}
			$menu.= '	</ul>
					 </div>';
		}
		$menu.= '</div>';
	
	}
	
	return $menu;
}
?>
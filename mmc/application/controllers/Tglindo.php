<?php
class tglindo{
	//////////////////////////////////////////////////////////////////////////
	public function hari($inp)
	{
		if ($inp == 1)
		{
			return "Senin ";
		}
		else if ($inp == 2)
		{
			return "Selasa ";
		}
		else if ($inp == 3)
		{
			return "Rabu ";
		}
		else if ($inp == 4)
		{
			return "Kamis ";
		}
		else if ($inp == 5)
		{
			return "Jumat ";
		}
		else if ($inp == 6)
		{
			return "Sabtu ";
		}
		else if ($inp == 7)
		{
			return "Minggu ";
		}		
		else
		{
			return "";
		}
	}

	public function bulan($inp)
	{
		if ($inp == 1)
		{
			return "Januari ";
		}
		else if ($inp == 2)
		{
			return "Februari ";
		}
		else if ($inp == 3)
		{
			return "Maret ";
		}
		else if ($inp == 4)
		{
			return "April ";
		}
		else if ($inp == 5)
		{
			return "Mei ";
		}
		else if ($inp == 6)
		{
			return "Juni ";
		}
		else if ($inp == 7)
		{
			return "July ";
		}
		else if ($inp == 8)
		{
			return "Agustus ";
		}
		else if ($inp == 9)
		{
			return "September ";
		}
		else if ($inp == 10)
		{
			return "Oktober ";
		}
		else if ($inp == 11)
		{
			return "November ";
		}
		else if ($inp == 12)
		{
			return "Desember ";
		}				
		else
		{
			return "";
		}
	}	
	
	
	public function tgl_indo($d='',$m='',$y='')
	{
		//
	}
}
?>

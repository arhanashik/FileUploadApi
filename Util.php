<?php

class Util
{
	public function getFileExtension($file)
	{
		$path_parts = pathinfo($file);
		return $path_parts['extension'];
	}
	
	public function reArrayFiles($files)
	{
		$file_ary = array();
		$file_count = count($files['name']);
		$file_key = array_keys($files);
		
		for($i=0; $i<$file_count; $i++)
		{
			foreach($file_key as $val)
			{
				$file_ary[$i][$val] = $files[$val][$i];
			}
		}
		return $file_ary;
	}
}
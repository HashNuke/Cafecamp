<?php

function scaleImage($image,$width,$height,$scale,$i_type) {

	$newImageWidth = ceil($width * $scale);
	$newImageHeight = ceil($height * $scale);
	$newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
	
	if($i_type=="image/jpeg" || $i_type=="image/pjpeg")
	{
		$source = imagecreatefromjpeg($image);
	}
	else if($i_type=="image/png")
	{
		$source = imagecreatefrompng($image);
	}
	else
	{
		/* we assume its GIF */
		$source = imagecreatefromgif($image);
	}
		
	imagecopyresampled($newImage,$source,0,0,0,0,$newImageWidth,$newImageHeight,$width,$height);
	
	if($i_type=="image/jpeg" || $i_type=="image/pjpeg")
	{
		imagejpeg($newImage,$image,90);
	}
	else if($i_type=="image/png")
	{
		imagepng($newImage,$image);
	}
	else
	{
		/* we assume its GIF */
		imagegif($newImage,$image,90);
	}
	
	
	chmod($image, 0777);
	return $image;
}

function getHeight($image) {
	$size = array_values(getimagesize($image));
	list($width,$height,$type,$attr) = $size;
	return $height;
}

function getWidth($image) {
	$size = array_values(getimagesize($image));
	list($width,$height,$type,$attr) = $size;
	return $width;
}

/* Credit: http://php.mainseek.com/manual/en/function.imagerotate.php#73446 */
function rotate($image,$degrees)
    {
        if(function_exists("imagerotate"))
            $image = imagerotate($image, $degrees, 0);
        else
        {
            function imagerotate($src_img, $angle)
            {
                $src_x = imagesx($src_img);
                $src_y = imagesy($src_img);
                if ($angle == 180)
                {
                    $dest_x = $src_x;
                    $dest_y = $src_y;
                }
                elseif ($src_x <= $src_y)
                {
                    $dest_x = $src_y;
                    $dest_y = $src_x;
                }
                elseif ($src_x >= $src_y) 
                {
                    $dest_x = $src_y;
                    $dest_y = $src_x;
                }
               
                $rotate=imagecreatetruecolor($dest_x,$dest_y);
                imagealphablending($rotate, false);
               
                switch ($angle)
                {
                    case 270:
                        for ($y = 0; $y < ($src_y); $y++)
                        {
                            for ($x = 0; $x < ($src_x); $x++)
                            {
                                $color = imagecolorat($src_img, $x, $y);
                                imagesetpixel($rotate, $dest_x - $y - 1, $x, $color);
                            }
                        }
                        break;
                    case 90:
                        for ($y = 0; $y < ($src_y); $y++)
                        {
                            for ($x = 0; $x < ($src_x); $x++)
                            {
                                $color = imagecolorat($src_img, $x, $y);
                                imagesetpixel($rotate, $y, $dest_y - $x - 1, $color);
                            }
                        }
                        break;
                    case 180:
                        for ($y = 0; $y < ($src_y); $y++)
                        {
                            for ($x = 0; $x < ($src_x); $x++)
                            {
                                $color = imagecolorat($src_img, $x, $y);
                                imagesetpixel($rotate, $dest_x - $x - 1, $dest_y - $y - 1, $color);
                            }
                        }
                        break;
                    default: $rotate = $src_img;
                };
                return $rotate;
            }
            $image = imagerotate($image, $degrees);
        }
				return $image;
    }

function rotateImage($source,$destination,$degrees) {
	copy($source,$destination);
	chmod($destination,0777);
	$final = imagecreatefromjpeg($destination);
	$final = rotate($final,$degrees);
	imagejpeg($final,$destination);
}

?>
<?php
define('ERRORS', 1);
define('DEBUG', TRUE);

if (ERRORS == 1) {
	ini_set('error_repoting',E_ALL);        //on
	ini_set('display_errors','on');
} else {
	ini_set('display_errors','off');
}

if(strtolower($_SERVER['REQUEST_METHOD']) != 'post' ){
	exit_status('Error! Wrong HTTP method!');
}
	$path = '/uploads/'.$_GET['f'].'/';
	if ($_GET['flag'] == 'product'){
		$WidthuploadARR[] 	= array(460, 		460,	'460x460');
		$WidthuploadARR[] 	= array(98, 		98,	'100x100');
		$WidthuploadARR[] 	= array(280, 		280,	'300x300');
		$WidthuploadARR[] 	= array(81, 		84, 	'81x84');
		
		$upload_dir = $_SERVER['DOCUMENT_ROOT'].'/uploads/products/{size}/'.$_GET['f'].'/';

	} elseif ($_GET['flag'] == 'action') { 
		$WidthuploadARR[] 	= array(960, 		393, 		'960x393');
		$WidthuploadARR[] 	= array(240, 		160, 		'240x160');
		$upload_dir = $_SERVER['DOCUMENT_ROOT'].'/uploads/products/{size}/'.$_GET['f'].'/';
		 
	} elseif ($_GET['flag'] == 'about') {
		$WidthuploadARR[] 	= array(400, 		350, 		'400x350');
		$WidthuploadARR[] 	= array(119, 		91, 		'119x91');
		$upload_dir = $_SERVER['DOCUMENT_ROOT'].'/uploads/about/{size}/'.$_GET['f'].'/';
	
	}elseif ($_GET['flag'] == 'reviews') {
		$WidthuploadARR[] 	= array(100, 		100, 		'100x100');
		$upload_dir = $_SERVER['DOCUMENT_ROOT'].'/uploads/reviews/{size}/'.$_GET['f'].'/';
		
	}
	
	$pic = $_FILES['myFile'];
	preg_match('|\.\S+|', $pic['name'],$ARR);
	
	if($_FILES['myFile']['type'] == 'image/png' || $_FILES['myFile']['type'] == 'image/jpeg' || $_FILES['myFile']['type'] == 'image/gif'){
		echo 'Uncorrect format!';
		exit;
	}
	
	$filename = md5(time().rand('1', '100000')).$ARR[0];
	$upload_dir_time = $_SERVER['DOCUMENT_ROOT'].'/uploads/';
	$upload_dir = $_SERVER['DOCUMENT_ROOT'].'/uploads/{size}/'.$_GET['f'].'/';
	
	$filename = str_replace("'", '',$filename);
	$filename = str_replace("\\", "",$filename);
	
	$jcrop = false;
	if (isset($_GET['h']) && isset($_GET['w']) && is_numeric($_GET['h']) && is_numeric($_GET['w'])) {
		$jcrop = true;
		$x = (int)floor($_GET['x']);
		$y = (int)floor($_GET['y']);
		$w = (int)floor($_GET['w']);
		$h = (int)floor($_GET['h']);
		
	}
	
	if(move_uploaded_file($pic['tmp_name'], $upload_dir_time.$filename)){
		
		//$gis = getimagesize($upload_dir_time.$filename);
			
				
				
				
		foreach ($WidthuploadARR as $K => $V) {
				$thumb = new Imagick($upload_dir_time.$filename);
				
				$thumb->setImageCompression(Imagick::COMPRESSION_JPEG);
				$thumb->setImageCompressionQuality(90);
				$thumb->setInterlaceScheme(Imagick::INTERLACE_PLANE);
				$imagick_orientation = $thumb->getImageOrientation();
				switch($imagick_orientation)
			    {
			        case '0':
			            $imagick_orientation_evaluated = "Undefined";
			            break;
			        
			        case '1':
			            $imagick_orientation_evaluated = "Top-Left";
			            break;
			        
			        case '2':
			            $imagick_orientation_evaluated = "Top-Right";
			            break;
			        
			        case '3':
			            $imagick_orientation_evaluated = "Bottom-Right";
			            break;
			        
			        case '4':
			            $imagick_orientation_evaluated = "Bottom-Left";
			            break;
			        
			        case '5':
			            $imagick_orientation_evaluated = "Left-Top";
			            break;
			        
			        case '6':
			            $imagick_orientation_evaluated = "Right-Top";
			            break;
			        
			        case '7':
			            $imagick_orientation_evaluated = "Right-Bottom";
			            break;
			        
			        case '8':
			            $imagick_orientation_evaluated = "Left-Bottom";
			            break;
			    }
				//echo exit_status($imagick_orientation_evaluated);
				
			   	$thumb = autoRotateImage($thumb);
				$dir = str_replace('{size}', $V[2], $upload_dir);
				if(!is_dir($dir)) {
					mkdir($dir);
				}
				$image = new Imagick();
				$image->newImage($V[0], $V[1],  new ImagickPixel('white'));
				$image->setImageFormat($thumb->getImageFormat());
				
				if ($jcrop) {
					$thumb->cropImage($w,$h,$x,$y);
					if ($V[0] < $w || $V[1] < $h){
						$thumb->resizeImage($V[0], $V[1],Imagick::FILTER_LANCZOS,1);
					}
				}else {
						                
					$WidthProp = $V[0] /$V[1];
					$HeightProp = $thumb->getImageWidth() / $thumb->getImageHeight();
					
					if ($WidthProp > $HeightProp) {
						$thumb->ThumbnailImage($V[0],0);
					} else {
						$thumb->ThumbnailImage(0,$V[1]);
					}
				}
				$image->compositeImage( $thumb, Imagick::COMPOSITE_DEFAULT, ($image->getImageWidth() - $thumb->getImageWidth())/2, ($image->getImageHeight() - $thumb->getImageHeight())/2 );
				
				$image->unsharpMaskImage(0 , 0.53 , 1 , 0.05);
				$image->writeImage( $dir.$filename);
				$image->destroy();
		}

		$thumb->destroy();
		unlink($upload_dir_time.$filename);
 		exit_status($_GET['f'].'/'.$filename);
	}
	
	// Move the uploaded file from the temporary 
	// directory to the uploads folder:
	

//exit_status('Something went wrong with your upload!');

// Helper functions

function exit_status($str){
	echo $str;
	exit;
}


function autoRotateImage($image) { 
    $orientation = $image->getImageOrientation(); 

    switch($orientation) { 
        case imagick::ORIENTATION_BOTTOMRIGHT: 
            $image->rotateimage("#000", 180); // rotate 180 degrees 
        break; 

        case imagick::ORIENTATION_RIGHTTOP: 
            $image->rotateimage("#000", 90); // rotate 90 degrees CW 
        break; 

        case imagick::ORIENTATION_LEFTBOTTOM: 
            $image->rotateimage("#000", -90); // rotate 90 degrees CCW 
        break; 
    } 

    // Now that it's auto-rotated, make sure the EXIF data is correct in case the EXIF gets saved with the image! 
    $image->setImageOrientation(imagick::ORIENTATION_TOPLEFT); 
    return $image;
} 
function get_extension($file_name){
	$ext = explode('.', $file_name);
	$ext = array_pop($ext);
	return strtolower($ext);
}
?>
<?php

namespace App\Actions;

use Illuminate\Support\Facades\Storage;
use App\Models\Template;


class MemeGeneratorAction{
	
	private $topText;
	private $bottomText;
	private $alignment;
	private $background;
	private $font;
	private $im;
	private $imgSize;

	public function __invoke($id,$topText,$bottomText)
	{
		$this->setFontPath();

		$path = $this->getImagePath($id);
		$this->im = $this->ReturnImageFromPath($path);
		$this->imgSize = getimagesize($path);

		$this->setTopText($topText);
		$this->setBottomText($bottomText);

		$this->background = imagecolorallocate($this->im, 255, 255, 255);
		#imagecolortransparent($this->im, $this->background);

		$this->processImg();
        
    }

	private function setFontPath()
	{
		$this->font = Storage::path('public/impact.ttf');
	}
	
	private function getImagePath($id)
	{
		$image = Template::where('id', $id)->get()->first();
		return Storage::path('public/templates/'.$image->image_path);
	}

	private function returnImageFromPath($path)
	{
		$ext = pathinfo($path, PATHINFO_EXTENSION);
	
		if ($ext == 'jpg' || $ext == 'jpeg'){
			return imagecreatefromjpeg($path);
		}
		else if ($ext == 'png'){
		  	return imagecreatefrompng($path);
		}
		else if ($ext == 'gif'){
		  	return imagecreatefromgif($path);
		}
	}

	public function setTopText($txt)
	{
		$this->topText = mb_strtoupper($txt);
	}
	
	public function setBottomText($txt)
	{
		$this->bottomText = mb_strtoupper($txt);
	}

	private function getHorizontalTextAlignment($imgWidth, $topRightPixelOfText)
	{
		return floor(($imgWidth - $topRightPixelOfText) / 2);
	}

	private function checkTextWidthExceedImage($imgWidth, $textWidth)
	{
		return ($imgWidth < $textWidth + 20);
	}
	
	private function getFontPlacementCoordinates($text, $fontSize)
	{
		/* 		returns 
		 * 		Array
		 * 		(
		 * 			[0] => ? // lower left X coordinate
		 * 			[1] => ? // lower left Y coordinate
		 * 			[2] => ? // lower right X coordinate
		 * 			[3] => ? // lower right Y coordinate
		 * 			[4] => ? // top right X coordinate
		 * 			[5] => ? // top right Y coordinate
		 * 			[6] => ? // top left X coordinate
		 * 			[7] => ? // top left Y coordinate
		 * 		)
		 * */
	
		return imagettfbbox($fontSize, 0, $this->font, $text);
	}

	private function placeTextOnImage($img, $fontsize, $Xlocation, $Textheight, $font, $text)
	{
		imagettftext($this->im, $fontsize, 0, $Xlocation, $Textheight, $this->background, $font, $text);
	}
	
	private function workOnImage($text, $size, $type)
	{
		if ($type == "top") {
			$textCoordinateY = 35;
		}
      	else {
        	$textCoordinateY = $this->imgSize[1] - 20;
		}
	
		while (True) {
		  	//get coordinate for the text
		  	$coords = $this->getFontPlacementCoordinates($text, $size);
	
		  	// place the text in center
			$textCoordinateX = $this->getHorizontalTextAlignment($this->imgSize[0], $coords[4]);
	
		  	//check if the text does not exceed image width if yes then repeat with size = size - 1
		  	if ($this->checkTextWidthExceedImage($this->imgSize[0], $coords[2] - $coords[0])) {
				//if top text take it up as font size decreases, if bottom text take it down as font size decreases
				$textCoordinateY += ($type == "top") ? - 1 : 1;
	
				if ($size == 10) {
			  		//if text size is reached to lower limit and still it is exceeding image width start breaking into lines
			  		if ($type == "top") {
						$this->topText = $this->returnMultipleLinesText($text, $type, 16);
						$text = $this->topText;
						return;
			  		}
			  		else {
						$this->bottomText = $this->returnMultipleLinesText($text, $type, $this->imgSize[1] - 20);
						$text = $this->bottomText;
						return;
			  		}
				}
				else{
					$size -=1;
				}
		  	}
		  	else{
				break;
		  	}
		}
	
		if ($type == "top"){
		  	$this->placeTextOnImage($this->im, $size, $textCoordinateX, $textCoordinateY, $this->font, $this->topText);
		}
		else{
		  	$this->placeTextOnImage($this->im, $size, $textCoordinateX, $textCoordinateY, $this->font, $this->bottomText);
		}
	}

	private function returnMultipleLinesText($text, $type, $textHeight) {
		//breaks the whole sentence into multiple lines according to the width of the image.
		//break sentence into an array of words by using the spaces as params
		$brokenText = explode(" ", $text);
		$finalOutput = "";
	
		if ($type != "top"){
		  	$textHeight = $this->imgSize[1] - ((count($brokenText) / 2) * 3);
		}
	
		for ($i = 0; $i < count($brokenText); $i++) {
			$temp = $finalOutput;
			$finalOutput.= $brokenText[$i] . " ";
			// this will help us to keep the last word in hand if this word is the cause of text exceeding the image size.			
			// We will be using this to append in next line.
			//check if word is too long i.e wider than image width
			//get the sentence(appended till now) placement coordinates
			$dimensions = $this->getFontPlacementCoordinates($finalOutput, 10);
		
			//check if the sentence (till now) is exceeding the image with new word appended
			if ($this->checkTextWidthExceedImage($this->imgSize[0], $dimensions[2] - $dimensions[0])) { //yes it is then
				// append the previous sentence not with the new word  ( new word == $brokenText[$i] )
				$dimensions = $this->getFontPlacementCoordinates($temp, 10);
				$locx = $this->getHorizontalTextAlignment($this->imgSize[0], $dimensions[4]);
				$this->PlaceTextOnImage($this->im, 10, $locx, $textHeight, $this->font, $temp);
				$finalOutput = $brokenText[$i];
				$textHeight +=13;
			}
		
			//if this is the last word append this also.The previous if will be true if the last word will have no room
			if ($i == count($brokenText) - 1) {
				$dimensions = $this->getFontPlacementCoordinates($finalOutput, 10);
				$locx = $this->getHorizontalTextAlignment($this->imgSize[0], $dimensions[4]);
				$this->PlaceTextOnImage($this->im, 10, $locx, $textHeight, $this->font, $finalOutput);
			}
		}
		return $finalOutput;
	}

	public function processImg()
	{
		if($this->bottomText != "") {
		  $this->WorkOnImage($this->bottomText,30,"lower");
		}
		if($this->topText != "") {
		  $this->WorkOnImage($this->topText,30,"top");
		}
	
		header('Content-Type: image/jpeg');
		imagepng($this->im);
	
		imagedestroy($this->im);
	}
}

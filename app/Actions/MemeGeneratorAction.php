<?php

namespace App\Actions;

use Illuminate\Support\Facades\Storage;
use App\Models\Template;
use Image;


class MemeGeneratorAction{
	
	private $topText;
	private $bottomText;
	private $alignment;
	private $background;
	private $font;
	private $im;
	private $width;
	private $height;
	private $textMaxWidth;
	private $textMaxHeight;

	public function __invoke($id,$topText,$bottomText)
	{
		$this->setFontPath();

		$path = $this->getImagePath($id);
		$this->im = Image::make($path);
		$this->setImageSize($path);

		$this->setTopText($topText);
		$this->setBottomText($bottomText);

		$this->processImg();
		//dd();
		return $this->im; 
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

	private function setImageSize(){
		$this->width = $this->im->width();
		$this->height = $this->im->height();
	}

	private function setTopText($txt)
	{
		$this->topText = mb_strtoupper($txt);
	}
	
	private function setBottomText($txt)
	{
		$this->bottomText = mb_strtoupper($txt);
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

	private function placeTextOnImage($fontSize, $multipleLinesText, $type)
	{
		$textCoordinateX = floor($this->width / 2);
		if ($type == 'top'){
			$textCoordinateY = round($this->height/32);
		}else{
			$textCoordinateY = $this->height - $multipleLinesText[1] - round($this->height/32);
		}
		$px = 2;
		foreach ($multipleLinesText[0] as $line){
			for ($c1 = ($textCoordinateX - abs($px)); $c1 <= ($textCoordinateX + abs($px)); $c1++)
      			for ($c2 = ($textCoordinateY - abs($px)); $c2 <= ($textCoordinateY + abs($px)); $c2++)
					$this->im->text($line[0],$c1,$c2, function($font) use ($fontSize) {
						$font->file($this->font);
						$font->size($fontSize);
						$font->color('#000000');
						$font->align('center');
						$font->valign('top');
					});
			$this->im->text($line[0],$textCoordinateX,$textCoordinateY, function($font) use ($fontSize) {
				$font->file($this->font);
				$font->size($fontSize);
				$font->color('#FFFFFF');
				$font->align('center');
				$font->valign('top');
			});
			$textCoordinateY += $line[1];
		}
	}
	
	public function workOnImage($text, $type)
	{

		$maxFontSize = round(($this->height / 4) * 0.75);
		$minFontSize = 1;

		while ($maxFontSize > $minFontSize + 1){
			$fontSize = floor(($maxFontSize+$minFontSize) / 2);
			$textHeight =  $this->returnMultipleLinesText($text, $fontSize)[1];

			if ($textHeight <= $this->textMaxHeight){
				$minFontSize = $fontSize;
			}else{
				$maxFontSize = $fontSize;
			}
		}
		$multipleLinesText = $this->returnMultipleLinesText($text,$minFontSize);
		$this->placeTextOnImage($fontSize,$multipleLinesText,$type);
	}

	private function returnMultipleLinesText($text, $fontSize){
		$brokenText = explode(' ', $text);
		$linesArray = array();
		$tmpString = '';
		$textHeight = 0;
		foreach ($brokenText as $word){
			$textBox = $this->getFontPlacementCoordinates($tmpString.' '.$word, $fontSize);
			$lineWidth = abs($textBox[4] - $textBox[0]);
			if($lineWidth  > $this->textMaxWidth){
				$textBox = $this->getFontPlacementCoordinates($tmpString, $fontSize);
				$lineHeight = abs($textBox[5] - $textBox[1]);
				$linesArray[] = array($tmpString,$lineHeight);
				$textHeight += $lineHeight;
				$tmpString = $word;
			}
			else{
				$tmpString.=' '.$word;
			}
		}
		$textBox = $this->getFontPlacementCoordinates($tmpString, $fontSize);
		$lineHeight = abs($textBox[5] - $textBox[1]);
		$linesArray[] = array($tmpString,$lineHeight);
		$textHeight += $lineHeight;
		return array($linesArray, $textHeight);
	}

	private function processImg()
	{
		$this->textMaxWidth = round($this->width*1.1);
		$this->textMaxHeight = round($this->height * 0.2);

		if($this->bottomText != '') {
		  $this->workOnImage($this->bottomText, 'bottom');
		}
		if($this->topText != '') {
		  $this->workOnImage($this->topText, 'top');
		}
	}
}

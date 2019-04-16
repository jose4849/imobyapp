<?php
error_reporting(0);
    /**
    * D3Image
    * @author Tufan Baris YILDIRIM
    * @version 1.1.0
    * @since 06.02.2010
    * v1.1.0
    * ======
    * - TurnOffBlending() added for png files - turning off blending option and set alpha flag.
    * v1.0.4
    * ======
    * - colorByName array unsetted
    * - bug fixed about custom font.
    * v1.0.3
    * =======
    * DupliCateOnUseImage propery added  for duplicate used Object on Add() or Background() Image.
    *           note: if you will  use the background image after import to original file assing this as true.
    * repeat-count , repeat-count-x,y  added for bacground.
    * height()  and width() added.
    * v1.0.2
    * ======
    * - output header added for Show() function..
    * v1.0.1
    * ======
    * brightColor() func added. for brighting a color  by given ratio
    *       brightImage() func addad for brighting image
    * darkColor() func added. for darking a color  by given ratio
    *         darkColor() func addad for darking image
    * v1.0
    * =====
    * This class can create an image with basic option you given
    * And u can give style all of items in your image by css code as : width:10;height:20;border:#000 1px solid;
    *   - Draw Line
    *       properties :
    *                   .width
    *                   .height
    *                   .color
    *                   .border
    *                   .align
    *                   .top,bottom
    *                   .left,right
    *   - Draw Rectangle,square
    *       properties :
    *                   .width
    *                   .height
    *                   .color
    *                   .border
    *                   .align
    *                   .top,bottom
    *                   .left,right
    *   - Draw Elipse,Circle
    *       properties :
    *                   .width
    *                   .height
    *                   .color
    *                   .border
    *                   .align
    *                   .top,bottom
    *                   .left,right
    *   - Draw arc,pie
    *   - Set Background
    *       properties :
    *                   .width
    *                   .height
    *                   .align
    *                   .repeat
    *                   .top,bottom
    *                   .left,right
    *   - Save to File
    *   - Load From File
    *   - Crop
    *   - Resize
    *        properties :
    *                   .width
    *                   .height
    *                   .align (set start coordinate easly  as  bottom left ;))
    *                   .top,bottom   //  //    denden :D
    *                   .left,right  //   //   denden :D
    *   - Write string ( System or Trutype )
    *        properties :
    *                   .color
    *                   .font-size
    *                   .border
    *                   .directin (enums up=90 ,down=-90)
    *                   .top,bottom
    *                   .left,right
    *                   .align (enums: center ,bottom center, left bottom , bottom right etc..)
    *                   .font-family  (for can use this property u must set fontpath and  write filename here.)
    */
    class D3Image
    {
        public $ErrorMsg,$DupliCateOnUseImage='false';

        private $image, $width, $height, $CreaterFunc, $OutputFunc, $FontPath, $Fonts,$MimeType;

        #Events
        public $OnCreate='D3OnCreate', $OnError, $OnWarn;

        /**
        * Constructor Main Image Creater
        *
        * @param mixed $CssCodes | width,height,background,file
        * @return D3Image
        */
        function D3Image($CssCodes)
        {

            $this->RunEvent($this->OnCreate);

            $Css=$this->CssInfo($CssCodes);
            if (is_file($Css['file'])){
                $this->Load($Css['file']);
            } else {
                $this->width =$Css['width'] ? $Css['width']:1;
                $this->height=$Css['height']? $Css['height']:1;
                $this->Load();

                if (strtolower($Css['background']) == 'transparent')
                {
                    $this->FillAll('white')->Transparent('white');
                }
                else
                {
                    $this->FillAll($Css['background']);
                }
            }

            return $this;
            return $this->forEditores();
        }
        /**
        * load image from a file
        *
        * @param mixed $FileUrl
        * @return D3Image
        */
        function Load($FileUrl = False)
        {
            $CreateParam=array
            (
            'width'  => $this->width,
            'height' => $this->height
            );

            if (!$FileUrl)
            {
                $this->CreaterFunc='imagecreatetruecolor';
                $this->OutputFunc ='imagepng';
            }
            else
            {
                $CreateParam=$FileUrl;

                if (is_file($FileUrl))
                {

                    switch (strtolower(end(explode('.', $FileUrl))))
                    {
                        case 'gif':
                            $this->CreaterFunc='imagecreatefromgif';
                            $this->OutputFunc ='imagegif';
                            $this->MimeType='image/gif';
                            break;

                        case 'jpg':
                        case 'jpeg':
                            $this->CreaterFunc='imagecreatefromjpeg';
                            $this->OutputFunc ='imagejpeg';
                            $this->MimeType='image/jpeg';
                            break;

                        case 'png':
                            $this->CreaterFunc='imagecreatefrompng';
                            $this->OutputFunc ='imagepng';
                            $this->MimeType='image/png';
                            break;

                        default:
                            $this->Error('Invalid File Type');
                            break;
                    }
                }
                else
                {
                    $this->CreaterFunc='imagecreatefromstring';
                    $CreateParam      =$FileUrl;
                }
            }

            $this->image=$this->RunEvent($this->CreaterFunc, $CreateParam);

            if (!is_resource($this->image))
            {
                $this->Error('Invalid Data For Create An Image');
            }
            else
            {
                $this->height=$this->__height($this->image);
                $this->width =$this->__width($this->image);
            }

            return $this;
            return $this->forEditores();
        }
        /**
        * Clone your D3Image Object  By a new Inage and all of properties
        *
        * @param mixed $Object
        * @return D3Image
        */
        function CloneImage($Object)
        {
            if (!is_object($Object))
            {
                $this->Error('Error.!');
            }
            else
            {
                foreach ($Object as $Name => $Val)
                {
                    $this->$Name=$Object->$Name;
                }

            }

            imagepalettecopy($this->image, $Object->image);
            return $this;
            return $this->forEditores();
        }
        /**
        * fill image with a color
        *
        * @param mixed $Color
        * @return D3Image
        */
        function FillAll($Color)
        {
            imagefill($this->image, 0, 0, $this->Color($Color));
            return $this;
            return $this->forEditores();
        }
        /**
        * set an image as a bacground
        *
        * @param mixed $Image
        * @param mixed $CssProPerties
        */
        function BackGroundImage($Image, $CssProPerties)
        {
            if (is_object($Image)) // is_a($image,'D3Image')
            {
                if ($this->DupliCateOnUseImage){
                    $Img=new D3Image('background:#FFF');
                    $Img->CloneImage($Image);
                }else {

                    $Img=$Image;
                    unset($Image);
                }
            }
            elseif (is_file($Image))
            {
                $Img=new D3Image('file:'.$Image);
            }
            else
            {
                $this->Error('Invalid Background .! ');
            }

            if (!$this->ErrorMsg)
            {
                $Css       =$this->CssInfo($CssProPerties);
                $Properties=$this->DedectPositionByCss($Css, $Img->width, $Img->height);

                # Gereksiz.
                #$Img->resizeIt($Properties['width'],$Properties['height']);

                $StartX    =max($Properties['x'],1);
                $StartY    =max($Properties['y'],1);
                $Columns   =ceil($this->width / $Properties['width']);
                $Lines     =ceil($this->height / $Properties['height']);
                if (isset($Css['repeat-count']))
                    $Columns=$Lines=$Css['repeat-count'];

                if (isset($Css['repeat-count-x']))
                    $Columns=$Css['repeat-count-x'];

                if (isset($Css['repeat-count-y']))
                    $Lines=$Css['repeat-count-y'];

                switch ($Css['repeat'])
                {
                    case 'false':
                    case 'no-repeat':
                    case 'no':
                        $this->Add($Img,
                        'height:' . $Properties['height'] . ';width:' . $Properties['width'] . ';left:'
                        . ($Properties['x'] + $Properties['width'] + $Css['padding']) . ';top:'
                        . $Properties['y'] . ';');

                        break;

                    case 'x':
                        for ($c=0; $c < $Columns; $c++):

                            $this->Add($Img,
                            'height:' . $Properties['height'] . ';width:' . $Properties['width'] . ';left:'
                            . ($Properties['x'] + $c * ($Properties['width'] + $Css['padding'])) . ';top:'
                            . $Properties['y'] . ';');
                            endfor;

                        break;

                    case 'y':
                        for ($l=0; $l < $Lines; $l++):

                            $this->Add($Img,
                            'height:' . $Properties['height'] . ';width:' . $Properties['width'] . ';left:'
                            . $Properties['x'] . ';top:'
                            . ($Properties['y'] + $l * ($Properties['height'] + $Css['padding'])));
                            endfor;

                        break;

                    case 'x-y':
                    case 'xy':
                    case 'yx':
                    case 'y-x':
                    case 'repeat':
                    case 'true':
                    default:
                        for ($cols=0; $cols < $Columns; $cols++):

                            //$this->Add($Img,'height:'.$Properties['height'].';width:'.$Properties['width'].';left:'.($Properties['x']+$c*($Properties['width']+$Css['padding'])).';top:'.$Properties['y'].';');
                            $this->BackGroundImage($Img,
                            'width:' . $Properties['width'] . ';height:' . $Properties['height']
                            . ';top:' . $Properties['y'] . ';left:'
                            . ($Properties['x'] + $cols
                            * ($Properties['width'] + $Css['padding']))
                            . ';repeat:y;padding:' . $Css['padding'] . ';');
                            endfor;

                        break;
                }
            }
        }
        /**
        * Write a text into image and style it by css
        *
        * @param mixed $String
        * @param mixed $Css
        * @return D3Image
        */
        public function Write($String, $Css)
        {
            $Css              =$this->CssInfo($Css);
            $Options['font']  =$Css['font-size'] ? $Css['font-size'] : 4;
            $FontFont         =$Options['font'];
            $Options['string']=$String;

            if ($Css['font-family'])
            {
                if ($this->Fonts[$Css['font-family']])
                {
                    $TrueType=$this->Fonts[$Css['font-family']];
                }
                else
                {
                    if (is_file($this->FontPath() . $Css['font-family']))
                        $TrueType=$this->FontCreate($Css['font-family']);
                }

                if ($TrueType=='')
                    $TrueType=false;

                switch ($Css['direction'])
                {
                    case 'up':
                        $Css['direction']=90;

                        break;

                    case 'down':
                        $Css['direction']=-90;

                        break;
                }

                $FontFont=array
                (
                'size'   => $Css['font-size'],
                'angle'  => $Css['direction'],
                'file'   => $TrueType,
                'string' => $Options['string']
                );
            }

            $FontInfo        =$this->FontInfo($FontFont,$String, $TrueType);
            $FontInfo['length']=strlen($String);
            $he              =max($FontInfo[0], $FontInfo[4]) - min($FontInfo[0], $FontInfo[4]);
            $wi              =max($FontInfo[1], $FontInfo[5]) - min($FontInfo[1], $FontInfo[5]);

            $Positions       =$this->DedectPositionByCss($Css, $wi ? $wi : $FontInfo['w'], $he ? $he:$FontInfo['h'], $TrueType ? false : 'text', $FontInfo);

            $Options['x']    =$Positions['x'];
            $Options['y']    =$Positions['y'];
            $Options['image']=$this->image;
            $Options['color']=$Css['color'];

            $BreakPoint      =true;

            if ($Css['direction'])
            {
                if ($TrueType)
                {
                    imagettftext($this->image,  $Options['font'],                $Css['direction'], $Options['x'],
                    $Options['y'], $this->Color($Options['color']), $TrueType,         $Options['string']);
                }
                else
                {
                    $this->Error('You Must Use TrueType For can use css: direction:' . $Css['direction'] . ';');
                }
            }
            else
            {
                if ($TrueType)
                {
                    imagettftext($this->image,                    $Options['font'], 0, $Options['x'], $Options['y'],
                    $this->Color($Options['color']), $TrueType,        $Options['string']);
                }
                else
                {
                    imagestring($this->image, $Options['font'], $Options['x'], $Options['y'], $Options['string'],
                    $this->Color($Options['color']));
                }
            }

            return $this;
            return $this->forEditores();
        }

        public function FontInfo($Font,$Text, $TrueType = false)
        {
            if ($TrueType)
            {
                return imagettfbbox($Font['size'], $Font['angle'], $Font['file'], $Font['string']);

            }
            else
            {
                return Array
                (
                'w' => imagefontwidth($Font),
                'h' => imagefontheight($Font)
                );
            }
        }
        /**
        * Create a font for use it by only name on your css condes
        *
        * @param mixed $FileName
        * @param mixed $FontName
        */
        public function FontCreate($FileName, $FontName = false)
        {
            if (is_file($FileName))
            {
                $FontAdres=$FileName;
            }
            else
            {
                if (is_dir($this->FontPath))
                {
                    $FontAdres=(substr($this->FontPath, 0,
                    -1) == '/' ? ($this->FontPath . $FileName) : ($this->FontPath . '/' . $FileName));
                    is_file ($FontAdres) or $this->Error('Invalid Font File Name');
                }
                else
                {
                    $this->Error('Invalid Font Path');
                }
            }

            if ($FontName)
            {
                $this->Fonts[$FontName]=$FontAdres;
            }

            return $FontAdres;
        }
        /**
        * Set fontPath for use directly font by file name
        *
        * @param mixed $Path
        */
        public function FontPath($Path = False)
        {
            if ($Path)
            {
                if (!is_dir($Path))
                {
                    $this->Error('Invalid Path : ' . $Path);
                }
                else
                {
                    $this->FontPath=$Path;
                }
            }
            else
            {
                return $this->FontPath;
            }
        }
        /**
        * Crop your image
        *
        * @param mixed $w cropped width
        * @param mixed $h copped height
        * @param mixed $StartX  X start position on original image
        * @param mixed $StartY  Y start position on original image
        * @return D3Image
        */
        public function Crop($w, $h, $StartX = 0, $StartY = 0)
        {
            $Img=new D3Image('width:'.$w.';height:'.$h.';background:transparent');
            imagecopyresampled($Img->image, $this->image, $disX, $disY, $icX, $icY, $w, $h, $w, $h);
            $this->height=$h;
            $this->width =$w;
            $this->Destroy();
            $this->image=$Img->image;
            return $this;
            return $this->forEditores();
        }
        /**
        * Resize Image
        *
        * @param mixed $widthAndHeightCss  css code
        * @return D3Image
        */
        function Resize($widthAndHeightCss)
        {
            $Css=$this->CssInfo($widthAndHeightCss);

            if ($Css['height']>0 && $Css['width']>0)
            {
                $this->resizeIt($Css['width'], $Css['height']);
            }
            elseif ($Css['width']>0)
            {
                $this->resizeByWidth($Css['width']);
            }
            elseif ($Css['height']>0)
            {
                $this->resizeByHeight($Css['heigh']);
            }
            else
            {
                $this->Error('Can not Resize Image height and width is empty.');
            }

            return $this;
            return $this->forEditores();
        }

        private function resizeByHeight($height)
        {
            $Oran =$height / $this->height;
            $width=$this->width * $Oran;
            return $this->resizeIt($width, $height);
        }

        private function resizeByWidth($width)
        {
            $Oran  =$width / $this->width;
            $height=$this->height * $Oran;
            return $this->resizeIt($width, $height);
        }

        private function resizeIt($width, $height)
        {
            $Img=new D3Image('width:'.$width.';'.'height:'.$height.';');
            imagecopyresampled($Img->image, $this->image, 0, 0, 0, 0, $width, $height, $this->width, $this->height);
            $this->width =$width;
            $this->height=$height;
            $this->image =$Img->image;
            return $this;
            return $this->forEditores();
        }
        /**
        * Draw a line  on your image
        *
        * @param mixed $Color  color code or name
        * @param mixed $Width  line width
        * @param mixed $Start  start of line x,y position
        * @param mixed $End    end of line x,y position
        * @return D3Image
        */
        public function DrawLine($Color = 000, $Width = 1, $Start = Array(), $End = Array())
        {
            $Start['x']=$Start['x'] ? $Start['x'] : $Start[0];
            $Start['y']=$Start['y'] ? $Start['y'] : $Start[1];

            $End['x']  =$End['x'] ? $End['x'] : $End[0];
            $End['y']  =$End['y'] ? $End['y'] : $End[1];

            if (!is_numeric($Start['x']) OR $Start['x'] < 0)
                $Start['x']=0;

            if (!is_numeric($Start['y']) OR $Start['y'] < 0)
                $Start['y']=0;

            if (!is_numeric($End['x']) OR $End['x'] > $this->width)
                $End['x']=$this->width;

            if (!is_numeric($End['y']) OR $End['y'] > $this->height)
                $End['y']=$this->height;

            $x1=$Start['x'];
            $y1=$Start['y'];
            $x2=$End['x'];
            $y2=$End['y'];

            if (!is_numeric($Width) OR $Width <= 1)
                $Width=1;

            $this->imagelinethick($x1, $y1, $x2, $y2, $this->Color($Color), $Width);

            return $this;
            return $this->forEditores();
        }
        /**
        * Draw a Rectangle on your image
        *
        * @param mixed $CssProperties
        * @return D3Image
        */
        public function DrawRectangle($CssProperties)
        {
            $Css      =$this->CssInfo($CssProperties);
            $Positions=$this->DedectPositionByCss($Css, $Css['width'], $Css['height'], 'byborder');

            if ($Css['direction'] == 'down')
            {
                $x2=$Positions['x'] + $Positions['width'];
                $y2=$Positions['y'] - $Positions['height'];
            }
            else
            {
                $x2=$Positions['x'] + $Positions['width'];
                $y2=$Positions['y'] + $Positions['height'];
            }

            if ($Css['border']['width'] > 0)
            {
                $x1Border=$Positions['x'] - $Css['border']['width'];
                $x2Border=$x2 + $Css['border']['width'];

                if ($Css['direction'] == 'down')
                {
                    $y1Border=$Positions['y'] + $Css['border']['width'];
                    $y2Border=$y2 + $Css['border']['width'];
                }
                else
                {
                    $y1Border=$Positions['y'] - $Css['border']['width'];
                    $y2Border=$y2 + $Css['border']['width'];
                }

                imagefilledrectangle($this->image, $x1Border, $y1Border, $x2Border, $y2Border,
                $this->Color($Css['border']['color']));
            }

            imagefilledrectangle($this->image, $Positions['x'], $Positions['y'], $x2, $y2, $this->Color($Css['color']));
            return $this;
            return $this->forEditores();
        }
        /**
        * Draw rounded arc
        *
        * @param mixed $x origin x
        * @param mixed $y origin y
        * @param mixed $w arc width
        * @param mixed $h arc heigt
        * @param mixed $s start (percent)
        * @param mixed $e  end (percent)
        * @param mixed $c color
        * @return D3Image
        */
        function DrawArc($x, $y, $w, $h, $s, $e, $c)
        {
            imagefilledarc($this->image, $x, $y, $w, $h, $s, $e, $this->Color($c), IMG_ARC_ROUNDED);
            imagearc($this->image, $x, $y, $w, $h, $s, $e, $this->Color($this->Mix2Colors($c, '000')));
            return $this;
            return $this->forEditores();
        }

        private function BorderInfo($BorderInfoAsCss)
        {
            @preg_match('/\#([A-F0-9]+)/i', $BorderInfoAsCss, $BorderColors);
            $BorderInfoAsCss=@preg_replace('/\#([A-F0-9]+)/i', '', $BorderInfoAsCss);
            @preg_match('/([0-9]+)(\s*)px*/i', $BorderInfoAsCss, $BorderPixels);
            $BorderInfoAsCss=@preg_replace('/([0-9]+)(\s*)px/i', '', $BorderInfoAsCss);

            if (!$BorderColors)
            {
                @preg_match('/([A-Z]+)/i', $BorderInfoAsCss, $BorderColors);
            }

            return array
            (
            'color' => $BorderColors[1],
            'width' => (int)$BorderPixels[1]
            );
        }
        /**
        * get propertis into array by given css code
        *
        * @param mixed $CssProperties
        * @return mixed
        */
        public function CssInfo($CssProperties)
        {
            preg_match_all("/([A-Za-z-_]+):([^;]*);*/i", $CssProperties, $Css);

            foreach ($Css[1] AS $Indis => $PropertyName)
            {
                if (strtolower($PropertyName) != 'border')
                {
                    $Properties[strtolower($PropertyName)]=str_replace('px', '', trim($Css[2][$Indis]));
                }
                else
                {
                    $Properties[strtolower($PropertyName)]=trim($Css[2][$Indis]);
                }
            }

            if ($Properties['border'])
            {
                $Properties['border']=$this->BorderInfo($Properties['border']);
            }

            $Properties['DTImage']='Css';  // added for validate is really returned by this function.
            return $Properties;
        }
        /**
        * Create Css code by given css properties array
        *
        * @param mixed $Array
        */
        public function CreateCssCode($Array)
        {
            if (is_array($Array))
            {
                Foreach ($Array as $Propname => $PropVal)
                {
                    $Code.=$Propname . ':';

                    if (!is_array($PropVal))
                    {
                        $Code.=$PropVal . ';';
                    }
                    else
                    {
                        foreach ($PropVal As $value)
                        {
                            $Code.=$value . ' ';
                        }

                        $Code.=';';
                    }
                }

                return $Code;
            }
            else
            {
                $this->Error('This is not an array to create css code');
            }
        }
        /***
        * dedect a poistion for an object by css code
        *
        * @param mixed $Css can use align: center top left bottom etc.
        * @param mixed $ObjectWidth
        * @param mixed $ObjectHeight
        * @param mixed $Type
        * @param mixed $ExtraVal
        * @return mixed
        */
        public function DedectPositionByCss($Css, $ObjectWidth = 0, $ObjectHeight = 0, $Type = false, $ExtraVal = false)
        {
            if ($Css['DTImage'] != 'Css')
            {
                $this->Error('Not Enough Property For Dedect Position.!');
            }
            else
            {
                if ($Css['left'])
                    $x=$Css['left'];

                if ($Css['top'])
                    $y=$Css['top'];

                if ($Type == 'truetype')
                {
                    $y=$y + $Css['font-size'];
                }

                if (strstr($Css['width'], '%'))
                    $w =$this->width * str_replace('%', '', $Css['width']) / 100;
                else
                    $w=is_numeric($Css['width']) ? $Css['width'] : $ObjectWidth;

                if (strstr($Css['height'], '%'))
                    $h =$this->height * str_replace('%', '', $Css['height']) / 100;
                else
                    $h=is_numeric($Css['height'])?$Css['height']: $ObjectHeight;

                if(($Css['width']=='auto' || $Css['width']=='') && ($Css['height']=='auto' || $Css['height']=='')){
                    $w=$ObjectWidth;
                    $h=$ObjectHeight;
                }else {
                    $w=($Css['width']=='auto' || $Css['width']=='') ? ($ObjectWidth*$h/$ObjectHeight): $w;
                    $h=($Css['height']=='auto' || $Css['height']=='') ?  ($ObjectHeight*$w/$ObjectWidth) : $h;
                }


                if ($Type == 'text')
                {
                    $w=$ExtraVal['w'] * $ExtraVal['length'];
                    $h=$ExtraVal['h'];
                }

                if ($Css['right'])
                    $x=$this->width - ($w + $Css['right']);

                if ($Css['bottom'])
                    $y=$this->height - ($h + $Css['bottom']);

                # Align
                if ($Css['align'])
                {
                    if (strstr($Css['align'], 'center'))
                    {
                        $x=$this->width / 2 - ($Type == 'center' ? 0 : $w / 2);
                        $y=$this->height / 2 - ($Type == 'center' ? 0 : $h / 2);
                    }

                    if (strstr($Css['align'], 'left'))
                    {
                        $x=0 + ($Css['border']['width']);
                    }

                    if (strstr($Css['align'], 'right'))
                    {
                        $x=$this->width - ($w + $Css['border']['width'] * 2);
                    }

                    if (strstr($Css['align'], 'top'))
                    {
                        $y=0 + ($Css['border']['width']) + ($Type == 'truetype' ? $Css['font-size'] : '0');
                    }

                    if (strstr($Css['align'], 'bottom'))
                    {
                        $y=$this->height - ($Type == 'text' ? $h * 2 : ($Type == 'center' ? $h / 2 : $h))
                        - ($Css['border']['width'] * ($Type == 'center' ? 1 : 2));
                    }
                }

                return array
                (
                'x'      => intval($x),
                'y'      => intval($y),
                'width'  => intval($w),
                'height' => intval($h)
                );
            }
        }
        /**
        * Function Runner
        *
        * @param mixed $EventName
        * @param mixed $Param
        * @return mixed
        */
        private function RunEvent($EventName, $Param = False)
        {
            if (function_exists($EventName))
            {
                if ($Param)
                {
                    if (is_array($Param))
                    {
                        return call_user_func_array($EventName, $Param);
                    }
                    else
                    {
                        return call_user_func($EventName, $Param);
                    }
                }
                else
                {
                    return call_user_func($EventName);
                }
            }

        }

        /**
        * Return Darket of Given Color by ratio.
        *
        * @param float $color
        * @param mixed $ratio
        * @return array
        */
        public function darkColor($color,$ratio=10){
            $color=$this->Color($color,true);
            $Min=min($color['r'],$color['g'],$color['b']);
            if ($Min==0 || $Min==0)
                return false;
            $MinInd=array_search($Min,$color);
            unset($color[$MinInd]);
            $newMin=floor(max($Min-($Min*$ratio/100),0));
            $ratio=$newMin/$Min;
            foreach ($color as $ind=>$val){
                $color[$ind]=max(floor($val*$ratio),0);
            }
            $color[$MinInd]=$newMin;
            return $color;
        }
        /**
        * perform darkColor to all pixels
        * @param mixed $ratio
        */
        public function darkImage($ratio){
            for ($i=0;$i<$this->width;$i++){

                for ($j=0;$j<$this->height;$j++){

                    $color=imagecolorsforindex($this->image,imagecolorat($this->image,$i,$j));
                    $color['r']=$color['red'];
                    $color['g']=$color['green'];
                    $color['b']=$color['blue'];
                    $color=$this->Color($this->rgb2Hex($this->darkColor($color,$ratio)));
                    imagesetpixel($this->image,$i,$j,$color);


                }

            }
        }

        /**
        * Return Brighted of Given Color by ratio.
        *
        * @param float $color
        * @param mixed $ratio
        * @return array
        */
        public function brightColor($color,$ratio=10){
            $color=$this->Color($color,true);
            $Max=max($color['r'],$color['g'],$color['b']);
            if ($Max==255 || $Max==0)
                return false;
            $MaxInd=array_search($Max,$color);
            unset($color[$MaxInd]);
            $newMax=ceil(min($Max+($Max*$ratio/100),255));
            $ratio=$newMax/$Max;
            foreach ($color as $ind=>$val){
                $color[$ind]=min(ceil($val*$ratio),255);
            }
            $color[$MaxInd]=$newMax;
            return $color;
        }
        /**
        * perform brightColor to all pixels
        * @param mixed $ratio
        */
        public function brightImage($ratio){
            for ($i=0;$i<$this->width;$i++){

                for ($j=0;$j<$this->height;$j++){

                    $color=imagecolorsforindex($this->image,imagecolorat($this->image,$i,$j));
                    $color['r']=$color['red'];
                    $color['g']=$color['green'];
                    $color['b']=$color['blue'];
                    $color=$this->Color($this->rgb2Hex($this->brightColor($color,$ratio)));
                    imagesetpixel($this->image,$i,$j,$color);


                }

            }
        }

        /**
        * get color grom a pixel
        *
        * @param mixed $x
        * @param mixed $y
        */
        private function getColor($x,$y){
            return imagecolorsforindex($this->image,imagecolorat($this->image,$x,$y));
        }
        /**
        * Find Given Color Name Or Code And Extract From Color Array or Create RGB Color
        * @param mixed $ColorCode
        * @param mixed $ReturnRgb
        * @return int
        */
        public function Color($ColorCode, $ReturnRgb = False)
        {
            if (is_array($ColorCode)) return $ColorCode;
            $ColorCode=strtolower(str_replace('#', '', trim($ColorCode)));

            if (strlen($ColorCode) == 3)
            {
                for ($i=0; $i < 3; $i++)
                {
                    $SixCode=$SixCode . $ColorCode[$i] . $ColorCode[$i];
                }
                if (!preg_match('(^[a-f0-9]{6})', $SixCode))
                {
                    $ColorCode=$this->ColorByName($ColorCode);
                }
                else
                {
                    $ColorCode=$SixCode;
                }
            }
            else
            {
                if (!preg_match('/(^[A-F0-9]{6})/i', $ColorCode))
                {
                    $ColorCode=$this->ColorByName($ColorCode);
                }
            }

            $RgB  =str_split($ColorCode, 2);
            $Red  =min(hexdec($RgB[0]), 255);
            $Green=min(hexdec($RgB[1]), 255);
            $Blue =min(hexdec($RgB[2]), 255);

            if ($ReturnRgb)
            {
                return array
                (
                'r' => $Red,
                'g' => $Green,
                'b' => $Blue
                );
            }

            return imagecolorallocate($this->image, $Red, $Green, $Blue);
        }
        /**
        * Draw a Circle By Given Center Radius Color And Border.
        *
        * @param mixed $x Center Oordinate
        * @param mixed $y Center Coordinate
        * @param mixed $radius  Radius by Pixel
        * @param mixed $color   Fill Color.
        */
        public function DrawCircle($CssProperties)
        {
            $Css          =$this->CssInfo($CssProperties);
            $Css['width'] =Max($Css['width'], $Css['height']);
            $Css['height']=$Css['width'];

            $Positions    =$this->DedectPositionByCss($Css,
            $Css['border']['width'] > 0 ? $Css['border']['width'] : $Css['width'],
            $Css['border']['height']
            > 0 ? $Css['border']['height'] : $Css['height'],
            'center');

            //$this->DrawEllipse($Positions['x'],$Positions['y'],$radius,$radius,$Css['color'],$Css['border']);
            $this->DrawEllipse($Positions, $Css);
            return $this;
            return $this->forEditores();
        }
        /**
        * Draw  aan ellipse by given css
        *
        * @param mixed $Positions
        * @param mixed $Css
        * @return D3Image
        */
        public function DrawEllipse($Positions, $Css)
        {
            if ($Css['border']['width'] > 0)
            {
                imagefilledellipse($this->image,
                $Positions['x'],
                $Positions['y'],
                $Css['width'] + $Css['border']['width'] * 2,
                $Css['height'] + $Css['border']['width'] * 2,
                $this->Color($Css['border']['color']));
            }

            imagefilledellipse($this->image, $Positions['x'], $Positions['y'], $Css['width'], $Css['height'],
            $this->Color($Css['color']));
            return $this;
            return $this->forEditores();
        }

        public function __height($Resource) {return imagesy($Resource);}
        public function __width($Resource)  {return imagesx($Resource);}
        public function height(){return $this->height;}
        public function width() {return $this->width;}

        /**
        * main error function
        *
        * @param mixed $ErrorMsg
        */
        private function Error($ErrorMsg)
        {
            $this->ErrorMsg=$ErrorMsg;

            if (!$this->RunEvent($this->OnError))
            {
                echo $ErrorMsg;
            }
        }
        /**
        * Main warning function
        *
        * @param mixed $WarningMsg
        */
        private function Warning($WarningMsg)
        {
            $this->WarnMsg=$WarningMsg;
            $this->RunEvent($this->OnWarn);
        }
        /**
        * out image to browser or return source
        *
        * @param mixed $Return
        * @return D3Image
        */
        public function Show($Return = False)
        {
            if ($Return)
            {
                return $this->image;
            }
            header('Content-type: '.$this->MimeType);
            return $this->RunEvent($this->OutputFunc, $this->image);
        }

        public function __destroy($Resource) { imagedestroy ($Resource); }

        /**
        * main destructor
        *
        */
        public function __destructor(){
            $this->__destroy($this->image);
        }
        /**
        * destroy the image resource
        */
        public function Destroy() {
            $this->__destructor();
        }
        /**
        * Write a line or Thick Func From  http://php.net/imageline
        *
        * @param mixed $x1  Start Coord(x)
        * @param mixed $y1  Start Coord(y)
        * @param mixed $x2  End Coord(x)
        * @param mixed $y2  End Coord(y)
        * @param mixed $color  Line Color
        * @param mixed $thick Line width
        * @return bool Return True if line created successfully
        */
        function imagelinethick($x1, $y1, $x2, $y2, $color, $thick = 1)
        {
            if ($thick == 1)
            {
                return imageline($this->image, $x1, $y1, $x2, $y2, $color);
            }

            $t=$thick / 2 - 0.5;

            if ($x1 == $x2 || $y1 == $y2)
            {
                return imagefilledrectangle($this->image,              round(min($x1, $x2) - $t), round(min($y1, $y2) - $t),
                round(max($x1, $x2) + $t), round(max($y1, $y2) + $t), $color);
            }

            $k=($y2 - $y1) / ($x2 - $x1); //y = kx + q
            $a=$t / sqrt(1 + pow($k, 2));

            $points=array
            (
            round($x1 - (1 + $k) * $a),
            round($y1 + (1 - $k) * $a),
            round($x1 - (1 - $k) * $a),
            round($y1 - (1 + $k) * $a),
            round($x2 + (1 + $k) * $a),
            round($y2 - (1 - $k) * $a),
            round($x2 + (1 - $k) * $a),
            round($y2 + (1 + $k) * $a),
            );

            imagefilledpolygon($this->image, $points, 4, $color);
            return imagepolygon($this->image, $points, 4, $color);
        }


        /**
        * Mix Unlimited Colors
        *
        * @param mixed $color1
        * @param mixed $color2
        */
        function MixColors($color1,$color2)
        {
            $Color=False;

            if (func_num_args() > 1)
            {
                Foreach (func_get_args() AS $ColorCode)
                {
                    if (!$Color)
                    {
                        $Color=$ColorCode;
                    }
                    elseif ($ColorCode)
                    {
                        $Color=$this->Mix2Colors($ColorCode, $Color);
                    }
                }

                return $Color;
            }

            $this->Error('Error while Mixing Colors : Mixcolor have to be used by more than 1 params');
        }
        /**
        * save image to a file
        *
        * @param mixed $FileName
        * @return D3Image
        */
        public function SaveToFile($FileName)
        {

            $Array=Array
            (
            'image'    => $this->image,
            'filename' => $FileName
            );

            if (!$this->RunEvent($this->OutputFunc, $Array))
            {
                $this->Error('Error While Saving To File');
            }

            return $this;
            return $this->forEditores();
        }

        public function rgb2Hex($array){
            if (is_Array($array)){
                foreach($array as $n=>$v){
                    if (strlen($n)>1){
                        $array[strtolower($n[0])]=$v;
                        unset($array[$n]);
                    }
                }
                $hex   =$this->dec2hex($array['r']?$array['r']:$array[0])
                .$this->dec2hex($array['g']?$array['g']:$array[1])
                .$this->dec2hex($array['b']?$array['b']:$array[2]);

                return $hex;
            }else {
                return $array;
            }
        }

        private function dec2hex($Number)
        {
            $Cn=dechex($Number);
            return strlen($Cn) == 2 ? $Cn : '0' . $Cn;
        }
        /**
        * generate a color by rand
        *
        */
        public function RandColorCode()
        {
            $R=rand(0, 255);
            $G=rand(0, 255);
            $B=rand(0, 255);

            return '#' . $this->dec2hex($R) . $this->dec2hex($G) . $this->dec2hex($B);
        }

        /**
        * main color mixed
        *
        * @param int $Color1
        * @param int $Color2
        */
        private function Mix2Colors($Color1, $Color2)
        {
            $Color1=$this->Color($Color1, True);
            $Color2=$this->Color($Color2, True);

            $MaxR  =max($Color1['r'], $Color2['r']);
            $MaxG  =max($Color1['g'], $Color2['g']);
            $MaxB  =max($Color1['b'], $Color2['b']);

            $MinR  =min($Color1['r'], $Color2['r']);
            $MinG  =min($Color1['g'], $Color2['g']);
            $MinB  =min($Color1['b'], $Color2['b']);

            $R     =$this->dec2hex(floor(($Color1['r']+$Color2['r'])/2));
            $G     =$this->dec2hex(floor(($Color1['g']+$Color2['g'])/2));
            $B     =$this->dec2hex(floor(($Color1['b']+$Color2['b'])/2));

            return '#' . $R . $G . $B;
        }
        /**
        * import  d3 image and stlye it by css
        *
        * @param mixed $Obje
        * @param mixed $PropertiesAsCss
        * @return D3Image
        */
        public function Add($Obje, $PropertiesAsCss = '')
        {
            if($this->DupliCateOnUseImage){
                $Object=new D3Image('background:#FFFFFF');
                $Object->CloneImage($Obje);
            }
            else {
                $Object=$Obje;
                unset($Obje);
            }

            if (!is_object($Object))
            {
                $this->Error('This is not an Object');
            }
            else
            {
                if (property_exists($Object, 'image'))
                {
                    if (!is_resource($Object->image))
                    {
                        $this->Error('Invalid Resource');
                    }
                    else
                    {
                        $Css=$this->CssInfo($PropertiesAsCss);

                        /**
                        * Css Options.
                        */
                        if ($Css['left'])
                            $x=$Css['left'];

                        if ($Css['top'])
                            $y=$Css['top'];

                        $w=$Object->width;
                        $h=$Object->height;

                        if ($Css['width'])
                        {
                            if (strstr($Css['width'], '%'))
                            {
                                $wP=str_replace('%', '', $Css['width']);
                                $w =$this->width * $wP / 100;
                            }
                            else
                            {
                                $w=$Css['width'];
                            }
                        }

                        if ($Css['height'])
                        {
                            if (strstr($Css['height'], '%'))
                            {
                                $hP=str_replace('%', '', $Css['height']);
                                $h =$this->height * $hP / 100;
                            }
                            else
                            {
                                $h=$Css['height'];
                            }
                        }

                        if ($Css['height'] OR $Css['width'])
                        {
                            $Object->Resize($this->CreateCssCode($Css));
                        }

                        if ($Css['opacity'])
                            $Opacity=$Css['opacity'];
                        else
                            $Opacity=100;

                        if ($Css['right'])
                            $x=$this->width - ($w + $Css['right']);

                        if ($Css['bottom'])
                            $y=$this->height - ($h + $Css['bottom']);

                        # Align
                        if ($Css['align'])
                        {
                            if (strstr($Css['align'], 'center'))
                            {
                                $x=$this->width / 2 - $w / 2;
                                $y=$this->height / 2 - $h / 2;
                            }

                            if (strstr($Css['align'], 'left'))
                            {
                                $x=0;
                            }

                            if (strstr($Css['align'], 'right'))
                            {
                                $x=$this->width - $w;
                            }

                            if (strstr($Css['align'], 'top'))
                            {
                                $y=0;
                            }

                            if (strstr($Css['align'], 'bottom'))
                            {
                                $y=$this->height - $h;
                            }
                        }

                        imagecopymerge($this->image, $Object->image, intval($x), intval($y), intval($Cropx), intval($Cropy),
                        intval($w),   intval($h),     $Opacity);
                        if($this->DupliCateOnUseImage)
                            $Object->Destroy();
                    }
                }
                else
                {
                    $this->Error('The Object has\'t got an image property');
                }
            }

            return $this;
            return $this->forEditores();
        }
        /**
        * find center position  by widtg adn height
        *
        * @param mixed $w
        * @param mixed $h
        */
        public function FindCenter($w = false, $h = false)
        {
            $C['x']=$this->width / 2 + ($w ? -$w / 2 : 0);
            $C['y']=$this->height / 2 + ($h ? -$h / 2 : 0);
            return $C;
        }
        /**
        * set transparency
        *
        * @param mixed $Color
        * @return D3Image
        */
        public function Transparent($Color)
        {
            imagecolortransparent($this->image, $this->Color($Color));
            return $this;
            return $this->forEditores();
        }

        public function TurnOffBlending(){
            imagealphablending($this->image, false);
            imagesavealpha($this->image, true);
            return $this;
            return $this->forEditores();

        }

        public function getResourceId(){
            $a=(string)$this->image;
            return (int)preg_replace('/[^0-9]/i','',$a);
        }

        /**
        * Color Names Supported by All Browsers
        * @From : http://www.w3schools.com/HTML/html_colornames.asp
        * @param mixed $Name  Color Name
        */

        public function ColorByName($Name)
        {
            $ColorNames=array
            (
            'aliceblue'            => 'F0F8FF',
            'antiquewhite'         => 'FAEBD7',
            'aqua'                 => '00FFFF',
            'aquamarine'           => '7FFFD4',
            'azure'                => 'F0FFFF',
            'beige'                => 'F5F5DC',
            'bisque'               => 'FFE4C4',
            'black'                => '000000',
            'blanchedalmond'       => 'FFEBCD',
            'blue'                 => '0033FF',
            'blueviolet'           => '8A2BE2',
            'brown'                => 'A52A2A',
            'burlywood'            => 'DEB887',
            'cadetblue'            => '5F9EA0',
            'chartreuse'           => '7FFF00',
            'chocolate'            => 'D2691E',
            'coral'                => 'FF7F50',
            'cornflowerblue'       => '6495ED',
            'cornsilk'             => 'FFF8DC',
            'crimson'              => 'DC143C',
            'cyan'                 => '00FFFF',
            'darkblue'             => '00008B',
            'darkcyan'             => '008B8B',
            'darkgoldenrod'        => 'B8860B',
            'darkgray'             => 'A9A9A9',
            'darkgreen'            => '006400',
            'darkkhaki'            => 'BDB76B',
            'darkmagenta'          => '8B008B',
            'darkolivegreen'       => '556B2F',
            'darkorange'           => 'FF8C00',
            'darkorchid'           => '9932CC',
            'darkred'              => '8B0000',
            'darksalmon'           => 'E9967A',
            'darkseagreen'         => '8FBC8F',
            'darkslateblue'        => '483D8B',
            'darkslategray'        => '2F4F4F',
            'darkturquoise'        => '00CED1',
            'darkviolet'           => '9400D3',
            'deeppink'             => 'FF1493',
            'deepskyblue'          => '00BFFF',
            'dimgray'              => '696969',
            'dodgerblue'           => '1E90FF',
            'firebrick'            => 'B22222',
            'floralwhite'          => 'FFFAF0',
            'forestgreen'          => '228B22',
            'fuchsia'              => 'FF00FF',
            'gainsboro'            => 'DCDCDC',
            'ghostwhite'           => 'F8F8FF',
            'gold'                 => 'FFD700',
            'goldenrod'            => 'DAA520',
            'gray'                 => '808080',
            'green'                => '008000',
            'greenyellow'          => 'ADFF2F',
            'honeydew'             => 'F0FFF0',
            'hotpink'              => 'FF69B4',
            'indianred '           => 'CD5C5C',
            'indigo '              => '4B0082',
            'ivory'                => 'FFFFF0',
            'khaki'                => 'F0E68C',
            'lavender'             => 'E6E6FA',
            'lavenderblush'        => 'FFF0F5',
            'lawngreen'            => '7CFC00',
            'lemonchiffon'         => 'FFFACD',
            'lightblue'            => 'ADD8E6',
            'lightcoral'           => 'F08080',
            'lightcyan'            => 'E0FFFF',
            'lightgoldenrodyellow' => 'FAFAD2',
            'lightgrey'            => 'D3D3D3',
            'lightgreen'           => '90EE90',
            'lightpink'            => 'FFB6C1',
            'lightsalmon'          => 'FFA07A',
            'lightseagreen'        => '20B2AA',
            'lightskyblue'         => '87CEFA',
            'lightslategray'       => '778899',
            'lightsteelblue'       => 'B0C4DE',
            'lightyellow'          => 'FFFFE0',
            'lime'                 => '00FF00',
            'limegreen'            => '32CD32',
            'linen'                => 'FAF0E6',
            'magenta'              => 'FF00FF',
            'maroon'               => '800000',
            'mediumaquamarine'     => '66CDAA',
            'mediumblue'           => '0000CD',
            'mediumorchid'         => 'BA55D3',
            'mediumpurple'         => '9370D8',
            'mediumseagreen'       => '3CB371',
            'mediumslateblue'      => '7B68EE',
            'mediumspringgreen'    => '00FA9A',
            'mediumturquoise'      => '48D1CC',
            'mediumvioletred'      => 'C71585',
            'midnightblue'         => '191970',
            'mintcream'            => 'F5FFFA',
            'mistyrose'            => 'FFE4E1',
            'moccasin'             => 'FFE4B5',
            'navajowhite'          => 'FFDEAD',
            'navy'                 => '000080',
            'oldlace'              => 'FDF5E6',
            'olive'                => '808000',
            'olivedrab'            => '6B8E23',
            'orange'               => 'FFA500',
            'orangered'            => 'FF4500',
            'orchid'               => 'DA70D6',
            'palegoldenrod'        => 'EEE8AA',
            'palegreen'            => '98FB98',
            'paleturquoise'        => 'AFEEEE',
            'palevioletred'        => 'D87093',
            'papayawhip'           => 'FFEFD5',
            'peachpuff'            => 'FFDAB9',
            'peru'                 => 'CD853F',
            'pink'                 => 'FFC0CB',
            'plum'                 => 'DDA0DD',
            'powderblue'           => 'B0E0E6',
            'purple'               => '800080',
            'red'                  => 'FF0000',
            'rosybrown'            => 'BC8F8F',
            'royalblue'            => '4169E1',
            'saddlebrown'          => '8B4513',
            'salmon'               => 'FA8072',
            'sandybrown'           => 'F4A460',
            'seagreen'             => '2E8B57',
            'seashell'             => 'FFF5EE',
            'sienna'               => 'A0522D',
            'silver'               => 'C0C0C0',
            'skyblue'              => '87CEEB',
            'slateblue'            => '6A5ACD',
            'slategray'            => '708090',
            'snow'                 => 'FFFAFA',
            'springgreen'          => '00FF7F',
            'steelblue'            => '4682B4',
            'tan'                  => 'D2B48C',
            'teal'                 => '008080',
            'thistle'              => 'D8BFD8',
            'tomato'               => 'FF6347',
            'turquoise'            => '40E0D0',
            'violet'               => 'EE82EE',
            'wheat'                => 'F5DEB3',
            'white'                => 'FFFFFF',
            'whitesmoke'           => 'F5F5F5',
            'yellow'               => 'FFFF00',
            'yellowgreen'          => '9ACD32'
            );


            return $ColorNames[trim(strtolower($Name))];
        }
        /**
        * this func is only for noob editores (:
        *
        */
        function forEditores()
        {
            die ('Don\'t Use This Function. forEditores() It\'s Only For noob  Editores to show Functions as add()->add()->write() etc.');
            return new D3Image();
        }
    }


?>
<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Filesystem\Filesystem;

/*use \Symfony\Component\HttpFoundation\File\File;
use \Symfony\Component\HttpFoundation\File\UploadedFile;*/
/*

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;

use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\HttpFoundation\Session\Session;

//use Imagick;
use Symfony\Component\HttpFoundation\BinaryFileResponse;*/
use Symfony\Component\HttpFoundation\ResponseHeaderBag;




class ImageController extends Controller
{
    /**
     * @Route("/admin_deleteproductimagelist", name="admin_deleteproductimagelist")
     */
    public function admin_DeleteProductImageList(Request $request){
        
        $return="Delete files: ";
        
        $datajson = $request->request->get('datajson');
        $parametersAsArray = [];
        
        if ($parametersAsArray = json_decode($datajson, true)) {
            
            $em = $this->getDoctrine()->getManager();
            $fs = new Filesystem();
            
            foreach($parametersAsArray as $id){
                $productImage = $this->getDoctrine()
                        ->getRepository(\App\Entity\ProductImage::class)
                        ->find($id);
                
                $productImageFile=$this->getParameter('path_imageproducts').$productImage->getName();
                
                $return=$return.$productImageFile." * ";
                
                $exfile = $fs->exists($productImageFile);
                if ($exfile){
                    $fs->remove($productImageFile);
                }

                $em->remove($productImage);
                
            }
            
            $em->flush();
        }
        
        return new Response($return);
    }    
    
    /**
     * @Route("/admin_productimagesave", name="admin_productimagesave")
     */
    public function admin_ProductImageSave(Request $request){
        $id = $request->request->get('prodid');
        $imagecount = $request->request->get('imagecount');

        $em = $this->getDoctrine()->getManager();
        $product=null;
        if ($id==0){
            $product = new \App\Entity\Product();
            $em->persist($product);
        }else{
            $product = $this->getDoctrine()
                ->getRepository(\App\Entity\Product::class)
                ->find($id);
        }
        
        $fs = new Filesystem();
        for($i=1;$i<=$imagecount;$i++){
            $image = $request->files->get("image".$i);
            //$f = new UploadedFile();
            $exfile = $fs->exists($image);
            if ($exfile){
                $exten = $image->guessExtension();
                if ($exten=='jpeg'){
                    $newfileName = md5(uniqid()).'.'.$exten;
                    $image = $image->move($this->getParameter('path_imageproducts'),$newfileName);

                    $prodimage = new \App\Entity\ProductImage();
                    $prodimage->setProductId($prodimage->getId());
                    $prodimage->setName($newfileName);
                    $prodimage->setProductId($product);
                    $em->persist($prodimage);
                };
            }
        }
        
        $em->flush();
        
        $id=$product->getId();
        //получение скалярной величины
        $product = $this->getDoctrine()
                ->getRepository(\App\Entity\Product::class)
                ->byId($id);
        
        $json=json_encode($product,JSON_UNESCAPED_UNICODE);
        

        /*$productImages = $this->getDoctrine()
                ->getRepository(\App\Entity\ProductImage::class)
                ->byProdId($id);
        $json=json_encode($productImages,JSON_UNESCAPED_UNICODE);*/
        
        return new Response($json);
    }
    
    /**
     * @Route("/productimagebyid", name="productimagebyid")
     */    
    public function productimagesById(Request $request){
        $idprod = $request->request->get('prodid');
        $productImages = $this->getDoctrine()
                ->getRepository(\App\Entity\ProductImage::class)
                ->byProdId($idprod);
        $json=json_encode($productImages,JSON_UNESCAPED_UNICODE);
        //$json = 'idprod='.$idprod;
        return new Response($json);
    }


    /* -- image --*/
    /* imageproc (image procedure) - full mini square-mini*/
    /**
     * @Route("/productimage/{imageproc}/{name}", name="productimage")
     */
    public function productimage($imageproc,$name){
        
        //http://php.net/manual/ru/book.image.php
        //https://www.thoughtco.com/gd-library-basics-drawing-with-php-2693791
        //http://permadi.com/2010/03/using-php-gd-to-create-images/
        
        $path=$this->getParameter('path_imageproducts').$name;
        //$path=str_replace("/","\\",$path); //под линуксом не работает
        $im = imagecreatefromjpeg($path);

        if ( in_array( strtolower($imageproc) , array('square','square-mini') ) ){
            $width = imagesx($im);
            $height = imagesy($im);
            $minsize = min($width , $height);
            $x=0;
            $y=0;
            if ($width>$height){
              $x=$width/2-$height/2;
            }else{
                $y=$height/2-$width/2;
            }
            $imCrop = imagecrop($im, ['x' => $x, 'y' => $y, 'width' => $minsize, 'height' => $minsize]);
            imagedestroy($im);
            $im=$imCrop;
        }        
        if ( in_array( strtolower($imageproc) , array('mini','square-mini') ) ){
            $width = imagesx($im);
            $height = imagesy($im);
            $minsize = max($width , $height);
            $zoom = $minsize/200;
            $newwidth = imagesx($im)/$zoom;
            $newheight = imagesy($im)/$zoom;
            $miniImage = imagecreatetruecolor($newwidth, $newheight);
            imagecopyresized($miniImage, $im, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
            imagedestroy($im);
            $im=$miniImage;
        }
        //$text_color = imagecolorallocate($im2, 233, 14, 91);
        //imagestring($im2, 10, 50, 50,  'A Simple Text String', $text_color);
        
        $response = new Response();
        $disposition = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_INLINE, "TESTIMAGE");
        $response->headers->set('Content-Disposition', $disposition);
        $response->headers->set('Content-Type', 'image/jpeg');
        $response->sendHeaders();
        $response->setContent( imagejpeg($im) );

        return $response;
    }
    
    public function product_cash($size, $idprod, $max, $data){
        $filename = $this->getParameter('path_cash')."product-".$size."-".$idprod."-".$max.".jpeg";
        
        if ( empty($data) ){//if (count($data)==0){
            if (file_exists($filename)){
                
                /*$t1 = filemtime($filename);
                $t2 = time();
                if ($t2-$t1>3600) {return array();}*/
                
                $file = fopen($filename,"r");
                $data = fread($file,filesize($filename));
                fclose($file);
                return $data;                
            }else {
                return '';//array();
            }
        }else{
            imagejpeg($data,$filename);
            $file = fopen($filename,"r");
            $data = fread($file,filesize($filename));
            fclose($file);
            return $data;
        }
    }
    public function type_cash($size,$idtype, $data){
        $filename = $this->getParameter('path_cash')."type-".$size."-".$idtype.".jpeg";
        
        if (empty($data)){
            if (file_exists($filename)){
                
                /*$t1 = filemtime($filename);
                $t2 = time();
                if ($t2-$t1>3600) {return array();}*/
                
                $file = fopen($filename,"r");
                $data = fread($file,filesize($filename));
                fclose($file);
                return $data;                
            }else {
                return array();
            }
        }else{
            imagejpeg($data,$filename);
            $file = fopen($filename,"r");
            $data = fread($file,filesize($filename));
            fclose($file);
            return $data;
        }
    }    
    /*public function delete_product_cash($idprod){
    } */   
    
    // все и изображения товара в горизонтальный спрайт
    /**
     * @Route("/sprite/{size}/{idprod}/{max}", name="sprite" ,defaults={"max"=10})
     */
    public function sprite($size,$idprod,$max){
        
        //$response = new Response($this->getParameter('path_imageproducts'));
        //return $response;
        
        /*cash*/
            $data = $this->product_cash($size, $idprod, $max, null);//array()
            //dump($data);
            if ( !empty($data) ){//(count($data)>0){
                $response = new Response();
                $disposition = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_INLINE, "TESTIMAGE");
                $response->headers->set('Content-Disposition', $disposition);
                $response->headers->set('Content-Type', 'image/jpeg');
                $response->sendHeaders();
                $response->setContent($data);
                return $response;    
            }
        /*-cash*/
        
        $productImages = $this->getDoctrine()
                ->getRepository(\App\Entity\ProductImage::class)
                ->byProdId($idprod);
        
        $count=count($productImages);
        
        //нет изображений
        if ($count==0){
            return new Response();
        }        
        
        if($count>$max) $count=$max;
        
        if ($count>0){
            
            $sprite = imagecreatetruecolor($size*$count, $size);
                
            /*$path=$this->getParameter('path_imageproducts').$productImages[0]["p_Name"];
            $path=str_replace("/","\\",$path);
            $sprite = imagecreatefromjpeg($path);
            $sprite=imagescale($sprite,$size*$count, $size);*/
            $bg = imagecolorallocate ( $sprite, 255, 255, 255 );
            imagefilledrectangle($sprite,0,0,imagesx($sprite),imagesy($sprite),$bg);
            
            $xPos=0;
            foreach ($productImages as $img) {
                //dump($img["p_Id"]);
                //dump($img["p_Name"]);
                //dump($img["p_Description"]);

                $path=$this->getParameter('path_imageproducts').$img["p_Name"];
                //$path=str_replace("/","\\",$path); //под линуксом не работает
                $im = imagecreatefromjpeg($path);

                //CROP
                $width = imagesx($im);
                $height = imagesy($im);
                $minsize = min($width , $height);
                $x=0;
                $y=0;
                if ($width>$height){
                  $x=$width/2-$height/2;
                }else{
                    $y=$height/2-$width/2;
                }
                $imCrop = imagecrop($im, ['x' => $x, 'y' => $y, 'width' => $minsize, 'height' => $minsize]);
                imagedestroy($im);
                $im=$imCrop;
                
                //text
                /*$textcolor = imagecolorallocate($im, 0,0,0);
                $font = 'arial.ttf';
                $textsize=60;
                imagettftext($im, $textsize, 0, 10, $textsize, $textcolor , $font, ($xPos+1));*/

                //COPY TO SPRITE
                $width = imagesx($im);
                $zoom = $width/$size;
                $newwidth = $width/$zoom;
                //$miniImage = imagecreatetruecolor($newwidth, $newheight);
                imagecopyresized($sprite, $im, $xPos*$size, 0, 0, 0, $newwidth, $newwidth, $width, $width);
                imagedestroy($im);
                
                $xPos=$xPos+1;
                
                if($xPos==$max) break;
            }
        }
        
        $response = new Response();
        
        /*cash*/
        $data = $this->product_cash($size, $idprod, $max, $sprite);
        /*-cash*/
        
        $disposition = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_INLINE, "TESTIMAGE");
        $response->headers->set('Content-Disposition', $disposition);
        $response->headers->set('Content-Type', 'image/jpeg');
        $response->sendHeaders();
        $response->setContent( $data );//$data //imagejpeg($sprite)
        
        return $response;
    }    

    
    //выборочно изображения товаров одного типа в горизонтальный спрайт
    /**
     * @Route("/spritetype/{size}/{idtype}", name="spritetype")
     */
    public function typeSprite($size,$idtype){
        
        /*cash*/
            $data = $this->type_cash($size, $idtype, null);
            if (!empty($data)>0){
                $response = new Response();
                $disposition = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_INLINE, "TESTIMAGE");
                $response->headers->set('Content-Disposition', $disposition);
                $response->headers->set('Content-Type', 'image/jpeg');
                $response->sendHeaders();
                $response->setContent($data);
                return $response;    
            }
        /*-cash*/        
        
        
        $GET_IMAGE_CNT = 4;//больше 1
        
        if ($idtype==0){
        $productImages = $this->getDoctrine()
                ->getRepository(\App\Entity\ProductImage::class)
                ->Limit();
        }else{
        $productImages = $this->getDoctrine()
                ->getRepository(\App\Entity\ProductImage::class)
                ->byTypeId($idtype);
        }
        
        $imageCount = count($productImages);

        //нет изображений
        if ($imageCount==0){
            return new Response();
        }
        if ($imageCount>1){
            //выбор случайных $GET_IMAGE_CNT изображений
            $elemCount = $GET_IMAGE_CNT;
            if ($imageCount < $elemCount ) $elemCount=$imageCount;
            $randomIndex = array_rand($productImages, $elemCount);
            $rndProductImages = array();
            foreach ($randomIndex as $index) {
                $rndProductImages[] = $productImages[$index];
            }
            $productImages = $rndProductImages;
        }
        
        //dump($productImages);
        //$json=json_encode($productImages,JSON_UNESCAPED_UNICODE);
        //return new Response($json);
        
        $count=count($productImages);
        if ($count>0){
            
            $sprite = imagecreatetruecolor($size*$count, $size);
                
            $bg = imagecolorallocate ( $sprite, 255, 255, 255 );
            imagefilledrectangle($sprite,0,0,imagesx($sprite),imagesy($sprite),$bg);
            
            $xPos=0;
            foreach ($productImages as $img) {
                //dump($img["i_Id"]);
                //dump($img["i_Name"]);
                //dump($img["i_Description"]);

                $path=$this->getParameter('path_imageproducts').$img["i_Name"];
                //$path=str_replace("/","\\",$path); //под линуксом не работает
                $im = imagecreatefromjpeg($path);

                //CROP
                $width = imagesx($im);
                $height = imagesy($im);
                $minsize = min($width , $height);
                $x=0;
                $y=0;
                if ($width>$height){
                  $x=$width/2-$height/2;
                }else{
                    $y=$height/2-$width/2;
                }
                $imCrop = imagecrop($im, ['x' => $x, 'y' => $y, 'width' => $minsize, 'height' => $minsize]);
                imagedestroy($im);
                $im=$imCrop;
                
                //Text
                /*$textcolor = imagecolorallocate($im, 0,0,0);
                $font = 'arial.ttf';
                $textsize=60;
                imagettftext($im, $textsize, 0, 10, $textsize, $textcolor , $font, ($xPos+1));*/

                //COPY TO SPRITE
                $width = imagesx($im);
                $zoom = $width/$size;
                $newwidth = $width/$zoom;
                //$miniImage = imagecreatetruecolor($newwidth, $newheight);
                imagecopyresized($sprite, $im, $xPos*$size, 0, 0, 0, $newwidth, $newwidth, $width, $width);
                imagedestroy($im);
                $xPos=$xPos+1;
            }
        }
        
        /*cash*/
        $data = $this->type_cash($size, $idtype, $sprite);
        /*-cash*/
        
        $response = new Response();
        
        $disposition = $response->headers->makeDisposition(ResponseHeaderBag::DISPOSITION_INLINE, "TESTIMAGE");
        $response->headers->set('Content-Disposition', $disposition);
        $response->headers->set('Content-Type', 'image/jpeg');
        $response->sendHeaders();
        $response->setContent( $data );//imagejpeg($sprite)
        
        return $response;
    }
    
}
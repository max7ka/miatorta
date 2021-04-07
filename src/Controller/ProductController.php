<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Filesystem\Filesystem;
use \Symfony\Component\HttpFoundation\File\File;
use \Symfony\Component\HttpFoundation\File\UploadedFile;


use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;

use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\HttpFoundation\Session\Session;

//use Imagick;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;


use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
//use App\Security\WebserviceUser;
use App\Entity\User;

use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


//use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\HttpFoundation\JsonResponse;

//use Symfony\Component\DependencyInjection\ContainerBuilder;

//use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    private $encoder;
    private $authChecker;
    public function __construct(UserPasswordEncoderInterface $encoder,AuthorizationCheckerInterface $authChecker){
        $this->encoder = $encoder;
        $this->authChecker = $authChecker;
    }

    /**
     * @Route("/AccessDenied",name="AccessDenied")
     */
    public function AccessDenied(){
        return $this->render('AccessDenied.html.twig');
    }

    /**
     * @Route("/",name="index")
     */
    public function index(){
        //dump(new JsonResponse($producttypeArray));
        //$a= new \Symfony\Component\HttpFoundation\JsonResponse($producttypeArray);
        //$a= new \Symfony\Component\HttpFoundation\JsonResponse(array('data' => 123));
        //dump($a);

        //$manager = $this->getDoctrine()->getManager();
        //$repository = $manager->getRepository(\App\Entity\ProductType::class);
        /*$producttypeArray = $repository->createQueryBuilder('e')
            ->select('count(e.id)')
            ->getQuery()
            ->getSingleScalarResult();*/

        //dump($producttypeArray[0].Name);//["Name"]
        /*foreach($producttypeArray as $prod){
            dump($prod->getName());
        }*/

        /*
        $producttypeArray=$this->getDoctrine()->getRepository(\App\Entity\ProductType::class)->findAll();
        //$encoders = array(new XmlEncoder(),new JsonEncoder());
        $encoders = array(new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);
        $json = $serializer->serialize($producttypeArray, 'json');
        dump($json);
         */

        /*
        $serializer = new Serializer(array(new ObjectNormalizer()), array(new JsonEncoder()));
        $json = $serializer->serialize($producttypeArray, 'json');
        dump($json);
         */

        /*$producttypeArray=$this->getDoctrine()->getRepository(\App\Entity\ProductType::class)->findAll();
        $serializer = new Serializer(array(new GetSetMethodNormalizer()), array(new JsonEncoder()));
        //$serializer = $serializer->serialize($producttypeArray, 'json');
        $response = new Response($serializer->serialize($producttypeArray, 'json'));
        //$response=new Response($serializer);
        $response->headers->set('Content-Type', 'application/json');
        dump($response);*/

        /*$producttypeArray=$this->getDoctrine()->getRepository(\App\Entity\ProductType::class)->findAll();
        $encoder = new JsonEncoder();
        $normalizer = new GetSetMethodNormalizer();
        $serializer = new Serializer(array($normalizer), array($encoder));
        $json=$serializer->serialize($producttypeArray, 'json');

        $jsonResponse = new JsonResponse($json);

        dump($json);
        dump($jsonResponse);*/

            //$em = $this->getDoctrine()->getManager();
            //$repository = $em->getRepository(\App\Entity\ProductType::class);
            //$repository->

        //$producttypeArray = $this->getDoctrine()->getRepository(\App\Entity\ProductType::class)->All();

            /*$encoders = array(new JsonEncoder());
            $normalizers = array(new GetSetMethodNormalizer());
            $serializer = new Serializer($normalizers, $encoders);
            $response = new Response($serializer->serialize($producttypeArray, 'json'));
            $response->headers->set('Content-Type', 'application/json');
            dump($response);*/

            //https://ru.stackoverflow.com/questions/37998/%D0%9A%D0%B8%D1%80%D0%B8%D0%BB%D0%BB%D0%B8%D1%86%D0%B0-%D0%B2-json-encode
        //$json=json_encode($producttypeArray,JSON_UNESCAPED_UNICODE);
        //dump($json);


        //http://symfony.com/doc/current/components/http_foundation/sessions.html
        //$session = new Session();
        //$session->start();
        //$session->set('myname', 'Maksim P');

        //$this->getUser()->setAttribute('myname', 'Maksim');

        /*$session = new Session();
        $session->start();
        $session->set('myname', 'Maksim');*/

        //$_SESSION['user']['myname'] = 'Maksim';

        //$response = new Response($json);
        //$response->

        //$json = json_decode($product,true);
        //$jsonResponse = new JsonResponse($product);
        //dump($jsonResponse);


        //user encoder
        //$authenticationUtils = $this->get('security.authentication_utils');
        //$error = $authenticationUtils->getLastAuthenticationError();
        //$lastUsername = $authenticationUtils->getLastUsername();





        //https://symfony.com/doc/current/security/password_encoding.html
        /*$user = new WebserviceUser("admin", "911", "", []);
        $encoded = $this->get('security.password_encoder')->encodePassword($user, "911");
        $user->setPassword( $encoded );
        $passwordValid = $this->get('security.password_encoder')->isPasswordValid($user, '911');
        dump($user,$encoded,$passwordValid);*/

        //$user = $this->getDoctrine()
        //                ->getRepository(\App\Entity\User::class)
        //                ->loadUserByUsername('user1');
        //$user->setPlainPassword('911');
        //$passwordValid=$this->encoder->isPasswordValid($user, '9112');
        //dump($user,$passwordValid);

        //$userlist = $this->getDoctrine()
        //                ->getRepository(\App\Entity\User::class)
        //                ->All();
        //dump($userlist);

        /*$user=new User();
        $user->setUsername('user1');
        $user->setEmail('user1@mail.ru');
        $user->setPlainPassword('911');
        $password=$this->encoder->encodePassword($user,$user->getPlainPassword());
        $user->setPassword($password);
        $passwordValid=$this->encoder->isPasswordValid($user, '911');
        dump($passwordValid);*/


        /*$user=new User();
        $user->setUsername('user1');
        $user->setEmail('user1@mail.ru');
        $user->setPlainPassword('911');
        $password=$this->encoder->encodePassword($user,$user->getPlainPassword());
        $user->setPassword($password);
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();      */



        //$user2 = new WebserviceUser("admin", "911", "qwerty", ["ROLE_ADMIN"]);
        //$passwordValid = $this->encoder->isPasswordValid($user2, $encoded);
        //dump($user,$user2,$encoded,$passwordValid);

        /*$user2 = new WebserviceUser('admin','911','qwerty',array('ROLE_ADMIN'));
        $encoded2 = $this->encoder->encodePassword($user, '911');

        $user3 = new WebserviceUser('admin','911','qwerty',array('ROLE_ADMIN'));
        $encoded3 = $this->encoder->encodePassword($user, '911');

        $passwordValid = $this->encoder->isPasswordValid($user, "qwerty{911}");
        $passwordValid2 = $this->encoder->isPasswordValid($user2, $encoded2);
        dump($authenticationUtils,$error,$lastUsername,$user,$encoded,$user2,$encoded2,$user3,$encoded3,$passwordValid,$passwordValid2);*/

        return $this->render('base.html.twig');
    }

    /**
     * @Route("/test", name="test")
     */
    public function test(Request $request){
        return $this->render('test.html.twig');
    }

    /**
     * @Route("/admin_productform", name="admin_productform")
     */
    public function admin_ProductForm(){
        //$this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');
        /*if (!$this->authChecker->isGranted('ROLE_ADMIN')){
            //throw new AccessDeniedException('Unable to access this page!');
            //Message_AccessDenied.html.twig
            return $this->render('Message_AccessDenied.html.twig');
        }*/
        return $this->render('ProductForm.html.twig');
        //return $this->render('@Maker/demoPage.html.twig', [ 'path' => str_replace($this->getParameter('kernel.project_dir').'/', '', __FILE__) ]);
    }

    /**
     * @Route("/admin_clearcash", name="admin_clearcash")
     */
    public function admin_ClearCash(){
        $files = glob($this->getParameter('path_cash').'*');
        foreach($files as $file){
            if(is_file($file))
                unlink($file); // delete file
        }
        return $this->redirectToRoute('index');
    }

    /**
     * @Route("/admin_producttypeform", name="admin_producttypeform")
     */
    public function admin_ProductTypeForm(Request $request){//Request $request
        //$user=$request->getSession()->get('myname');
        //$username=$user['myname'];
        //$user=$_SESSION['myname'];
        //dump($user);
        return $this->render('ProductTypeForm.html.twig');
    }

    /**
     * @Route("/admin_producttypesave", name="admin_producttypesave")
     */
    public function admin_ProductTypeSave(Request $request){

        $datajson = $request->request->get('datajson');
        $parametersAsArray = [];
        $em = $this->getDoctrine()->getManager();
        if ($parametersAsArray = json_decode($datajson, true)) {
            foreach($parametersAsArray as $param){

                $id=$param["TypeId"];
                $name=$param["TypeName"];
                $description=$param["TypeDescription"];
                $_delete=$param["_delete"];

                if ($id==0 && $_delete==true) {continue;}

                if ($id==0){
                    $producttype = new \App\Entity\ProductType();
                }else{
                    $producttype = $this->getDoctrine()
                        ->getRepository(\App\Entity\ProductType::class)
                        ->find($id);
                }

                if ($_delete==true){
                    $em->remove($producttype);
                    //$em->flush();
                }else{
                    $producttype->setName($name);
                    $producttype->setDescription($description);
                    $em->persist($producttype);
                    //$em->flush();
                }
            }
        }
        $em->flush();

        /*$producttypeArray=$this->getDoctrine()->getRepository(\App\Entity\ProductType::class)->findAll();

        //$serializer = new Serializer(array(new ObjectNormalizer()), array(new JsonEncoder()));
        $serializer = new Serializer(array(new GetSetMethodNormalizer()), array(new JsonEncoder()));
        $json = $serializer->serialize($producttypeArray, 'json');
        //dump($json);*/

        //+++++ $username=$request->getSession()->get('myname');

        $producttypeArray=$this->getDoctrine()->getRepository(\App\Entity\ProductType::class)->All();
        $json=json_encode($producttypeArray,JSON_UNESCAPED_UNICODE);

        return new Response($json);
        //return new Response('*'.$username.'*');
    }

    /**
     * @Route("/admin_producttypeload", name="admin_producttypeload")
     */
    public function admin_ProductTypeLoad(){
        $producttypeArray=$this->getDoctrine()->getRepository(\App\Entity\ProductType::class)->All();
        $json=json_encode($producttypeArray,JSON_UNESCAPED_UNICODE);
        return new Response($json);
    }



    /*------------  PRODUCT  -----------------*/


    //показать полную информацию по товару
    //роутинг по product.url или product.id
    /**
     * @Route("/anonymous_oneproductload", name="anonymous_oneproductload")
     */
    public function anonymous_OneProductLoad(Request $request){

        $produrl_or_id = urldecode($request->request->get('prodid'));
        /*$parametersAsArray = [];
        if ($param = json_decode($datajson, true)) {
            $id=$param["TypeId"];
        }*/
        //return new Response($produrl_or_id);

        //проверять, явдяется ли $produrl_or_id - int
        $id = (int) $produrl_or_id;
        if ($id>0){
            $product=$this->getDoctrine()->getRepository(\App\Entity\Product::class)->byId($produrl_or_id);
            if ($product!=null){
                $json=json_encode($product,JSON_UNESCAPED_UNICODE);
                //return new Response("~id=".$produrl_or_id."~".$json);
                return new Response($json);
            }
        }
        if ($id==0 && strlen($produrl_or_id)>0){
            //красивый url
            $product=$this->getDoctrine()->getRepository(\App\Entity\Product::class)->byUrl($produrl_or_id);
            if ($product!=null){
                $json=json_encode($product,JSON_UNESCAPED_UNICODE);
                //return new Response("~url=".$produrl_or_id."~".$json);
                return new Response($json);
            }
        }
        //return new Response('{"p_Name":"Нет данных"}');
        return new Response('');
    }

    /**
     * @Route("/admin_productload", name="admin_productload")
     */
    public function admin_ProductLoad(){
        $productArray=$this->getDoctrine()->getRepository(\App\Entity\Product::class)->All();
        $json=json_encode($productArray,JSON_UNESCAPED_UNICODE);
        return new Response($json);
    }
    /**
     * @Route("/anonymous_productload", name="anonymous_productload")
     */
    public function anonymous_ProductLoad(Request $request){
        $typeid = $request->request->get('typeid');
        //dump($typeid);
        //return new Response($typeid);
        if ($typeid>0){
            $productArray=$this->getDoctrine()->getRepository(\App\Entity\Product::class)->byType($typeid);
            $json=json_encode($productArray,JSON_UNESCAPED_UNICODE);
            return new Response($json);
        }else{
            $productArray=$this->getDoctrine()->getRepository(\App\Entity\Product::class)->All();
            $json=json_encode($productArray,JSON_UNESCAPED_UNICODE);
            return new Response($json);
        }
    }
    /**
     * @Route("/anonymous_productlimitimagesload", name="anonymous_productlimitimagesload")
     */
    public function anonymous_ProductLimitImgeasLoad(Request $request){
        $imageslimit = $request->request->get('imageslimit');
        //dump($typeid);
        //return new Response($typeid);
        if ($imageslimit>0){
            $productArray=$this->getDoctrine()->getRepository(\App\Entity\Product::class)->AllLimitImages($imageslimit);
            /*random limit*/
            $maxRandomCnt = 8;
            $maxRandomCnt = count($productArray)<$maxRandomCnt?count($productArray):$maxRandomCnt;
            $randomIndex = array_rand($productArray, $maxRandomCnt);
            $rndProduct = array();
            foreach ($randomIndex as $index) {
                $rndProduct[] = $productArray[$index];
            }
            $productArray = $rndProduct;
            /*-random limit*/
            $json=json_encode($productArray,JSON_UNESCAPED_UNICODE);
            return new Response($json);
            //return new Response($imageslimit);
        }else{
            return new Response('2');
        }
    }
    /**
     * @Route("/anonymous_typesload", name="anonymous_typesload")
     */
    public function anonymous_ProductTypeLoad(){
        $productTypeArray=$this->getDoctrine()->getRepository(\App\Entity\ProductType::class)->All();
        $json=json_encode($productTypeArray,JSON_UNESCAPED_UNICODE);
        return new Response($json);
    }

    /**
     * @Route("/admin_productsave", name="admin_productsave")
     */
    public function admin_ProductSave(Request $request){

        //$log="";

        $datajson = $request->request->get('datajson');
        $parametersAsArray = [];
        $em = $this->getDoctrine()->getManager();

        $fs = new Filesystem();

        if ($parametersAsArray = json_decode($datajson, true)) {
            foreach($parametersAsArray as $param){

                $id=$param["ProdId"];
                $name=$param["ProdName"];
                $description=$param["ProdDescription"];
                $url=$param["ProdUrl"];
                $type=isset($param["ProdTypeId"])?$param["ProdTypeId"]:0;
                $_delete=$param["_delete"];
                $PricePerKilogram=$param["ProductPricePerKilogram"];
                $MinWeight=$param["ProductMinWeight"];
                $MaxWeight=$param["ProductMaxWeight"];
                $StepWeight=$param["ProductStepWeight"];

                //$log=$log.$type;

                if ($id==0 && $_delete==true) {continue;}

                if ($id==0){
                    $product = new \App\Entity\Product();
                }else{
                    $product = $this->getDoctrine()
                        ->getRepository(\App\Entity\Product::class)
                        ->find($id);
                }

                if ($_delete==true){
                    $em->remove($product);
                    /*Удалить фото*/
                    $prodImages = $this->getDoctrine()
                            ->getRepository(\App\Entity\ProductImage::class)
                            ->GetProductImagesByProdId($id);

                    foreach ($prodImages as $productImage){
                        $productImageFile=$this->getParameter('path_imageproducts').$productImage->getName();
                        $exfile = $fs->exists($productImageFile);
                        if ($exfile){
                            $fs->remove($productImageFile);
                        }
                        $em->remove($productImage);

                    }
                    /*-Удалить фото*/
                }else{
                    $product->setName($name);
                    $product->setDescription($description);
                    $product->setUrl($url);
                    $product->setProductMaxWeight($MaxWeight);
                    $product->setProductMinWeight($MinWeight);
                    $product->setProductStepWeight($StepWeight);
                    $product->setProductPricePerKilogram($PricePerKilogram);


                    if ($type>0){
                        $producttype = $this->getDoctrine()
                                ->getRepository(\App\Entity\ProductType::class)
                                ->find($type);
                        $product->setTypeKind($producttype);
                    }

                    $em->persist($product);
                }
            }
        }
        $em->flush();
        $productArray=$this->getDoctrine()->getRepository(\App\Entity\Product::class)->All();
        $json=json_encode($productArray,JSON_UNESCAPED_UNICODE);
        return new Response($json);


        ////////////////////



        /*$id = $request->request->get('id');
        $typekind = $request->request->get('typekind');
        $name = $request->request->get('name');
        $description = $request->request->get('description');
        $url = $request->request->get('url');

        $imagecount = $request->request->get('imagecount');

        $fs = new Filesystem();
        //--$fl = new File();
        for($i=1;$i<=$imagecount;$i++){
            $image = $request->files->get("image".$i);
            //$f = new UploadedFile();
            //$f->gu
            $exfile = $fs->exists($image);
            if ($exfile){
                $exten = $image->guessExtension();
                //$image = $image->move($image->getPath(),"aaaaaa".$i.".jpg");
                $newfileName = md5(uniqid()).'.'.$exten;
                $image = $image->move($this->getParameter('path_imageproducts'),$newfileName);
            }
        }

        $em = $this->getDoctrine()->getManager();

        if ($id==0){
            $product = new \App\Entity\Product();
        }else{
            $product = $this->getDoctrine()
                ->getRepository(\App\Entity\Product::class)
                ->find($id);
        }
        //$em->remove($object)
        $product->setName($name);
        $product->setDescription($description);
        $product->setUrl($url);

        $em->persist($product);
        $em->flush();
        //$product

        //dump($val1);
        //dump($val2);
        //$html="Данные успешно сохранились name=".$name." description=".$description." image=".$image." ".(($exfile)?"ok":"error").$image->guessExtension().$image->getPath();
        $html="Данные успешно сохранились name=".$name." description=".$description." imagecount=".$imagecount.$this->getParameter('path_imageproducts');
        return new Response($html);
        //return $this->render('@Maker/demoPage.html.twig', [ 'path' => str_replace($this->getParameter('kernel.project_dir').'/', '', __FILE__) ]);
        */
    }

}

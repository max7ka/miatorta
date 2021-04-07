<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class LoginController extends Controller
{
    //https://symfony.com/doc/current/security/form_login_setup.html
 
    private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder){
        $this->encoder = $encoder;
    }      
    
    //админ регистрирует другого админа(ADMIN) или пользователя (USER)
    /**
     * @Route("/admin_userregistry",name="admin_userregistry")
     */
    public function admin_UserRegistry(Request $request){
        $username = $request->request->get('username');
        $email = $request->request->get('email');
        $password = $request->request->get('password');
        $role = $request->request->get('role');
        $error = '';
        
        $datajson = $request->request->get('datajson');
        
        //dump($request,$username ,$email, $role, $datajson);
        //dump(isset($username),isset($password),isset($role));
        
        $parametersAsArray = [];
        $em = $this->getDoctrine()->getManager();
        if ($parametersAsArray = json_decode($datajson, true)) {
            foreach($parametersAsArray as $param){
                $_username=$param["UserName"];//username - другая форма передачи json
                $_delete=$param["_delete"];
                if ($_delete==true){
                    $_user = $this->getDoctrine()
                            ->getRepository(\App\Entity\User::class)
                            ->byUserName($_username);
                    dump($_user);
                    $em->remove($_user);
                }
            }
        }        
        $em->flush();
        
        //if (isset($username) && isset($password) && isset($role)){
        if ($username!="" && $password!="" && $role!=""){
            if( !in_array($role, array('ROLE_ADMIN','ROLE_USER')) ){
                $error='Ошибка регистрации. Role error.';
            }
            if($error==''){
                //проверка на существование usera
                $user = $this->getDoctrine()
                                ->getRepository(\App\Entity\User::class)
                                ->loadUserByUsername($username);
                if(isset($user)){
                    $error=$username.' уже зарегистрирован.';
                }else{
                    $user = $this->getDoctrine()
                                ->getRepository(\App\Entity\User::class)
                                ->loadUserByUsername($email);  
                    if(isset($user)){
                        $error=$email.' уже зарегистрирован.';
                    }
                }
            }
            if($error==''){
                $user = new \App\Entity\User();
                $user->setEmail($email);
                $user->setPlainPassword($password);
                $password=$this->encoder->encodePassword($user,$user->getPlainPassword());
                $user->setPassword($password);
                $user->setUsername($username);
                $user->setRoles($role);
                $em->persist($user);
                $error=$username.' успешно зарегистрирован';
            }
        }else{
            $error='Ошибка регистрации. Не все данные заполнены.';
        }
        $em->flush();

        $userArray=$this->getDoctrine()->getRepository(\App\Entity\User::class)->All();
        $json=json_encode($userArray,JSON_UNESCAPED_UNICODE);
        
        $respReturn = $this->render('UserRegistryByAdmin.html.twig', array(
            'error' => $error,
            'json'  => $json
        ));
        /*$respReturn->headers->set('Cache-Control', 'no-cache, no-store, must-revalidate');
        $respReturn->headers->set('Pragma', 'no-cache');
        $respReturn->headers->set('Expires', '0');  */
        
        return  $respReturn;        
    }   
    
    //возвращает json список пользователей
    /**
     * @Route("/admin_usersload",name="admin_usersload")
     */
    public function admin_UsersLoad(){
        $userArray=$this->getDoctrine()->getRepository(\App\Entity\User::class)->All();
        $json=json_encode($userArray,JSON_UNESCAPED_UNICODE);
        return new Response($json);        
    }
    
    /**
     * @Route("/login",name="login")
     */
    public function login(Request $request, AuthenticationUtils $authUtils){
        // get the login error if there is one
        $error = $authUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authUtils->getLastUsername();
        
        //$usr= $this->get('security.token_storage')->getToken()->getUser();
        $usr=$this->getUser();
        //$curentUsername=$usr->getUsername();
        
        //dump($request->headers->get('referer'),$error,$lastUsername);

        if(!isset($usr)){
            $respReturn= new Response($this->renderView('login.html.twig',array(
                'last_username' => $lastUsername,
                'error'         => $error
            )));
            $respReturn->headers->set('Cache-Control', 'no-cache, no-store, must-revalidate');
            $respReturn->headers->set('Pragma', 'no-cache');
            $respReturn->headers->set('Expires', '0');            
            return $respReturn;
        }else{
            //return $this->redirectToRoute('index');

            //$referer=$request->headers->set('refresh', '0; url=http://127.0.0.1:8000/');
            //return $this->redirect($referer);
            
            $respReturn = new Response();
            $respReturn->headers->set('refresh', '0; url='.$this->generateUrl('index'));
            return $respReturn;            
        }
        

        //$respReturn->headers->set('referer', 'http://127.0.0.1:8000/');
        
        //dump($respReturn->headers->get('referer'));
        
        //return $respReturn;
        
        /*return $this->render('login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error
        ));*///->headers->set('Cache-Control', 'no-cache, no-store, must-revalidate');
    }
    
    /**
     * @Route("/logout",name="logout")
     */
    public function logout(){
        return $this->render('base.html.twig');      
    }    
    

    /*-*
     -*- @Route("/register", name="user_registration")
     -*/
    /*public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder){

        
        return $this->render('login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));        
    } */   

    
}
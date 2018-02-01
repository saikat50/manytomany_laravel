<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use App\Role;
use App\User;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/create', function (){


   $user = User::find(1);

   $role = new Role(['name'=>'administrator']);

   $user->roles()->save($role);

});


Route::get('/read', function (){

    $user = User::find(1);

    foreach ($user->roles as $role){


        echo $role->name . "<br>";

    }


});




Route::get('/update', function (){


   $user = User::find(1);

   if($user->has('roles')){


       foreach ($user->roles as $role){


           if($role->name=='administrator'){

               $role->name = 'subscriber';
               $role->save();

           }

       }

   }

});



Route::get('/delete', function (){

   $user = User::findOrFail(1);

   $user->roles()->delete();


});



// attach role to user

Route::get('/attach/{id}', function ($id){

   $user = User::find(1);

   $rname = Role::find($id);

    global $hasExistRole;


   foreach ($user->roles as $role){

       if($role->name==$rname->name){

           $hasExistRole = 1;
           return "this role already attached to this user";

       }
       else{

           $hasExistRole = 0;
       }

   }

   if($hasExistRole == 0){
       $user->roles()->attach($id);
       return "done";
   }


});


Route::get('/detach', function (){

    $user = User::find(1);


    foreach ($user->roles as $role){


        $user->roles()->detach(3);

    }





});







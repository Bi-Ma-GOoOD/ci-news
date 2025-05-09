<?php

namespace App\Controllers;

//Add this line to import the class.
use CodeIgniter\Exceptions\PageNotFoundException;

class Pages extends BaseController{
    public function index(){
        return view('welcome_message');
    }

    public function view(string $page = 'home'){
        if(! is_file(APPPATH. 'Views/pages/'. $page . '.php')){
            //Whoops, we dont't have a page for that!
            throw new PageNotFoundException($page);
        }

        $data['title'] = ucfirst($page); // Capitalize the first letter (Upper Case First)

        return view('templates/header', $data) // ส่งตัวแปร $data ไปยัง header.php ซึ่งตอนนี้ $data['title'] จะเก็บค่า title เอาไว้ ทำให้ในหน้า view ใช้ $title ได้เลย ไม่ต้องใช้ $data
            . view('pages/'. $page)
            . view('templates/footer');
    }
}
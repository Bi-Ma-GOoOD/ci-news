<?php

namespace App\Controllers;

use App\Models\NewsModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class News extends BaseController{

    public function index(){
        // gets all news records
        $model = model(NewsModel::class);
        
        $data = [
            // $model -> getNews() หมายถึง instance model เข้าถึงฟังก์ชัน getNews() ที่สร้างไว้ใน NewsModel
            'news_list' => $model -> getNews(),
            'title' => 'News archive',
        ];
        return view('templates/header', $data)
            . view('news/index')
            . view('templates/footer');
    }

    public function show(?string $slug = null){
        // display individual news
        $model = model(NewsModel::class);
        // Model จะใช้งานฟังก์ชัน getNews() ที่สร้างไว้ใน NewsModel โดย getNews() จะรับค่า $slug ที่ส่งมาจาก URL แล้วดึงค่าสำหรับข่าวๆนั้นๆ มาเก็บไว้ใน $data['news']
        /* example $data['news'] = [
            'title' => 'หัวข้อข่าว',
            'slug' => 'my-news',
            'body' => 'เนื้อหาข่าว...'
            ]; */
        $data['news'] = $model->getNews($slug);

        if ($data['news'] == null){
            throw new PageNotFoundException('Cannot find the news item: '. $slug);
        }
        // $data['news']['title'] การเขียนแบบนี้หมายถึงว่าการเข้าถึงค่าที่เก็บอยู่ใน array ของ $data['news'] โดยใช้ key ว่า title
        $data['title'] = $data['news']['title'];

        return view('templates/header', $data)
            . view('news/view')
            . view('templates/footer');
    }

    public function new(){
        helper('form');

        return view('templates/header', ['title' => 'Create a news item'])
            . view('news/create')
            . view('templates/footer');
    }

    public function create(){
        helper('form');

        // รับค่าจาก HTTP POST ที่ส่งมาจากฟอร์ม โดยดึงเฉพาะ title และ body ใส่ลงใน $data ซึ่งจะได้เป็น array
        /* example $data = [
            'title' => 'หัวข้อข่าว',
            'body' => 'เนื้อหาข่าว...'
            ]; */
        $data = $this->request->getPost(['title', 'body']);
            
        // Checks whether the submitted data passed the validation rules.
        if (! $this->validateData($data, [
            'title' => 'required|max_length[255]|min_length[3]',
            'body' => 'required|max_length[5000]|min_length[10]',
        ])) {
            // The validation fails, so returns the form.
            return $this->new();
        }
        // ดึงข้อมูลจากตัว validator ที่ผ่านการตรวจสอบแล้ว (clean & safe)
        // Gets the validated data.
        $post = $this->validator->getValidated();

        $model = model(NewsModel::class);
        
        $model->save([
            'title' => $post['title'],
            // ฟังก์ชัน url_title() จะจัดการเปลี่ยนช่องว่างเป็น - และทำให้เป็น lowercase
            // example: "My news" => "my-news"
            'slug' => url_title($post['title'], '-', true),
            'body' => $post['body'],
        ]);

        return view('templates/header', ['title' => 'Create a news item'])
            . view('news/success')
            . view('templates/footer');
    }
}
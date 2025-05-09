<?php

namespace App\Models;

use CodeIgniter\Model;

class NewsModel extends Model{
    /* บอกว่า model นี้ทำงานกับ ตารางในฐานข้อมูลชื่อ news
    เวลาเรียกใช้ findAll() หรือ save() ก็จะผูกกับตาราง news โดยอัตโนมัติ */
    protected $table = 'news';
    /* เป็น whitelist หรือรายการฟิลด์ที่อนุญาตให้ทำงานกับฐานข้อมูล เช่น insert หรือ update
    เพื่อความปลอดภัย เช่น ป้องกันการที่ user จะส่งฟิลด์แปลกๆ มาแอบแก้ไขข้อมูลสำคัญ เช่น id หรือ admin = true */
    protected $allowedFields = ['title', 'slug', 'body'];
    /**
     * @param false|string $slug
     *
     * @return array|null
     */
    public function getNews($slug = false){
        /* ถ้าเกิดว่า getNews ใส่ slug มาด้วย หมายความว่า เราต้องการจะเข้าถึงข่าวนั้นๆ ซึ่ง slug จะเท่ากับ True แต่ถ้าเป็น false หมายความว่าเอาข่าวทั้งหมด
        ดังนั้นเราเลยเห็นตรงเงื่อนไขว่า ถ้าหาก slug = false ซึ่งหมายความว่าไม่ได้จำเพาะเจาะจงข่าวใดข่าวนึง จึงใช้คำสั่ง findAll เพื่อเอาข่าวทั้งหมดใน DB มานั่นเอง */
        if($slug == false){
            return $this->findAll();
        }
        // ->first() คือดึงแค่ แถวแรกที่ตรงเงื่อนไข มาใช้
        return $this->where(['slug' => $slug]) -> first();
    }
}
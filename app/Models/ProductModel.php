<?php

namespace App\Models; //บอกถึงที่อยู่ของไฟล์นี้
use CodeIgniter\Model; //เรียกใช้ Model

class ProductModel extends Model{
    protected $table = 'products'; //ชื่อตารางที่ต้องการ
    protected $primaryKey = '_id'; //เลือกฟิลด์ที่เป็นคียืหลัก
    protected $allowedFields = ['_id','name','category','price','tags'];//ชื่อฟิลด์ในตาราง
}
?>
<?php

namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\ProductModel;

class Product extends ResourceController{
    use ResponseTrait; 
    
    //get all products
    public function index()
    {
        $model = new ProductModel(); //เรียกใช้งาน Model
        $data['products'] = $model->orderBy('_id', 'DESC')->findAll();
        //ดึงข้อมูลออกมาแสดงจาก _id จากมากไปน้อย และหาข้อมูลทัั้งหมด
        return $this->respond($data); //คืนค่ากลับออกมาเป็นข้อมูล
    }

    //get product bu id
    public function getProduct($id=null){ //ตัวแปร $id ให้เป็นค่าว่าง
        $model = new ProductModel();//เรียกใช้งาน Model
        $data = $model->where('_id',$id)->first();
        //ให้ $data เท่ากับ ข้อมูลที่เรียกออกจาก where _id และเท่ากัย $id และเรียกข้อมูลที่เจออันแรก
        if($data){ //ถ้ามีข้อมูล
            return $this->respond($data); //ให้คืนค่ากลับมา
        }
        else{ //หากไม่มี
            return $this->failNotFound('No Product'); //ให้แสดงว่าไม่มี
        }
    }
    //insert new product
    public function create(){ //เพิ่มข้อมูล
        $model = new ProductModel();//เรียกใช้งาน Model 
        $data=[ //สร้าง array เก็บข้อมูล
            "name"=>$this->request->getVar('name'), 
            "category"=>$this->request->getVar('category'),
            "price"=>$this->request->getVar('price'),
            "tags"=>$this->request->getVar('tags')

        ];
        $model->insert($data); //เพิ่มข้อมูลจาก data ข้างบน
        $response=[ 
            'status'=>201,
            'error'=>null,
            "message"=>[
                'success' => 'Product created success'
            ]
            ];
            return $this->respond($response); //คืนค่า $response
    }
    //update
    public function update($id = null) //อัปเดตข้อมูล
    {
        $model = new ProductModel();//เรียกใช้งาน Model 
        $data = [
            "name" => $this->request->getVar('name'),
            "category" => $this->request->getVar('category'),
            "price" => $this->request->getVar('price'),
            "tags" => $this->request->getVar('tags')

        ];
        // $model->where('_id'),$id)->set($data)->update();
        $model->update($id,$data); //แก้ไขข้อมุลจาก $id และ  $data 
        $response = [
            'status' => 201,
            'error' => null,
            "message" => [
                'success' => 'Product update success'
            ]
        ];
        return $this->respond($response);//คืนค่า $response
    }
    public function delete($id = null){ //ตัวแปร $id ให้เป็นค่าว่าง
        $model = new ProductModel(); //เรียกใช้งาน Model 
        $data = $model->find($id); //หาว่ามีข้อมูลจาก $id ที่เราส่งไปไหม
        if($data){ //หากมีข้อมูล
            $model->delete($id); //ให้ลบข้อมูลจาก id นั้นออกไป
            $response = [ // แล้วแสดงข้อมูลตามนี้
                'status' => 201,
            'error' => null,
            "message" => [
                'success' => 'Product delete success'
            ]
            ];
            return $this->respond($response);
        }
        else { //หากไม่มีให้คืนค่ามาว่า ไม่มีข้อมูล
            return $this->failNotFound('No Product found');
        }
    }
    
}
?>
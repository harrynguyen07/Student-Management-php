<?php
// Khai báo class Student (khuông bánh)
class Student
{
    // thuộc tính (để lưu data)
    public $id;
    public $name;
    public $birthday;
    public $gender;

    // Hàm khởi tạo
    function __construct($id, $name, $birthday, $gender)
    {
        $this->id = $id;
        $this->name = $name;
        $this->birthday = $birthday;
        $this->gender = $gender;
    }
}
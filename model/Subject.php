<?php
// Khai báo class Subject (khuông bánh)
class Subject
{
    // thuộc tính (để lưu data)
    public $id;
    public $name;
    public $number_of_credit;

    // Hàm khởi tạo
    function __construct($id, $name, $number_of_credit)
    {
        $this->id = $id;
        $this->name = $name;
        $this->number_of_credit = $number_of_credit;
    }
}
<?php
class StudentController
{
    function index()
    {
        $studentRepository = new StudentRepository();
        $search = $_GET['search'] ?? null;
        if ($search) {
            $students = $studentRepository->getByPattern($search);
        } else {
            $students = $studentRepository->getAll();
        }
        require 'view/student/index.php';
    }

    function create()
    {
        require 'view/student/create.php';
    }

    function store()
    {
        $data = $_POST;
        $name = $_POST['name'];
        $studentRepository = new StudentRepository();
        if ($studentRepository->save($data)) {
            $_SESSION['success'] = "Đã tạo sinh viên $name thành công";
            header('location:/');
            exit;
        }

        $_SESSION['error'] = $studentRepository->error;
        header('location:/');
    }

    function edit()
    {
        $id = $_GET['id'];
        $studentRepository = new StudentRepository();
        $student = $studentRepository->find($id);
        require 'view/student/edit.php';
    }

    function update()
    {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $birthday = $_POST['birthday'];
        $gender = $_POST['gender'];
        $studentRepository = new StudentRepository();
        // Lấy student từ database
        $student = $studentRepository->find($id);
        // Cập nhật data mới cho object student
        $student->name = $name;
        $student->birthday = $birthday;
        $student->gender = $gender;
        //Lưu object đã cập nhật xuống database
        if ($studentRepository->update($student)) {
            $_SESSION['success'] = "Đã cập nhật sinh viên $name thành công";
            header('location:/');
            exit;
        }

        $_SESSION['error'] = $studentRepository->error;
        header('location:/');
    }

    function destroy()
    {
        $id = $_GET['id'];
        $studentRepository = new StudentRepository();
        $student = $studentRepository->find($id);
        $name = $student->name;
        if ($studentRepository->destroy($id)) {
            $_SESSION['success'] = "Đã xóa sinh viên $name thành công";
            header('location:/');
            exit;
        }

        $_SESSION['error'] = $studentRepository->error;
        header('location:/');
    }
}
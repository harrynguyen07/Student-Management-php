<?php
class RegisterController
{
    function index()
    {
        $registerRepository = new RegisterRepository();
        $search = $_GET['search'] ?? null;
        if ($search) {
            $registers = $registerRepository->getByPattern($search);
        } else {
            $registers = $registerRepository->getAll();
        }
        require 'view/register/index.php';
    }

    function create()
    {
        $studentRepository = new StudentRepository();
        $students = $studentRepository->getAll();

        $subjectRepository = new SubjectRepository();
        $subjects = $subjectRepository->getAll();

        require 'view/register/create.php';
    }

    function store()
    {
        $data = $_POST;
        $registerRepository = new RegisterRepository();

        $studentRepository = new StudentRepository();
        $student = $studentRepository->find($_POST['student_id']);
        $student_name = $student->name;

        $subjectRepository = new SubjectRepository();
        $subject = $subjectRepository->find($_POST['subject_id']);
        $subject_name = $subject->name;

        if ($registerRepository->save($data)) {
            $_SESSION['success'] = "Sinh viên $student_name đăng ký môn học $subject_name thành công";
            header('location:?c=register');
            exit;
        }

        $_SESSION['error'] = $registerRepository->error;
        header('location:?c=register');
    }

    function edit()
    {
        $id = $_GET['id'];
        $registerRepository = new RegisterRepository();
        $register = $registerRepository->find($id);
        require 'view/register/edit.php';
    }

    function update()
    {
        $id = $_POST['id'];
        $score = $_POST['score'];
        $registerRepository = new RegisterRepository();
        // Lấy register từ database
        $register = $registerRepository->find($id);
        // Cập nhật data mới cho object register
        $register->score = $score;
        //Lưu object đã cập nhật xuống database
        if ($registerRepository->update($register)) {
            $_SESSION['success'] = "Đã cập nhật đăng ký môn học thành công";
            header('location:?c=register');
            exit;
        }

        $_SESSION['error'] = $registerRepository->error;
        header('location:?c=register');
    }

    function destroy()
    {
        $id = $_GET['id'];
        $registerRepository = new RegisterRepository();
        $register = $registerRepository->find($id);
        $student_id = $register->student_id;
        if ($registerRepository->destroy($id)) {
            $_SESSION['success'] = "Đã xóa đăng ký môn học $student_id thành công";
            header('location:?c=register');
            exit;
        }

        $_SESSION['error'] = $registerRepository->error;
        header('location:?c=register');
    }
}
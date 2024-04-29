<?php
class SubjectController
{
    function index()
    {
        $subjectRepository = new SubjectRepository();
        $search = $_GET['search'] ?? null;
        if ($search) {
            $subjects = $subjectRepository->getByPattern($search);
        } else {
            $subjects = $subjectRepository->getAll();
        }
        require 'view/subject/index.php';
    }

    function create()
    {
        require 'view/subject/create.php';
    }

    function store()
    {
        $data = $_POST;
        $name = $_POST['name'];
        $subjectRepository = new SubjectRepository();
        if ($subjectRepository->save($data)) {
            $_SESSION['success'] = "Đã tạo môn học $name thành công";
            header('location:?c=subject');
            exit;
        }

        $_SESSION['error'] = $subjectRepository->error;
        header('location:?c=subject');
    }

    function edit()
    {
        $id = $_GET['id'];
        $subjectRepository = new SubjectRepository();
        $subject = $subjectRepository->find($id);
        require 'view/subject/edit.php';
    }

    function update()
    {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $number_of_credit = $_POST['number_of_credit'];
        $subjectRepository = new SubjectRepository();
        // Lấy subject từ database
        $subject = $subjectRepository->find($id);
        // Cập nhật data mới cho object subject
        $subject->name = $name;
        $subject->number_of_credit = $number_of_credit;
        //Lưu object đã cập nhật xuống database
        if ($subjectRepository->update($subject)) {
            $_SESSION['success'] = "Đã cập nhật môn học $name thành công";
            header('location:?c=subject');
            exit;
        }

        $_SESSION['error'] = $subjectRepository->error;
        header('location:?c=subject');
    }

    function destroy()
    {
        $id = $_GET['id'];
        $subjectRepository = new SubjectRepository();
        $subject = $subjectRepository->find($id);
        $name = $subject->name;
        if ($subjectRepository->destroy($id)) {
            $_SESSION['success'] = "Đã xóa môn học $name thành công";
            header('location:?c=subject');
            exit;
        }

        $_SESSION['error'] = $subjectRepository->error;
        header('location:?c=subject');
    }
}
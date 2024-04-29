<?php
class RegisterRepository
{
    public $error;
    // Lấy các dòng dữ liệu và chuyển thành danh sách các object register
    protected function fetch($cond = null)
    {
        // Trong hàm không nhìn thấy biến ngoài hàm. Để nhìn thấy phải global
        global $conn;
        $sql = "SELECT register.*, student.name AS student_name, subject.name AS subject_name FROM register
            JOIN student ON register.student_id = student.id
            JOIN subject ON register.subject_id = subject.id
        ";
        if ($cond) {
            $sql .= " WHERE $cond";
            //SELECT * FROM register WHERE student_id like '%suu%';
        }
        $registers = [];
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $id = $row['id'];
                $student_id = $row['student_id'];
                $subject_id = $row['subject_id'];
                $score = $row['score'];
                $student_name = $row['student_name'];
                $subject_name = $row['subject_name'];
                $register = new Register($id, $student_id, $subject_id, $score, $student_name, $subject_name);
                // [] bên trái là thêm 1 phần tử vào cuối danh sách
                $registers[] = $register;
            }
        }
        return $registers;
    }

    function getByPattern($search)
    {
        $cond = "student.name LIKE '%$search%' OR subject.name LIKE '%$search%'";
        $registers = $this->fetch($cond);
        return $registers;
    }

    function getAll()
    {
        $registers = $this->fetch();
        return $registers;
    }

    function save($data)
    {
        global $conn;
        $student_id = $data['student_id'];
        $subject_id = $data['subject_id'];
        $sql = "INSERT INTO register(student_id, subject_id) VALUES('$student_id', '$subject_id')";

        if ($conn->query($sql)) {
            return true;
        }
        $this->error = $sql . '<br>' . $conn->error;
        return false;
    }

    function find($id)
    {
        $cond = "register.id=$id";
        $registers = $this->fetch($cond);
        $register = current($registers);
        return $register;
    }

    function update($register)
    {
        global $conn;
        $score = $register->score;
        $id = $register->id;

        $sql = "UPDATE register SET score='$score'  WHERE id=$id";
        if ($conn->query($sql)) {
            return true;
        }
        $this->error = $sql . '<br>' . $conn->error;
        return false;
    }

    function destroy($id)
    {
        global $conn;
        $sql = "DELETE FROM register WHERE id=$id";
        if ($conn->query($sql)) {
            return true;
        }
        $this->error = $sql . '<br>' . $conn->error;
        return false;
    }
}
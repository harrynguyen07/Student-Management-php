<?php
class StudentRepository
{
    public $error;
    // Lấy các dòng dữ liệu và chuyển thành danh sách các object student
    protected function fetch($cond = null)
    {
        // Trong hàm không nhìn thấy biến ngoài hàm. Để nhìn thấy phải global
        global $conn;
        $sql = "SELECT * FROM student";
        if ($cond) {
            $sql .= " WHERE $cond";
            //SELECT * FROM student WHERE name like '%suu%';
        }
        $students = [];
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $id = $row['id'];
                $name = $row['name'];
                $birthday = $row['birthday'];
                $gender = $row['gender'];
                $student = new Student($id, $name, $birthday, $gender);
                // [] bên trái là thêm 1 phần tử vào cuối danh sách
                $students[] = $student;
            }
        }
        return $students;
    }

    function getByPattern($search)
    {
        $cond = "name LIKE '%$search%'";
        $students = $this->fetch($cond);
        return $students;
    }

    function getAll()
    {
        $students = $this->fetch();
        return $students;
    }

    function save($data)
    {
        global $conn;
        $name = $data['name'];
        $birthday = $data['birthday'];
        $gender = $data['gender'];
        $sql = "INSERT INTO student(name, birthday, gender) VALUES('$name', '$birthday', '$gender')";

        if ($conn->query($sql)) {
            return true;
        }
        $this->error = $sql . '<br>' . $conn->error;
        return false;
    }

    function find($id)
    {
        $cond = "id=$id";
        $students = $this->fetch($cond);
        $student = current($students);
        return $student;
    }

    function update($student)
    {
        global $conn;
        $name = $student->name;
        $birthday = $student->birthday;
        $gender = $student->gender;
        $id = $student->id;

        $sql = "UPDATE student SET name='$name', gender='$gender', birthday='$birthday' WHERE id=$id";
        if ($conn->query($sql)) {
            return true;
        }
        $this->error = $sql . '<br>' . $conn->error;
        return false;
    }

    function destroy($id)
    {
        global $conn;
        $sql = "DELETE FROM student WHERE id=$id";
        if ($conn->query($sql)) {
            return true;
        }
        $this->error = $sql . '<br>' . $conn->error;
        return false;
    }
}
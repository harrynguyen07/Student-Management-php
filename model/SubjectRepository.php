<?php
class SubjectRepository
{
    public $error;
    // Lấy các dòng dữ liệu và chuyển thành danh sách các object subject
    protected function fetch($cond = null)
    {
        // Trong hàm không nhìn thấy biến ngoài hàm. Để nhìn thấy phải global
        global $conn;
        $sql = "SELECT * FROM subject";
        if ($cond) {
            $sql .= " WHERE $cond";
            //SELECT * FROM subject WHERE name like '%suu%';
        }
        $subjects = [];
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $id = $row['id'];
                $name = $row['name'];
                $number_of_credit = $row['number_of_credit'];
                $subject = new Subject($id, $name, $number_of_credit);
                // [] bên trái là thêm 1 phần tử vào cuối danh sách
                $subjects[] = $subject;
            }
        }
        return $subjects;
    }

    function getByPattern($search)
    {
        $cond = "name LIKE '%$search%'";
        $subjects = $this->fetch($cond);
        return $subjects;
    }

    function getAll()
    {
        $subjects = $this->fetch();
        return $subjects;
    }

    function save($data)
    {
        global $conn;
        $name = $data['name'];
        $number_of_credit = $data['number_of_credit'];
        $sql = "INSERT INTO subject(name, number_of_credit) VALUES('$name', '$number_of_credit')";

        if ($conn->query($sql)) {
            return true;
        }
        $this->error = $sql . '<br>' . $conn->error;
        return false;
    }

    function find($id)
    {
        $cond = "id=$id";
        $subjects = $this->fetch($cond);
        $subject = current($subjects);
        return $subject;
    }

    function update($subject)
    {
        global $conn;
        $name = $subject->name;
        $number_of_credit = $subject->number_of_credit;
        $id = $subject->id;

        $sql = "UPDATE subject SET name='$name', number_of_credit='$number_of_credit' WHERE id=$id";
        if ($conn->query($sql)) {
            return true;
        }
        $this->error = $sql . '<br>' . $conn->error;
        return false;
    }

    function destroy($id)
    {
        global $conn;
        $sql = "DELETE FROM subject WHERE id=$id";
        if ($conn->query($sql)) {
            return true;
        }
        $this->error = $sql . '<br>' . $conn->error;
        return false;
    }
}
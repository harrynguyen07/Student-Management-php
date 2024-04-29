<?php require 'layout/header.php' ?>
<h1>Danh sách sinh viên</h1>
<a href="?a=create" class="btn btn-info">Add</a>
<?php require 'layout/search.php' ?>
<table class="table table-hover">
    <thead>
        <tr>
            <th>#</th>
            <th>Mã SV</th>
            <th>Tên</th>
            <th>Ngày Sinh</th>
            <th>Giới Tính</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $order = 0;
        foreach ($students as $student) :
            $order++;
        ?>
        <tr>
            <td><?= $order ?></td>
            <td><?= $student->id ?></td>
            <td><?= $student->name ?></td>
            <td><?= $student->birthday ?></td>
            <td><?= $student->gender ?></td>
            <td><a href="?a=edit&id=<?= $student->id ?>" class="btn btn-warning btn-sm">Sửa</a></td>
            <td>
                <button data-href="?a=destroy&id=<?= $student->id ?>" type="button"
                    class="destroy btn btn-danger btn-sm" data-toggle="modal" data-target="#exampleModal">
                    Xóa
                </button>
            </td>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>
<div>
    <span>Số lượng: <?= count($students) ?></span>
</div>
<?php require 'layout/footer.php' ?>
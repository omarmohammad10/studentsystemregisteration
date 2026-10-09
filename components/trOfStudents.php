<?php

require_once __DIR__ . "/../back/getStudents.php";

$page = 1;

if(isset($_GET['page']) && $_GET['page'] > 1){
  $page = $_GET['page'];
}

$students = getStudents("" , $page);

$bodyContentHTML = "";

foreach ($students as $student) {
  $shortPass = substr($student['password'], 0, 15);

  $bodyContentHTML .= "
   <tr data-student-id='{$student['id']}'>
            <th>{$student['id']}</th>
            <td>{$student['first_name']} {$student['last_name']}</td>
            <td>{$student['email']}</td>
            <td>{$shortPass}...</td>
            <td>{$student['age']}</td>
            <td>{$student['phone']}</td>
            <td>
              <div class='buttons'>
                <a href='editStudentForm.php?student_id={$student['id']}' class='btn btn-info text-light'>Edit</a>
                <button class='btn btn-danger' onclick='deleteStudent({$student['id']})'>Delete</button>
              </div>
            </td>
  </tr>
  ";
}

echo $bodyContentHTML;

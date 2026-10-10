let oldSearch = $("#SearchInput").val();
console.log("Old: " + oldSearch);

$("#SearchForm").submit(function (e) {
  e.preventDefault();
  let newSearch = $("#SearchInput").val();
  console.log("New : " + newSearch);
  if (newSearch == oldSearch) {
    return;
  }
  oldSearch = newSearch;
  searchStudents(newSearch, 1);
})


function searchStudents(search, page) {
  $.ajax({
    url: "back/search.php",
    type: "POST",
    data: {
      search: search,
      page: page
    },
    success: function (data) {
      console.log("Students:", data.students);
      console.log("Total:", data.total);
      console.log("Page:", data.page);
      showStudents(data.students);
      showPagination(data.total, data.page);
    },
    error: function (error) {
      Swal.fire({
        icon: "error",
        title: "Oops...",
        text: error['responseJSON']['message']
      });
    }
  })
}

function showStudents(students) {
  let tbodyContent = "";

  if (students.length == 0) {
    // $("tbody").html("");
    Swal.fire({
      title: "Oops!",
      text: "No students here",
      icon: "error"
    });
    $("#SearchInput").val("");
    oldSearch = "";
    searchStudents("", 1);
  }

  for (let i = 0; i < students.length; i++) {

    let shortPass = students[i]['password'].slice(0, 15);
    tbodyContent += `
    <tr data-student-id="${students[i]['id']}">
            <th>${students[i]['id']}</th>
            <td>${students[i]['first_name']} ${students[i]['last_name']}</td>
            <td>${students[i]['email']}</td>
            <td>${shortPass}...</td>
            <td>${students[i]['age']}</td>
            <td>${students[i]['phone']}</td>
            <td>
              <div class='buttons'>
                <a class='btn btn-info text-light' href='editStudentForm.php?student_id=${students[i]['id']}'>Edit</a>
                <button class='btn btn-danger' onclick='deleteStudent(${students[i]['id']})'>Delete</button>
              </div>
            </td>
    </tr>
    `
  }

  $("tbody").html(tbodyContent);
}


function showPagination(total, currentPage = 1) {

  total = Number(total);
  currentPage = Number(currentPage);
  let pagesNumber = Math.ceil(total / 10);

  let liHTML = "";

  if (pagesNumber <= 1) {
    $("ul.pagination").html("");
    return;
  }
  // Empty Pagination

  let isDisabled;
  let prevPage;
  let nextPage;

  for (let i = 0; i <= pagesNumber + 1; i++) {

    if (i == 0) {

      isDisabled = (currentPage == 1) ? 'disabled' : "";
      prevPage = (currentPage == 1) ? 1 : currentPage - 1;

      liHTML += `
        <li class='page-item'>
          <a class='page-link ${isDisabled}' href='#' data-page='${prevPage}'>
            Previous
          </a>
        </li>
      `;

    } else if (i == pagesNumber + 1) {

      isDisabled = (currentPage == pagesNumber) ? 'disabled' : "";
      nextPage = (currentPage == pagesNumber) ? pagesNumber : currentPage + 1;

      liHTML += `
        <li class='page-item'>
          <a class='page-link ${isDisabled}' href='#' data-page='${nextPage}'>
            Next
          </a>
        </li>
      `;

    } else {

      let isActive = (i == currentPage) ? 'active' : "";
      liHTML += `
        <li class='page-item'>
          <a class='page-link ${isActive}' href='#' data-page='${i}'>
            ${i}
          </a>
        </li>
      `;
    }
  }

  $("ul.pagination").html(liHTML);

}

$(document).on("click", "ul.pagination .page-link", function (e) {
  e.preventDefault();
  if ($(this).hasClass("disabled") || $(this).hasClass("active")) {
    return;
  }
  let page = Number($(this).data('page'));
  let search = $("#SearchInput").val();
  searchStudents(search, page);
  console.log(page);
});


function deleteStudent(student_id) {
  Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, delete it!"
  }).then((result) => {
    if (result.isConfirmed) {
      let dataForm = {
        "student_id": student_id
      };
      $.ajax({
        url: "back/deleteStudent.php",
        type: "POST",
        data: dataForm,
        success: function (data) {
          $(`tr[data-student-id="${student_id}"]`).remove();
          Swal.fire({
            title: "Deleted!",
            text: "Student has been deleted.",
            icon: "success"
          });
        },
        error: function (error) {
          Swal.fire({
            icon: "error",
            title: "Oops...",
            text: error['responseJSON']['message']
          });
        }
      });
    }
  });
}
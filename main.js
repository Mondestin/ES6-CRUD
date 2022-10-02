const addForm = document.getElementById("add-user-form");
const updateForm = document.getElementById("edit-user-form");
const showAlert = document.getElementById("showAlert");
const addModal = new bootstrap.Modal(document.getElementById("addNewUserModal"));
const editModal = new bootstrap.Modal(document.getElementById("editUserModal"));
const tbody = document.querySelector("tbody");

// Add New user using ajax request
addForm.addEventListener("submit", async (e) => {
  e.preventDefault();

  const formData = new FormData(addForm);
  formData.append("add", 1);

  if (addForm.checkValidity() === false) {
    e.preventDefault();
    e.stopPropagation();
    addForm.classList.add("was-validated");
    return false;
  } else {

    const data = await fetch("route.php", {
      method: "POST",
      body: formData,
    });
    const response = await data.text();
    showAlert.innerHTML = response;
    document.getElementById("add-user-btn").value = "Add User";
    addForm.reset();
    addForm.classList.remove("was-validated");
    addModal.hide();
    fetchAllUsers();
  }
});

// Get all users using ajax request
const fetchAllUsers = async () => {
  const data = await fetch("route.php?index=1", {
    method: "GET",
  });
  const response = await data.text();
  tbody.innerHTML = response;
};


// this fonction always get called when on load
fetchAllUsers();

// Edit user using ajax request
tbody.addEventListener("click", (e) => {
  if (e.target && e.target.matches("a.editLink")) {
    e.preventDefault();
    let id = e.target.getAttribute("id");
    editUser(id);
  }
});

// Populate data of the user on the edit form after getting the response
const editUser = async (id) => {
  const data = await fetch(`route.php?edit=1&id=${id}`, {
    method: "GET",
  });
  const response = await data.json();
  document.getElementById("id").value = response.id;
  document.getElementById("fname").value = response.first_name;
  document.getElementById("lname").value = response.last_name;
  document.getElementById("email").value = response.email;
  document.getElementById("phone").value = response.phone;
};

// Update user using ajax request
updateForm.addEventListener("submit", async (e) => {
  e.preventDefault();

  const formData = new FormData(updateForm);
  formData.append("update", 1);

  if (updateForm.checkValidity() === false) {
    e.preventDefault();
    e.stopPropagation();
    updateForm.classList.add("was-validated");
    return false;
  } else {
    document.getElementById("edit-user-btn").value = "Please Wait...";

    const data = await fetch("route.php", {
      method: "POST",
      body: formData,
    });
    const response = await data.text();

    showAlert.innerHTML = response;
    document.getElementById("edit-user-btn").value = "Add User";
    updateForm.reset();
    updateForm.classList.remove("was-validated");
    editModal.hide();
    fetchAllUsers();
  }
});

// Delete user button event handler
tbody.addEventListener("click", (e) => {
  if (e.target && e.target.matches("a.deleteLink")) {
    e.preventDefault();
     var name=e.target.getAttribute("name");
     Swal.fire({
        title: 'Are you sure you want to delete ' + name + '?',
        text: "You won't be able to revert this.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it.'
      }).then((result) => {
        if (result.isConfirmed) {
        let id = e.target.getAttribute("id");
        deleteUser(id);
          Swal.fire(
            'Deleted!',
            'Your file has been deleted.',
            'success'
          )
        }
      })
  }
});

// Delete user using ajax request
const deleteUser = async (id) => {
  const data = await fetch(`route.php?delete=1&id=${id}`, {
    method: "GET",
  });
  const response = await data.text();
  showAlert.innerHTML = response;
  fetchAllUsers();
};
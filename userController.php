<?php
namespace CRUD;
use CRUD\User;


class UserController
{
   // get all the users from the database
   public function index(){
    $user=new User();
    $users = $user->all();
    $output = '';
    $no=1;
    if ($users) {
      foreach ($users as $user) {
        $output .= '<tr>
                      <td>' . $no++ . '</td>
                      <td>' . $user['first_name'] . '</td>
                      <td>' . $user['last_name'] . '</td>
                      <td>' . $user['email'] . '</td>
                      <td>' . $user['phone'] . '</td>
                      <td>
                        <a href="#" id="' . $user['id'] . '" class="btn btn-success btn-sm py-0 editLink" data-toggle="modal" data-target="#editUserModal">Edit</a>

                        <a href="#" id="' . $user['id'] . '" name="' . $user['first_name'] . '" class="btn btn-danger btn-sm py-0 deleteLink">Delete</a>
                      </td>
                    </tr>';
      }
      return $output;
    } else {
      return '<tr>
              <td colspan="6">No users found in the database</td>
            </tr>';
    }
   }

  // Save new user into the database
  public function store()
  {
    $util = new Utilities();
    $user=new User();

    $user->setFname($util->cleanInput($_POST['fname']));
    $user->setLname($util->cleanInput($_POST['lname']));
    $user->setEmail($util->cleanInput($_POST['email']));
    $user->setPhone($util->cleanInput($_POST['phone']));
    $user->save();

     if ($user) {
        return $util->showMessage('success', 'User inserted successfully!');
      } else {
        return $util->showMessage('danger', 'Something went wrong!');
      }
  }

  //   show a user's data 
  public function show($id)
  {
    $user=new User();
    $user = $user->get($id);
    return json_encode($user);
  }

//   update a user's data'
  public function update($id)
  {
    $util = new Utilities();
    $user=new User();
    $user->setFname($util->cleanInput($_POST['fname']));
    $user->setLname($util->cleanInput($_POST['lname']));
    $user->setEmail($util->cleanInput($_POST['email']));
    $user->setPhone($util->cleanInput($_POST['phone']));

    if ($user->update($id)) {
        return $util->showMessage('success', 'User updated successfully!');
    } else {
        return $util->showMessage('danger', 'Something went wrong!');
    }
  }

  public function delete($id)
  {
    $util = new Utilities();
    $user=new User();
    try {
        $user->destroy($id);
        return true;
    } catch (\Throwable $th) {
        return $util->showMessage('danger', $th);
    }
   
  }
} 

?>
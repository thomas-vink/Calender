<?php

            //open database conectie dingens
 function getAllBirthdays() 
{
    $db = openDatabaseConnection();

    $sql = "SELECT * FROM birthdays order by month,day";
    $query = $db->prepare($sql);
    $query->execute();

    $db = null;

    return $query->fetchAll();
}

        // add birthday dinges
function createBirthday(){
    $person = isset($_POST['person']) ? $_POST['person'] : null;
    $day = isset($_POST['day']) ? $_POST['day'] : null;
    $month = isset($_POST['month']) ? $_POST['month'] : null;
    $year = isset($_POST['year']) ? $_POST['year'] : null;

    if (strlen($person) == 0 || strlen($day) == 0 || strlen($month) == 0 || strlen($year) == 0){
        echo "Niet ingevuld";
        return false;
    }

    $db = openDatabaseConnection();

    $sql = "INSERT INTO birthdays(person, day, month, year) VALUES (:person, :day, :month, :year)";
    $query = $db->prepare($sql);
    $query->execute(array(
        ':person' => $person,
        ':day' => $day,
        ':month' => $month,
        ':year' => $year));

    $db = null;

    return true;
}
            //dingens verwijderen
    function deleteBirthday($id = null) 
{
    if (!$id) {
        return false;
    }
    
    $db = openDatabaseConnection();

    $sql = "DELETE FROM birthdays WHERE id=:id ";
    $query = $db->prepare($sql);
    $query->execute(array(
        ':id' => $id));

    $db = null;
    
    return true;
}
        // het aanpassen van de birday
    function editBirthday() 
{
    //var_export($_POST);
    //die();

    $person = isset($_POST['person']) ? $_POST['person'] : null;
    $month = isset($_POST['month']) ? $_POST['month'] : null;
    $year = isset($_POST['year']) ? $_POST['year'] : null;
    $day = isset($_POST['day']) ? $_POST['day'] : null;
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    
    if (strlen($person) == 0 || strlen($month) == 0 || strlen($day) == 0 || strlen($year) == 0 || strlen($id) == 0 ){
        echo "Niet ingevuld";
        return false;
    }
    
    $db = openDatabaseConnection();

    $sql = "UPDATE birthdays SET person = :person, month = :month, day = :day, year = :year WHERE id = :id";
    $query = $db->prepare($sql);
    $query->execute(array(
        ':person' => $person,
        ':month' => $month,
        ':year' => $year,
        ':day' => $day,
        ':id' => $id));

    // check if something went wrong (errorcode 00000 means: no errors)
    $arr = $query->errorInfo();
    if ($arr[0] != '00000') {
        $_SESSION['errors'] = $arr[2];
        return false;
    }

    $db = null;
    
    return true;
}

function getBirthday($id) 
{
    $db = openDatabaseConnection();

    $sql = "SELECT * FROM birthdays WHERE id = :id";
    $query = $db->prepare($sql);
    $query->execute(array(
        ":id" => $id));

    $db = null;

    return $query->fetch();
}



?>
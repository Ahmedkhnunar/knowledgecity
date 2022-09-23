<?php

session_start();

require_once 'dbClass.php';
require_once 'config.php';

try {

    $objDatabase = new dbClass(cDatabaseHost, cDatabaseUser, cDatabasePassword, cDatabase);   

    $requestMethod = $_SERVER['REQUEST_METHOD'];

    switch ($requestMethod) {
         case 'POST':
             $response = UserLogin();
             break;
         case 'GET':
             $response = GetStudents();
             break;
         case 'DELETE':
             $response = UnSetAuth();
             break;
         default:
             $response = json_encode(["code" => 300, "message" => "Sorry, Invalid method."]);
             break;
     }

    print_r($response); 
} catch (Exception $e) {
    die( json_encode(["code" => 300, "message" => "Sorry, something went wrong - please be patient, we are working on it..."]) );
}

function GetStudents()
{
    global $objDatabase;

    try {
        
        if(AuthVerifiction()){

            $pageno = ( isset($_GET['pageno']) && is_numeric($_GET['pageno']) && $_GET['pageno'] > 0) ? $_GET['pageno']: 1;

            $no_of_records_per_page = cRecordsPerPage;
            $offset = ($pageno-1) * $no_of_records_per_page;

            $result = $objDatabase->Query("SELECT 
                                              COUNT(DISTINCT S.StudentId) AS TotalCount 
                                            FROM
                                              students AS S 
                                              INNER JOIN student_groups AS G");

            $total_rows = $objDatabase->Result($result, 0, "TotalCount");
            $total_pages = ceil($total_rows / $no_of_records_per_page);
            
            $varResult = $objDatabase->Query("SELECT 
                                  S.FirstName,
                                  S.LastName,
                                  S.Code,
                                  G.GroupName 
                                FROM
                                  students AS S 
                                  INNER JOIN student_groups AS G 
                                    ON G.GroupId = S.GroupId 
                                    LIMIT $offset, $no_of_records_per_page");

            $records = [];
            if ($varResult) {
                while($row = $objDatabase->FetchArray($varResult)){
                    $records[] = $row;
                }
            }

            $return = ["code" => 200, "message" => "Success", "data" => $records, "pagecount" => $total_pages];
        }
        else{
            $return = ["code" => 400, "message" =>"Login first please." ];
        }
        return json_encode($return);
    } catch (Exception $e) {
        return $objDatabase->ShowGeneralError();
    }
}

function UserLogin()
{
    global $objDatabase;
    
    try {
        
        $username = $objDatabase->RealEscapeString($_REQUEST["username"]);
        $password = $objDatabase->RealEscapeString($_REQUEST["password"]);
        $remember = $objDatabase->RealEscapeString($_REQUEST["remember"]);

        $remember = ($remember === 'true') ? 1 : 0;

        if ($username && $password) {
            
            $password = md5($password);
            
            $result = $objDatabase->Query(" SELECT U.UserName, U.UserId 
                                            FROM users AS U 
                                            WHERE U.UserName = '$username' AND U.Password = '$password' ");
            
            if( $objDatabase->RowsNumber($result) > 0)
            {
                $username = $objDatabase->Result($result, 0, 'UserName');
                // var_dump($remember);
                if($remember)
                {
                    SetUserSession(true);
                }
                else
                {
                    SetUserSession(false);                    
                }

                return json_encode(["code" => 200, "message" => "Login successfully."]);
            }
            else
            {
                return json_encode(["code" => 300, "message" => "Invalid username or password."]);   
            }
        }
        else{
            return json_encode(["code" => 300, "message" => "username & password are required fields."]);
        }

    } catch (Exception $e) {
        return $objDatabase->ShowGeneralError();
    }
}

function AuthVerifiction()
{
    $isLoginedUser = false;

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if ( array_key_exists(cSessionName, $_SESSION) && $_SESSION[cSessionName] != '') {
        $isLoginedUser = true;
        SetUserSession(false);
    }
    else if( array_key_exists(cCookieName, $_COOKIE) && $_COOKIE[cCookieName] != '' )
    {
        $isLoginedUser = true;
        SetUserSession(true);
    }
    
    return $isLoginedUser;    
}

function SetUserSession($isSession = true )
{
    if($isSession == true)
    {
        setcookie(cCookieName, md5('user-secret'), time() + cSessionTime, "/");
    }
    else
    {
        $_SESSION[cSessionName] = md5('user-secret');
    }
}

function UnSetAuth()
{
    session_unset();
    session_destroy();
    session_write_close();
    setcookie(session_name(), '', 0, '/');
    session_regenerate_id(true);
    setcookie(cCookieName, md5('user-secret'), time() - 1000, "/");
    return json_encode(["code" => 200, "message" => "Logout Successfully."]);
}


?>
<?php
require_once PROJECT_ROOT_PATH . "/Model/Database.php";

class AccountModel extends Database
{
    public function GetByLoginIDAndType($loginID, $uType){
        return $this->selectone("SELECT C.* FROM " . USERS_TABLE . " C WHERE C.LoginID='$loginID' AND C.UserTypeId='$uType' AND C.IsActive=1");
    }
    public function Save($fullName, $email, $phoneNumber, $password, $gender, $userTypeId, $DepartmentId,$companyName){
        return $this->insert("INSERT INTO " . USERS_TABLE . " ( `FullName`, `Email`, `ContactNo`, `LoginID`, `Password`, `UserTypeId`, `DepartmentId`, `IsActive`, `CreatedAt`, `OrganizationId`, `Gender`) VALUES ('" . addSlashes($fullName) . "','$email','$phoneNumber','$phoneNumber','$password','$userTypeId','$DepartmentId','1', CURRENT_TIMESTAMP,'$companyName', '$gender')");
    }
    public function editEmployee($Id, $fullName, $email, $phoneNumber, $password, $gender, $UserTypeId, $DepartmentId,$companyName){
        return $this->insert("UPDATE " . USERS_TABLE . "  SET FullName='" . addSlashes($fullName) . "', Email='$email', ContactNo ='$phoneNumber', Password='$password',UserTypeId ='$UserTypeId', DepartmentId='$DepartmentId', OrganizationId='$companyName',Gender='$gender' WHERE Id='$Id'");
    }
    public function Get($phoneNumber){
        return $this->selectone("SELECT U.* FROM " . USERS_TABLE . " U WHERE U.LoginID='$phoneNumber' AND U.IsActive=1");
    }
    public function GetByLoginID($UserId){
        return $this->selectone("SELECT C.* FROM " . USERS_TABLE . " C WHERE C.Id='$UserId'");
    }
    public function ChangePassword($Id, $newPass){
        return $this->insert("UPDATE " . USERS_TABLE . " set Password='$newPass' where Id='$Id'");
    } 
    public function createUserToken($userId,$token){
        return $this->insert("UPDATE ".USERS_TABLE." SET Token = '$token' WHERE id ='$userId'");
    }   
    public function GetEmployeeByCompanyId($companyId){
        return $this->select("SELECT * FROM " . USERS_TABLE . " WHERE OrganizationId = '$companyId'");
    }
    public function GetEmployeeById($UserId){
        return $this->select("SELECT E.*,D.DepartmentName from " . USERS_TABLE . " E LEFT JOIN " . DEPARTMENT_TABLE . " D ON E.DepartmentId=D.Id where E.Id='$UserId'");
    }
    public function deleteEmployee($id){
        $this->delete("DELETE FROM ".USERS_TABLE." WHERE Id='$id'");
        return true;
    }
}
?>
<?php
require_once PROJECT_ROOT_PATH . "/Model/Database.php";

class DepartmentModel extends Database
{
    public function GetDepartmentByCompanyId($companyId){
        return $this->select("SELECT C.* FROM " . DEPARTMENT_TABLE . " C WHERE C.CompanyId='$companyId' order by display_order");
    }
    public function GetDepartmentById($DepartmentId){
        return $this->selectone("SELECT C.* FROM " . DEPARTMENT_TABLE . " C WHERE C.Id='$DepartmentId'");
    }
    public function EditDepartment($Id,$pid, $DepartmentName){
        return $this->insert("UPDATE " . DEPARTMENT_TABLE . "  SET pid = $pid, DepartmentName='" . addSlashes($DepartmentName) . "' WHERE Id='$Id'");
    }
    public function AddDepartment($pid,$companyId, $DepartmentName){
        return $this->insert("INSERT INTO " . DEPARTMENT_TABLE . " (`pid`,`CompanyId`,`DepartmentName`) VALUES('$pid','$companyId','$DepartmentName')");
    }
    public function deleteDepartment($id){
        return $this->delete("DELETE FROM ".DEPARTMENT_TABLE." WHERE id='$id'");
    }
    public function updateOrder($orderIds){
        return $this->insert("UPDATE ".DEPARTMENT_TABLE." SET display_order = FIND_IN_SET(id, '$orderIds')  WHERE id in ($orderIds)");
    }
}
?>

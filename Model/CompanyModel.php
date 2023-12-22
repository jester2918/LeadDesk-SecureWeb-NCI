<?php
require_once PROJECT_ROOT_PATH . "/Model/Database.php";

class CompanyModel extends Database
{
    public function AddCompany($PortalUserId, $CompanyName, $Address, $PhoneNumber){
        $data = $this->selectone("SELECT * FROM " . COMPANY_TABLE . "  C WHERE C.CompanyName='$CompanyName' AND PortalUserId='$PortalUserId'");
        if (!isset($data['Id'])) {
            $this->insert("INSERT INTO " . COMPANY_TABLE . " (`PortalUserId`,`CompanyName`,`Address`,`PhoneNumber`,`CreatedDate`) VALUES('$PortalUserId','$CompanyName','$Address','$PhoneNumber',CURRENT_TIMESTAMP)");
            return $this->selectone("SELECT LAST_INSERT_ID() AS id", [])["id"];
        }
        return false;
    }
    public function EditCompany($Id, $CompanyName, $Address, $PhoneNumber){
        return $this->insert("UPDATE " . COMPANY_TABLE . "  SET CompanyName='" . addSlashes($CompanyName) . "', Address='" . addSlashes($Address) . "' ,PhoneNumber='$PhoneNumber' WHERE Id='$Id'");
    }
    
    public function GetAllCompanies(){
        return $this->select("SELECT * FROM " . COMPANY_TABLE . "");
    }
    public function GetCompanyById($companyId){
        return $this->selectone("SELECT C.* FROM " . COMPANY_TABLE . " C WHERE C.Id='$companyId'");
    }
    public function deleteCompany($id){
        return $this->delete("DELETE FROM ".COMPANY_TABLE." WHERE id='$id'");
    }
}
?>

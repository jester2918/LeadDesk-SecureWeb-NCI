<?php
require_once PROJECT_ROOT_PATH . "/Model/Database.php";

class LeaveModel extends Database
{
    public function CreateEmployeeLeave($CompanyId,$userId,$LeaveApplyFrom,$LeaveApplyTo,$IsHalfDay,$LeaveTypeId,$LeaveReason){
        return $this->insert("INSERT INTO " . LEAVE_TABLE . " (`CompanyId` ,`EmployeeId` ,`FromDate` ,`ToDate` ,`IsHalfDay`,`LeaveTypeId` ,`LeaveReason`,`CreatedAt`,`IsApproved`,`IsRejected`,`RejectReason`,`ApprovedById`,`ApprovedAt`) 
        VALUES ('$CompanyId' ,'$userId' ,'$LeaveApplyFrom' ,'$LeaveApplyTo' ,'$IsHalfDay','$LeaveTypeId' ,'$LeaveReason','CURRENT_TIMESTAMP','0','0',null,null,null)");
    }
    public function LeaveApproved($id, $userId){
        return $this->insert("UPDATE " . LEAVE_TABLE . " SET IsApproved=1,ApprovedById='$userId',ApprovedAt=CURRENT_TIMESTAMP WHERE Id='$id'");
    }
    public function LeaveRejected($id){
        return $this->insert("UPDATE " . LEAVE_TABLE . " SET IsRejected=1 WHERE Id='$id'");
    }
    public function GetLeaveByCompanyId($companyId){
        return $this->select("SELECT L.Id AS LeaveId, L.*, uc.Id, uc.FullName AS EmployeeName, AP.FullName AS ApprovedBy FROM " . LEAVE_TABLE . " AS L LEFT JOIN " . USERS_TABLE . " AS uc ON uc.Id = L.EmployeeId LEFT JOIN " . USERS_TABLE . " AS AP ON L.ApprovedById = AP.Id WHERE L.CompanyId = '$companyId' ORDER BY L.Id DESC ");
    }
}
?>
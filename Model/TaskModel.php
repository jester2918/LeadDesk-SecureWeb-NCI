<?php
require_once PROJECT_ROOT_PATH . "/Model/Database.php";

class TaskModel extends Database
{
    public function GetRelatedToMeTaskList($userId)
    {
        return $this->select("SELECT T.*,U.FullName AssignToName,CreatedBy.FullName CreatedByName,UpdatedBy.FullName UpdatedByName 
        FROM " . TASK_TABLE . " T LEFT JOIN " . USERS_TABLE . " U ON T.AssignedToId = U.Id LEFT JOIN " . USERS_TABLE . " CreatedBy ON T.CreatedById = CreatedBy.Id LEFT JOIN " . USERS_TABLE . " UpdatedBy ON T.UpdatedById=UpdatedBy.Id where (T.AssignedToId='$userId' OR T.CreatedById='$userId')");
    }
    public function GetTasksByCompanyId($CompanyId)
    {
        return $this->select("SELECT T.*, U.FullName AS AssignToName, CreatedBy.FullName AS CreatedByName, UpdatedBy.FullName AS UpdatedByName FROM " . TASK_TABLE . " T LEFT JOIN " . USERS_TABLE . " U ON T.AssignedToId = U.Id LEFT JOIN " . USERS_TABLE . " CreatedBy ON T.CreatedById = CreatedBy.Id LEFT JOIN " . USERS_TABLE . " UpdatedBy ON T.UpdatedById = UpdatedBy.Id WHERE T.CompanyId = '$CompanyId'");
    }
    public function SaveTask($Id, $StatusId, $PriorityId, $CreatedById, $CompanyId, $AssignedToId, $Title, $Description, $DueDate, $taskAttachmentsModel)
    {
        $data = $this->selectone("SELECT P.Id FROM " . TASK_TABLE . " P where P.Id='$Id'");

        if (isset($data["success"])) {
            $taskNo = intval($this->selectone("SELECT COUNT(T.Id) as id FROM " . TASK_TABLE . " T WHERE T.CompanyId='$CompanyId'")["id"]) + 1;

            $this->insert("INSERT INTO " . TASK_TABLE . "(`TaskNo`,`Title`,`Description`,`CreatedAt`,`CreatedById`,`AssignedToId`,`StatusId`,`DueDate`,`CompanyId`,`PriorityId`) VALUES('$taskNo','" . addSlashes($Title) . "','" . addSlashes($Description) . "',CURRENT_TIMESTAMP,'$CreatedById','$AssignedToId','$StatusId','$DueDate','$CompanyId','$PriorityId')");
            return $this->selectone("SELECT LAST_INSERT_ID() AS id", [])["id"];
        } else {
            $this->insert("UPDATE " . TASK_TABLE . " SET Title='" . addSlashes($Title) . "',Description='" . addSlashes($Description) . "',AssignedToId='$AssignedToId',PriorityId='$PriorityId', StatusId='$StatusId',DueDate='$DueDate',UpdatedById='$CreatedById',UpdatedAt=CURRENT_TIMESTAMP WHERE Id='$Id'");
            return $Id;
        }
    }
    public function ChangeTaskStatusId($taskId,$taskStatusId){
       return $this->insert("UPDATE " .TASK_TABLE . " SET StatusId='$taskStatusId' WHERE Id='$taskId'");
    }
    public function DeleteTask($taskId){
       return $this->delete("DELETE FROM " .TASK_TABLE . " WHERE Id='$taskId'");
    }
    public function GetTaskListByAsigneeId($AssignedToId)
    {
        return $this->select("SELECT T.*,C.FullName AssignToName,CreatedBy.FullName CreatedByName,UpdatedBy.FullName UpdatedByName FROM ".TASK_TABLE." T LEFT JOIN " . USERS_TABLE . " C ON T.AssignedToId=C.Id LEFT JOIN " . USERS_TABLE . " CreatedBy ON T.CreatedById=CreatedBy.Id LEFT JOIN " . USERS_TABLE . " UpdatedBy ON T.UpdatedById=UpdatedBy.Id where t.AssignedToId='$AssignedToId'");
    }
}

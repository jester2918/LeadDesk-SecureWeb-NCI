<?php include_once('layout/header.php'); ?>
<?php include_once('layout/nav.php'); ?>
<?php include_once('layout/sideNav.php'); ?>

<?php 
    $taskController = new TaskController();
    $GetPriorityList = $taskController->GetPriorityList();
    $GetTaskStatusList = $taskController->GetTaskStatusList();
    $accountModel = new AccountModel();
    $employeeList = $accountModel->GetEmployeeByCompanyId($companyId);

    $employee_option = '<option value="0">Select Employee</option>';
    if(count($employeeList) > 0){
        foreach($employeeList as $employees){
            $employee_option .= '<option value="'.$employees['Id'].'">'.$employees['FullName'].'</option>';
        }
    }
    $GetPriority_option = '<option value="0">Select Priority</option>';
    if(count($GetPriorityList) > 0){
        foreach($GetPriorityList as $PriorityItem){
            $GetPriority_option .= '<option value="'.$PriorityItem->Id.'">'.$PriorityItem->Name.'</option>';
        }
    }
    $GetTaskStatusItem_option = '<option value="0">Select Status</option>';
    if(count($GetTaskStatusList) > 0){
        foreach($GetTaskStatusList as $TaskStatusItem){
            $GetTaskStatusItem_option .= '<option value="'.$TaskStatusItem->Id.'">'.$TaskStatusItem->Name.'</option>';
        }
    } 
?>


<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <div class="kanban-overlay"></div>
            <section id="kanban-wrapper">
                <div class="row">
                    <div class="col-12">
                        <div id="kanban-app"></div>
                    </div>
                </div>

                <div class="kanban-sidebar">
                    <div class="card shadow-none quill-wrapper">
                        <div class="card-header d-flex justify-content-between align-items-center border-bottom px-2 py-1">
                            <h3 class="card-title">Task</h3>
                            <button type="button" class="close close-icon">
                                <i class="feather icon-x"></i>
                            </button>
                        </div>
                        <!-- form start -->
                        <form id="taskForm" class="edit-kanban-item" enctype="multipart/form-data">
                            <div class="card-content position-relative">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Task Title</label>
                                        <input type="text" class="form-control edit-kanban-item-title" name="Title" placeholder="kanban Title">
                                    </div>
                                    <div class="form-group">
                                        <label>Task Description</label>
                                        <div class="snow-container border rounded p-0">
                                            <textarea class="form-control edit-kanban-item-description" id="Description" name="Description"></textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Employee</label>
                                                <select class="form-control text-dark" name="AssignedToId" id="AssignedToId">
                                                    <?= $employee_option ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Priority</label>
                                                <select class="form-control text-dark" name="PriorityId">
                                                    <?= $GetPriority_option ?>
                                                </select>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="form-group statusid-list d-none">
                                        <label>Status</label>
                                        <select id="StatusId" name="StatusId" class="form-control text-dark" id="StatusId">
                                            <?= $GetTaskStatusItem_option ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Due Date</label>
                                        <input type="date" class="form-control edit-kanban-item-duedate" name="DueDate">
                                    </div>
                                    <div class="form-group" style="display: none;">
                                        <label>Attachment</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="taskAttachmentsModel" name="taskAttachmentsModel">
                                            <label class="custom-file-label"  for="taskAttachmentsModel">Attach file</label>
                                        </div>
                                    </div>
                                    <input type="hidden" name="Id"  /> 
                                    <input type="hidden" name="CompanyId" value="<?= $_SESSION["CompanyId"] ?>" /> 
                                    <input type="hidden" name="CreatedById" value="<?= $_SESSION["user"]->Id ?>" />
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-end">
                                <button type="reset" class="btn btn-danger delete-kanban-item mr-1">
                                    <i class='feather icon-trash-2 mr-50'></i>
                                    <span>Delete</span>
                                </button>
                                <button class="btn btn-primary glow update-kanban-item save-task-form">
                                    <i class='feather icon-play mr-50'></i>
                                    <span>Save</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
<div class="sidenav-overlay"></div>
<div class="drag-target"></div>
<?php include_once('layout/footer.php'); ?>
<script src="/app-assets/js/scripts/pages/app-kanban.js"></script>


<script>

    $(document).on("click",".save-task-form",function(){
        var fomrSubmistionType = $("#taskForm").attr("data-formsubmitiontype");
        var taskAttachmentsModel = $('input[name="taskAttachmentsModel"]')[0].files[0];
        var data = new FormData();
        data.append('Title', $('input[name="Title"]').val());
        data.append('Description', $('.edit-kanban-item-description').val());
        data.append('AssignedToId', $('#AssignedToId').val());
        data.append('PriorityId', $('select[name="PriorityId"]').val());
        data.append('StatusId', $('#StatusId').val());
        data.append('DueDate', $('input[name="DueDate"]').val());
        data.append('Id', $('input[name="Id"]').val());
        data.append('CompanyId', $('input[name="CompanyId"]').val());
        data.append('CreatedById', $('input[name="CreatedById"]').val());
        data.append('taskAttachmentsModel', taskAttachmentsModel);
        

        $.ajax({
            url: '/api/index.php/task/SaveTask',
            type: 'POST',
            contentType: false,
            processData: false,
            data: data,
            headers: { "Authorization": "Bearer <?= $_SESSION["user"]->token ?>" },
            success: function(response) {
                console.log("SaveTask  response | ",response);
                var statusId = $("#StatusId").val();
                var statusTypeChangesOnSave = '';
                if(statusId == "1"){ statusTypeChangesOnSave = 'info'; }
                if(statusId == "2"){ statusTypeChangesOnSave = 'amber'; }
                if(statusId == "3"){ statusTypeChangesOnSave = 'purple'; }
                if(statusId == "4"){ statusTypeChangesOnSave = 'success'; }
                if(statusId == "5"){ statusTypeChangesOnSave = 'teal'; }
                if(statusId == "6"){ statusTypeChangesOnSave = 'red'; }
                var kanbanItem = $(".kanban-item[data-eid='"+$('input[name="Id"]').val()+"']").detach();
                $(".kanban-board[data-order='"+statusId+"'] .kanban-drag").append(kanbanItem);
                $(".kanban-board[data-order='"+statusId+"'] .kanban-item").attr("data-border",statusTypeChangesOnSave);
                Swal.fire({
                    icon: "success",
                    title: "Kanban updated Successfully",
                    showConfirmButton: false,
                    timer: 1500
                });
                setTimeout(function(){
                    window.location.reload();
                }, 2000);
            }
        });
    });

</script>
/*=========================================================================================
    File Name: kanban.js
    Description: kanban plugin
    ----------------------------------------------------------------------------------------
    Item Name: Stack - Responsive Admin Theme
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/


function TaskGetRequest(request,callback){
    $.ajax({
        url: '/api/index.php/task/'+request,
        type: 'GET',
        headers: { "Authorization": authToken },
        success: function(response) {
            //console.log("TaskGetRequest | ", request," | response | ",response);
            return callback(response);
           
        }
    });
}
function TaskPostRequest(request,data,callback){
  $.ajax({
      url: '/api/index.php/task/'+request,
      type: 'POST',
      data: data,
      headers: { "Authorization": authToken },
      success: function(response) {
          //console.log("TaskPostRequest | ", request," | response | ",response);
          return callback(response);
      }
  });
}
function TaskGetArgumentRequest(request,arg,callback){
    $.ajax({
        url: '/api/index.php/task/'+request+'?'+arg["key"]+'='+arg["value"],
        type: 'GET',
        headers: { "Authorization": authToken },
        success: function(response) {
            return callback(response);
        }
    });
}

$(document).ready(function () {
  var kanban_curr_el, kanban_curr_item_id, kanban_item_title,kanban_data, kanban_item, kanban_users;

  var KanbanExample = null;
  var kanban_board_data = [];
  var kanban_board_Item_data = null;
  var companyId_forTask = $("#changeCompany").data('id');
  TaskGetArgumentRequest("GetTasksByCompanyId",{ "key":"CompanyId","value": companyId_forTask },function(response){
      kanban_board_Item_data = response;
      TaskGetRequest("GetTaskStatusList",function(response){
          var responseCount = 0;
          var nestedItemArray = [];
          var tempMainObj = {};
          for(var item in response){
            responseCount++;
            
            nestedItemArray = [];
            for(var nestedItem in kanban_board_Item_data){
              if(kanban_board_Item_data[nestedItem]["StatusId"] == response[item]["Id"]){
                  var nestedItem_Obj = kanban_board_Item_data[nestedItem];  
                  console.log(response[item]["Name"]," | nestedItem_Obj | ",nestedItem_Obj); 
                  
                  var statusType = '';
                  if(nestedItem_Obj["StatusId"] == "1"){ statusType = 'info'; }
                  if(nestedItem_Obj["StatusId"] == "2"){ statusType = 'amber'; }
                  if(nestedItem_Obj["StatusId"] == "3"){ statusType = 'purple'; }
                  if(nestedItem_Obj["StatusId"] == "4"){ statusType = 'success'; }
                  if(nestedItem_Obj["StatusId"] == "5"){ statusType = 'teal'; }
                  if(nestedItem_Obj["StatusId"] == "6"){ statusType = 'red'; }

                 
                  if(nestedItem_Obj["ImageFileName"] == null || nestedItem_Obj["ImageFileName"] == 'null'){ 
                    var userImageAvatar = "../../../app-assets/images/portrait/small/avatar-s-11.png"; 
                  }else{
                    userImageAvatar = "../../../assets/uploads/"+nestedItem_Obj["ImageFileName"]; 
                  }

                  nestedItemArray.push({
                    id: nestedItem_Obj["Id"],
                    title: nestedItem_Obj["Title"],
                    description : nestedItem_Obj["Description"],
                    border: statusType,
                    dueDate: nestedItem_Obj["DueDate"],
                    PriorityId : nestedItem_Obj["PriorityId"],
                    StatusId : nestedItem_Obj["StatusId"],
                    AssignedToId : nestedItem_Obj["AssignedToId"],
                    CompanyId : nestedItem_Obj["CompanyId"],
                    CreatedById : nestedItem_Obj["CreatedById"],
                    users: [ userImageAvatar ]
                  });
              }
            }

            

            kanban_board_data.push({
              id: "kanban-board-"+item,
              title: response[item]["Name"],
              item: nestedItemArray
            });
            

            if(response.length == responseCount){
                KanbanExample = new jKanban({
                  element: "#kanban-wrapper", // selector of the kanban container
                  buttonContent: "+ Add New Item", // text or html content of the board button
                  dragItems        : true,
                  dragBoards       : true,   
                  itemAddOptions: {
                      enabled: false,                                              // add a button to board for easy item creation
                      content: '+',                                                // text or html content of the board button   
                      class: 'kanban-title-button btn btn-default btn-xs',         // default class of the button
                      footer: false                                                // position the button on footer
                  },
                  itemHandleOptions: {
                      enabled             : false,                                            // if board item handle is enabled or not
                      handleClass         : "item_handle",                                   // css class for your custom item handle
                      customCssHandler    : "drag_handler",                                 // when customHandler is undefined, jKanban will use this property to set main handler class
                      customCssIconHandler: "drag_handler_icon",                           // when customHandler is undefined, jKanban will use this property to set main icon handler class. If you want, you can use font icon libraries here
                      customHandler       : "<span class='item_handle'>+</span> %title% " // your entirely customized handler. Use %title% to position item title 
                                                                                        // any key's value included in item collection can be replaced with %key%
                  },
                  // click on current kanban-item
                  click       : function (el) {
                    // kanban-overlay and sidebar display block on click of kanban-item
                    $(".kanban-overlay").addClass("show");
                    $(".kanban-sidebar").addClass("show");
                    // Set el to var kanban_curr_el, use this variable when updating title
                    kanban_curr_el = el;
                    // Extract  the kan ban item & id and set it to respective vars
                    kanban_item_title = $(el).contents()[0].data;
                    // kanban_item_description= $(el).contents()[0].data;
                    kanban_curr_item_id = $(el).attr("data-eid");

                    $("#taskForm .statusid-list").addClass("d-none");
                    $("#taskForm").removeAttr("data-formsubmitiontype");

                    $("#taskForm").attr("data-formsubmitiontype","create-new-task");
                    if(kanban_curr_item_id != undefined && kanban_curr_item_id != null){

                      $("#taskForm").attr("data-formsubmitiontype","update-task");
                      $("#taskForm .statusid-list").removeClass("d-none"); 

                      $('.edit-kanban-item-description').val($(el).attr("data-description"));

                      $('.edit-kanban-item select[name="AssignedToId"]').val($(el).attr("data-assignedtoid"));
                      $('.edit-kanban-item select[name="PriorityId"]').val($(el).attr("data-priorityid"));
                      $('.edit-kanban-item select[name="StatusId"]').val($(el).attr("data-statusid"));
                      $('.edit-kanban-item-duedate').val($(el).attr("data-duedate"));
                      $('.edit-kanban-item input[name="Id"]').val(kanban_curr_item_id);
                      $('.edit-kanban-item input[name="CompanyId"]').val($(el).attr("data-companyid"));
                      $('.edit-kanban-item input[name="CreatedById"]').val($(el).attr("data-createdbyid"));
                    }

                    // set edit title
                    $(".edit-kanban-item .edit-kanban-item-title").val(kanban_item_title);
                  },
                  buttonClick : function (el, boardId) {
                    // create a form to add add new element
                    console.log("============================| buttonClick |==============================");
                    var formItem = document.createElement("form");
                    formItem.setAttribute("class", "itemform");
                    formItem.innerHTML =
                      '<div class="form-group">' +
                      '<textarea class="form-control add-new-item" rows="2" autofocus required></textarea>' +
                      "</div>" +
                      '<div class="form-group">' +
                      '<button type="submit" class="btn btn-primary btn-sm mr-50">save</button>' +
                      '<button type="button" id="CancelBtn" class="btn btn-sm btn-danger">Cancel</button>' +
                      "</div>";

                    // add new item on submit click
                    KanbanExample.addForm(boardId, formItem);
                    formItem.addEventListener("submit", function (e) {
                      e.preventDefault();
                      var text = e.target[0].value;
                      KanbanExample.addElement(boardId, {
                        title: text
                      });
                      formItem.parentNode.removeChild(formItem);
                      console.log("KanbanExample | ",KanbanExample);
                      console.log(boardId+" | data-order | | ");
                      console.log("boardId | ",boardId);
                      console.log("kanban-board Id | ",$(".kanban-board[data-id='"+boardId+"']").attr("data-order"));

                      $("#StatusId").val($(".kanban-board[data-id='"+boardId+"']").attr("data-order"));

                      $('div[data-id="'+boardId+'"] .kanban-item').last().click();
                    });
                    $(document).on("click", "#CancelBtn", function () {
                      $(this).closest(formItem).remove();
                    });
                  },
                  // callback when any board's item are dragged
                  dragEl      : function (el, source) { 
                  },            
                  // callback when any board's item stop drag         
                  dragendEl   : function (el) {
                  }, 
                  // callback when any board's item drop in a board                            
                  dropEl      : function (el, target, source, sibling) {
                    var data_eid = $(el).attr("data-eid");
                    var data_kanban_board = $(el).parents(".kanban-board").data();
                    console.log(".kanban-board item data-eid | ",data_eid);
                    console.log(".kanban-board item | ",$(el).data());
                    console.log(".kanban-board | ",data_kanban_board);

                    TaskPostRequest(
                      "ChangeTaskStatusId",
                      {
                        "taskId" : data_eid,
                        "taskStatusId" : data_kanban_board["order"], 
                      },
                      function(response){
                        console.log("taskId | ",data_eid);
                        console.log("order | ",data_kanban_board["order"]);
                        console.log("==========================================================");
                        console.log("response ",response);

                        var statusTypeChanges = '';
                        if(data_kanban_board["order"] == "1"){statusTypeChanges = 'info'; }
                        else if(data_kanban_board["order"] == "2"){statusTypeChanges = 'amber'; }
                        else if(data_kanban_board["order"] == "3"){statusTypeChanges = 'purple'; }
                        else if(data_kanban_board["order"] == "4"){statusTypeChanges = 'success'; }
                        else if(data_kanban_board["order"] == "5"){statusTypeChanges = 'teal'; }
                        else if(data_kanban_board["order"] == "6"){statusTypeChanges = 'red'; }
                        $(".kanban-item[data-eid='"+data_eid+"']").attr("data-border",statusTypeChanges);
                        $(".kanban-item[data-eid='"+data_eid+"']").attr("data-statusid", data_kanban_board["order"]);
                    });
                  },    
                  addItemButton: true, // add a button to board for easy item creation
                  boards: kanban_board_data // data passed from defined variable
                });
                // Add html for Custom Data-attribute to Kanban item
                var board_item_id, board_item_el;
                // Kanban board loop
                for (kanban_data in kanban_board_data) {
                  // Kanban board items loop
                  for (kanban_item in kanban_board_data[kanban_data].item) {
                    var board_item_details = kanban_board_data[kanban_data].item[kanban_item]; // set item details
                    board_item_id = $(board_item_details).attr("id"); // set 'id' attribute of kanban-item

                    (board_item_el = KanbanExample.findElement(board_item_id)), // find element of kanban-item by ID
                    (board_item_users = board_item_dueDate = board_item_comment = board_item_attachment = board_item_image = board_item_badge =  " ");

                    // check if users are defined or not and loop it for getting value from user's array
                    if (typeof $(board_item_el).attr("data-users") !== "undefined") {
                      for (kanban_users in kanban_board_data[kanban_data].item[kanban_item].users) {
                        board_item_users +=
                          '<li class="avatar pull-up my-0">' +
                          '<img class="media-object" src=" ' +
                          kanban_board_data[kanban_data].item[kanban_item].users[kanban_users] +
                          '" alt="Avatar" height="18" width="18">' +
                          "</li>";
                      }
                    }
                    // check if dueDate is defined or not
                    if (typeof $(board_item_el).attr("data-dueDate") !== "undefined") {
                      board_item_dueDate =
                        '<div class="kanban-due-date mr-50">' +
                        '<i class="feather icon-clock font-size-small mr-25"></i>' +
                        '<span class="font-size-small">' +
                        $(board_item_el).attr("data-dueDate") +
                        "</span>" +
                        "</div>";
                    }
                    // check if comment is defined or not
                    if (typeof $(board_item_el).attr("data-comment") !== "undefined") {
                      board_item_comment =
                        '<div class="kanban-comment mr-50">' +
                        '<i class="feather icon-message-square font-size-small mr-25"></i>' +
                        '<span class="font-size-small">' +
                        $(board_item_el).attr("data-comment") +
                        "</span>" +
                        "</div>";
                    }
                    // check if attachment is defined or not
                    if (typeof $(board_item_el).attr("data-attachment") !== "undefined") {
                      board_item_attachment =
                        '<div class="kanban-attachment">' +
                        '<i class="feather icon-link font-size-small mr-25"></i>' +
                        '<span class="font-size-small">' +
                        $(board_item_el).attr("data-attachment") +
                        "</span>" +
                        "</div>";
                    }
                    // check if Image is defined or not
                    if (typeof $(board_item_el).attr("data-image") !== "undefined") {
                      board_item_image =
                        '<div class="kanban-image mb-1">' +
                        '<img class="img-fluid" src=" ' +
                        kanban_board_data[kanban_data].item[kanban_item].image +
                        '" alt="kanban-image">';
                      ("</div>");
                    }
                    // check if Badge is defined or not
                    if (typeof $(board_item_el).attr("data-badgeContent") !== "undefined") {
                      board_item_badge =
                        '<div class="kanban-badge">' +
                        '<div class="avatar bg-' +
                        kanban_board_data[kanban_data].item[kanban_item].badgeColor +
                        ' font-size-small font-weight-bold">' +
                        kanban_board_data[kanban_data].item[kanban_item].badgeContent +
                        "</div>";
                      ("</div>");
                    }
                    // add custom 'kanban-footer'
                    if (typeof (
                        $(board_item_el).attr("data-dueDate") ||
                        $(board_item_el).attr("data-comment") ||
                        $(board_item_el).attr("data-users") ||
                        $(board_item_el).attr("data-attachment")
                      ) !== "undefined"
                    ) {
                      $(board_item_el).append(
                        '<div class="kanban-footer d-flex justify-content-between mt-1">' +
                        '<div class="kanban-footer-left d-flex">' +
                        board_item_dueDate +
                        board_item_comment +
                        board_item_attachment +
                        "</div>" +
                        '<div class="kanban-footer-right">' +
                        '<div class="kanban-users">' +
                        board_item_badge +
                        '<ul class="list-unstyled users-list cursor-pointer m-0 d-flex align-items-center">' +
                        board_item_users +
                        "</ul>" +
                        "</div>" +
                        "</div>" +
                        "</div>"
                      );
                    }
                    // add Image prepend to 'kanban-Item'
                    if (typeof $(board_item_el).attr("data-image") !== "undefined") {
                      $(board_item_el).prepend(board_item_image);
                    }
                  }
                }
            }

          }
          
      });
  });



  // Add new kanban board
  //---------------------
  var addBoardDefault = document.getElementById("add-kanban");
  var i = 1;
  if(addBoardDefault){
    addBoardDefault.addEventListener("click", function () {
      KanbanExample.addBoards([{
        id: "kanban-" + i, // generate random id for each new kanban
        title: "Untitle"
      }]);
      var kanbanNewBoard = KanbanExample.findBoard("kanban-" + i)
  
      if (kanbanNewBoard) {
        $(".kanban-title-board").on("mouseenter", function () {
          $(this).attr("contenteditable", "true");
          $(this).addClass("line-ellipsis");
        });
        // kanbanNewBoardData =
        //   '<div class="dropdown">' +
        //   '<div class="dropdown-toggle cursor-pointer" role="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-vertical"></i></div>' +
        //   '<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton"> ' +
        //   '<a class="dropdown-item" href="#"><i class="feather icon-link mr-50"></i>Copy Link</a>' +
        //   '<a class="dropdown-item kanban-delete" id="kanban-delete" href="#"><i class="feather icon-trash-2 mr-50"></i>Delete</a>' +
        //   "</div>" + "</div>";
        var kanbanNewDropdown = $(kanbanNewBoard).find("header");
        //$(kanbanNewDropdown).append(kanbanNewBoardData);
      }
      i++;
    });
  }


  // Delete kanban board
  //---------------------
  $(document).on("click", ".kanban-delete", function (e) {
    var $id = $(this)
      .closest(".kanban-board")
      .attr("data-id");
    addEventListener("click", function () {
      KanbanExample.removeBoard($id);
    });
  });

  // Kanban board dropdown
  // ---------------------
  var kanban_dropdown = document.createElement("div");
  kanban_dropdown.setAttribute("class", "dropdown");

  //dropdown();

  function dropdown() {
    kanban_dropdown.innerHTML =
      '<div class="dropdown-toggle cursor-pointer" role="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-vertical"></i></div>' +
      '<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton"> ' +
      '<a class="dropdown-item" href="#"><i class="feather icon-link mr-50"></i>Copy Link</a>' +
      '<a class="dropdown-item kanban-delete" id="kanban-delete" href="#"><i class="feather icon-trash-2 mr-50"></i>Delete</a>' +
      "</div>";
    if (!$(".kanban-board-header div").hasClass("dropdown")) {
      $(".kanban-board-header").append(kanban_dropdown);
    }
  }

  // Kanban-overlay and sidebar hide
  // --------------------------------------------
  $(".kanban-sidebar .delete-kanban-item, .kanban-sidebar .close-icon, .kanban-sidebar .kanban-overlay").on("click", function () {
    $(".kanban-overlay").removeClass("show");   
    $(".kanban-sidebar").removeClass("show");    
  });

  // Updating Data Values to Fields
  // -------------------------------
  $(".update-kanban-item").on("click", function (e) {
    e.preventDefault();
    //console.log(".update-kanban-item | ",e);
  });

  // Delete Kanban Item
  // -------------------
  $(".delete-kanban-item").on("click", function () {
    $delete_item = kanban_curr_item_id;
    TaskGetRequest("DeleteTask?taskId="+kanban_curr_item_id,function(response){
      console.log(response);
    })
    addEventListener("click", function () {
      KanbanExample.removeElement($delete_item);
    });
  });

  // Kanban Quill Editor
  // -------------------
  var composeMailEditor = new Quill(".snow-container .compose-editor", {
    modules: {
      toolbar: ".compose-quill-toolbar"
    },
    placeholder: "Write a Comment... ",
    theme: "snow"
  });

  // Making Title of Board editable
  // ------------------------------
  $(".kanban-title-board").on("mouseenter", function () {
    $(this).attr("contenteditable", "true");
    $(this).addClass("line-ellipsis");
  });

  // kanban Item - Pick-a-Date
  $(".edit-kanban-item-date").pickadate();

  // Perfect Scrollbar - card-content on kanban-sidebar
  if ($(".kanban-sidebar .edit-kanban-item .card-content").length > 0) {
    var kanbanSidebar = new PerfectScrollbar(".kanban-sidebar .edit-kanban-item .card-content", {
      wheelPropagation: false
    });
  }

  // select default bg color as selected option
  $("select").addClass($(":selected", this).attr("class"));

  // // change bg color of select form-control
  // $("select").change(function () {
  //   $(this)
  //     .removeClass($(this).attr("class"))
  //     .addClass($(":selected", this).attr("class") + " form-control text-white");
  // });



});
<?php include_once('layout/header.php'); ?>
<?php include_once('layout/nav.php'); ?>
<?php include_once('layout/sideNav.php'); ?>

<?php
    if ($_SESSION['userType'] == "employee") {
        echo '<script>window.location.href = "/index.php";</script>';
        exit();
    }
?>

<style>
    .table td { padding: 6px 3px; }
    .table thead th { padding: 12px 3px; }
    .sortable-handle { padding: 5px; cursor: move; }
    .lc-col { max-width: 75px; min-width: 75px; width: 75px; }
    .cat-col { text-align: right; }
    .cat-title-col { width: 50px; max-width: 50px; min-width: 50px; }
    .table-responsive { overflow: auto !important; height: calc(100vh - 280px); }
    .tableFixHead { overflow: auto; height: 100px; }
    .tableFixHead thead th { position: sticky; top: -1px; z-index: 1; background-color: rgb(245 248 255); }
    .ui-state-highlight { background: none !important; border: 3px dashed black !important; }
    .table { display: table !important; }
    .active { background-color: #f3f3f3; }
    .border-bottom{border-bottom: 1px solid black;}
    .border-top{border-top: 1px solid black;}
    .table td{ border-bottom: none; border-top: none; padding: 14px 15px;}
    .table thead th { padding: 16px 15px; }
</style>
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

<script>

    $(function() {
        if (window.innerWidth >= 1300) {
            $('body').addClass('sidebar-main');
        }
    })

    document.addEventListener("DOMContentLoaded", function() {
        var lazyloadImages;
        if ("IntersectionObserver" in window) {
            lazyloadImages = document.querySelectorAll(".lazy");
            var imageObserver = new IntersectionObserver(function(entries, observer) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        var image = entry.target;
                        image.src = image.dataset.src;
                        image.classList.remove("lazy");
                        imageObserver.unobserve(image);
                    }
                });
            });

            lazyloadImages.forEach(function(image) {
                imageObserver.observe(image);
            });
        } else {
            var lazyloadThrottleTimeout;
            lazyloadImages = document.querySelectorAll(".lazy");

            function lazyload() {
                if (lazyloadThrottleTimeout) {
                    clearTimeout(lazyloadThrottleTimeout);
                }

                lazyloadThrottleTimeout = setTimeout(function() {
                    var scrollTop = window.pageYOffset;
                    lazyloadImages.forEach(function(img) {
                        if (img.offsetTop < (window.innerHeight + scrollTop)) {
                            img.src = img.dataset.src;
                            img.classList.remove('lazy');
                        }
                    });
                    if (lazyloadImages.length == 0) {
                        document.removeEventListener("scroll", lazyload);
                        window.removeEventListener("resize", lazyload);
                        window.removeEventListener("orientationChange", lazyload);
                    }
                }, 20);
            }

            document.addEventListener("scroll", lazyload);
            window.addEventListener("resize", lazyload);
            window.addEventListener("orientationChange", lazyload);
        }
    })
</script>

<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title mb-0">Department List</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Home</a>
                            </li>
                            <li class="breadcrumb-item">Department List
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-page">
            <div class="container-fluid">
                <?php
                $departmentModel = new DepartmentModel();
                $DepartmentList  = $departmentModel->GetDepartmentByCompanyId($companyId);
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-block card-stretch search-table">
                            <div class="card-body p-0">
                                <div class="d-flex justify-content-between align-items-center pt-3 px-3">
                                    <h4 class="font-weight-bold">Departments</h4>
                                    <div class="d-flex align-items-center" style="gap:10px;">
                                        <button class="btn btn-outline-primary position-relative align-items-center justify-content-between cat-enable-sorting" onclick="enableCategorySorting()">
                                            Enable Sort
                                        </button>
                                        <a href="/departmentCRUD.php?popup=true" class="genericMPOpener btn btn-primary position-relative d-flex align-items-center justify-content-between">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-2" width="15" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                            </svg>
                                            Add Department
                                        </a>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center p-3 search-panel-box" style="gap: 20px;">
                                    <input type="text" class="form-control search-input" placeholder="Search here..." />
                                    <button class="btn btn-outline-primary search-button position-relative d-flex align-items-center">Search</button>
                                </div>
                                <?php
                                function departRow($departRow, $department_type, $child = false)
                                {
                                    return '<tr class="cart-row cartingrow_' . $departRow['Id'] . ' ' . ($child ? "last-cat" : "") . '" id="departmentRow_' . $departRow['Id'] . '" data-catid="' . $departRow['Id'] . '" parent-id="' . $departRow['pid'] . '" data-displayorder="' . $departRow['display_order'] . '">
                                            <td class="border-bottom border-left cat-title-col">
                                                <div class="active-project-1 d-flex align-items-center mt-0">
                                                    <span class="sortable-handle text-dark">||</span>
                                                </div>
                                            </td>
                                            <td class="title-col cat-title border-bottom">' . $departRow['DepartmentName'] . '</td>
                                            <td class="cat-col cat-type border-bottom" style="padding-top: 20px; padding-right: 35px;">' . $department_type . '</td>
                                            <td class="lc-col border-bottom">
                                                <div class="d-flex justify-content-end align-items-center">
                                                    <a class="genericMPOpener" href="/departmentCRUD.php?id=' . $departRow['Id'] . '&popup=true" >
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="text-secondary mr-2" width="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                        </svg>
                                                    </a>
                                                    <a class="delete-department ' . ($child ? "child-cat" : "") . ' badge bg-danger" data-id="' . $departRow['Id'] . '">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>';
                                }

                                function makeHierarchy($childHtml)
                                {
                                    return '<tr class="white-space-no-wrap border-0 child-tr">
                                            <td  class="border-0 p-0" style="width: 50px;max-width:50px;min-width:50px;"></td>
                                            <td colspan="3" class="p-0 m-0">
                                                <table class="table m-0 p-0 hr-table child-cat-sort">
                                                    <tbody class="">
                                                        ' . $childHtml . '
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>';
                                }

                                function categorySubList($id, $title)
                                {
                                    global $DepartmentList;
                                    $render_html = '';
                                    $render_html_count = 0;
                                    foreach ($DepartmentList as $departRow) {
                                        if ($departRow['pid'] == $id) {
                                            $render_html_count++;
                                            $department_type = $title;

                                            $render_child_html = categorySubList($departRow['Id'], $departRow['DepartmentName']);
                                            $haveChilds = $render_child_html !== "";
                                            if (!$haveChilds) {
                                                $department_type = "";
                                                $render_html .= departRow($departRow, $department_type, true);
                                            } else {
                                                $render_html .= '<tr id="departmentRow_' . $departRow['Id'] . '" data-catid="' . $departRow['Id'] . '" data-displayorder="' . $departRow['display_order'] . '">
                                                        <td colspan="4" class="p-0 m-0">
                                                            <table class="table m-0 p-0 csl-table">';
                                                $render_html .= departRow($departRow, $department_type);
                                                $render_html .= makeHierarchy($render_child_html);
                                                $render_html .= '</table>
                                                        </td>
                                                    </tr>';
                                            }
                                        }
                                    }
                                    return $render_html;
                                }
                                ?>
                                <div class="table-responsive category-responsive-table">
                                    <table class="table mb-0 tableFixHead">
                                        <thead class="table-color-heading">
                                            <tr class="">
                                                <th scope="col" style="width: 50px;">
                                                </th>
                                                <th scope="col">
                                                    Title
                                                </th>
                                                <th scope="col" class="cat-col" style="padding-right: 40px;">
                                                    Department
                                                </th>
                                                <th scope="col" class="text-right lc-col">
                                                    Action
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="parent-depart-sort">
                                            <?php foreach ($DepartmentList as $departments) {  ?>
                                                <?php if ($departments['pid'] == 0) { ?>
                                                    <tr id="parentdepartRow_<?= $departments['Id'] ?>" data-displayorder="<?= $departments['display_order'] ?>" data-catid="<?= $departments['Id'] ?>">
                                                        <td colspan="4" class="p-0 m-0">
                                                            <table class="table p-table m-0 p-0">
                                                                <?php echo departRow($departments, "Parent Department");
                                                                $render_child_html = categorySubList($departments['Id'], $departments['DepartmentName']);
                                                                echo makeHierarchy($render_child_html); ?>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
     
    $(document).ready(function() {
        $(document).on('click', '.genericMPOpener', function(e) {
            e.preventDefault();
            var that = $(this);
            if (!$(this).hasClass('MpAdded')) {
                $(this).addClass('MpAdded');
                $(this).magnificPopup({
                    type: 'iframe',
                    closeOnContentClick: !that.hasClass('bgNoClose'),
                    modal: that.hasClass('bgNoClose'),
                    closeBtnInside: false,
                }).magnificPopup('open');
            } else {
                $(this).magnificPopup('open');
            }
        });

        $(document).on('click', '.delete-department', function(e) {
            var el = this;
            var deleteid = $(el).data('id');
            var valid = false
            if ($(el).hasClass('child-cat')) {
                valid = true;
            } else if (($(el).closest('table').find('.cart-row').length - 1) <= 0) {
                valid = true;
            }
            if (!valid) {
                alert("Cannot delete parent Department, child category should be deleted first!");
                e.preventDefault();
                return false;
            }

            var confirmalert = confirm("Are you sure?");
            if (confirmalert == true) {
                $.ajax({
                    url: '/api/index.php/department/delete',
                    headers: {
                        "Authorization": "Bearer <?= $_SESSION["user"]->token ?>"
                    },
                    type: 'POST',
                    data: {
                        id: deleteid
                    },
                    success: function(response) {
                        if (response.success) {
                            $(el).closest('tr').css('background', 'tomato');
                            $(el).closest('tr').fadeOut(800, function() {
                                $(this).remove();
                            });
                        } else {
                            alert(response.message);
                        }
                    }
                });
            }
        });

        $(document).on("click", ".search-button", function() {
            searchAction($(this))
        });

        $(document).on("click", ".cart-row", function() {
            var id = $(this).data('catid');
            $(".cart-row").removeClass('active');
            $('.cartingrow_' + id).addClass("active");
        });
        
        $(document).on("keyup", ".search-input", function() {
            searchAction($(this))
            if($(".search-input").val() == ''){
                $('.cart-row').show();
            }
        });
       
    
        var url = new URL(window.location.href);
        var currentEditing = url.searchParams.get("currentlyEditing");
        if (currentEditing !== null) {
            $('#departmentRow_' + currentEditing).append('<input type="text" syle="display:none;" id="departmentRow_' + +currentEditing + '_input">')
            $('#departmentRow_' + currentEditing + '_input').focus();
            $('#departmentRow_' + currentEditing + '_input').remove();
            history.pushState(null, "", location.origin + location.pathname);
        }

    });


    function enableCategorySorting() {
        $('.cat-enable-sorting').hide();
        $(".parent-depart-sort").sortable({
            items: "> tr",
            handle: ".sortable-handle",
            helper: "clone",
            revert: true,
            cursor: "move",
            placeholder: "ui-state-highlight cat-highlight",
            forcePlaceholderSize: true,
            forceHelperSize: false,
            tolerance: "pointer",
            update: function(event, ui) {
                var parentCatArr = $(".parent-depart-sort").sortable("toArray").map(x => parseInt(x.replace("parentdepartRow_", "")))
                updateDisplayOrder({
                    type: 'department',
                    data: parentCatArr
                });
            }
        });

        $(".child-cat-sort").sortable({
            items: "> tbody > tr",
            handle: ".sortable-handle",
            helper: "clone",
            revert: true,
            cursor: "move",
            placeholder: "ui-state-highlight cat-highlight",
            forcePlaceholderSize: true,
            forceHelperSize: false,
            tolerance: "pointer",
            update: function(event, ui) {
                var catArr = $(this).sortable("toArray").map(x => parseInt(x.replace("departmentRow_", "")))
                updateDisplayOrder({
                    type: 'department',
                    data: catArr
                });
            }
        });
    }

    var updateCategoryFromPopup = function(method, data) {
        if (method == "add") {
            window.location.href = window.location.origin + window.location.pathname + "?currentlyEditing=" + data.id;
        } else {
            var el = $('#departmentRow_' + data.id);
            var oldParentId = el.attr('parent-id');
            if (parseInt(oldParentId) === parseInt(data.parentid)) {
                el.find('.cat-title').text(data.title);
                el.find('.cat-image').attr('src', '<?= ASSETS_ROOT_PATH ?>' + data.thumb);
            } else {
                window.location.href = window.location.origin + window.location.pathname + "?currentlyEditing=" + data.id;
            }
        }
        $(".mfp-close").click();
    }

    function searchAction(prop) {
        var search_input = prop.parents(".search-panel-box").find(".search-input").val();
        
        prop.parents(".search-table").find("table tbody tr").each(function() {
            var txtValue = $(this).find("td").eq(1).text();
            if (txtValue.toLowerCase().indexOf(search_input.toLowerCase()) > -1) { 
                $('.cart-row').hide();
                $(this).show();
            }
        });
    }

    function updateDisplayOrder(prop) {
        console.log("updateDisplayOrder", prop);
        var urlLink = '';
        var orderIdArray = prop["data"];
        console.log(orderIdArray);
        urlLink = '/api/index.php/department/updatedisplayorder';
        $.ajax({
            url: urlLink,
            headers: {
                "Authorization": "Bearer <?= $_SESSION["user"]->token ?>"
            },
            type: 'POST',
            data: {
                orderIds: orderIdArray.toString()
            },
            success: function(response) {
                if (response.success) {
                    console.log(response.message);
                } else {
                    alert(response.message);
                }
            }
        });
    }
</script>

<?php include_once('layout/footer.php'); ?>

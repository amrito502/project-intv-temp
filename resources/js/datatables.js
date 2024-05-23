// user table start
$(document).ready(function () {
    $("#user-table").DataTable({
        processing: true,
        serverSide: true,
        // ordering: false,
        "order": [
            [4, "desc"]
        ],
        pageLength: 100,
        ajax: route("user.index"),
        rowId: "id",
        columns: [{
                data: "action",
                name: "action",
                orderable: false,
                searchable: false
            },
            {
                data: "status_ui",
                name: "status_ui"
            },
            {
                data: "DT_RowIndex",
                name: "DT_RowIndex",
                orderable: false,
                searchable: false
            },
            {
                data: "roles",
                name: "roles"
            },
            {
                data: "email",
                name: "email"
            },
            {
                data: "company_name",
                name: "company_name"
            },
            {
                data: "branch_name",
                name: "branch_name"
            },
            {
                data: "project_name",
                name: "project_name"
            }
        ]
    });
});


// role table
$(document).ready(function () {
    $("#role-table").DataTable({
        processing: true,
        serverSide: true,
        pageLength: 50,
        ajax: route("role.index"),
        rowId: "id",
        columns: [{
                data: "action",
                name: "action",
                orderable: false,
                searchable: false
            },
            {
                data: "DT_RowIndex",
                name: "DT_RowIndex",
                orderable: false,
                searchable: false
            },
            {
                data: "name",
                name: "name"
            }
        ]
    });
});


// Module table
$(document).ready(function () {
    $("#module-table").DataTable({
        processing: true,
        serverSide: true,
        pageLength: 50,
        ajax: route("module.index"),
        rowId: "id",
        columns: [{
                data: "DT_RowIndex",
                name: "DT_RowIndex",
                orderable: false,
                searchable: false
            },
            {
                data: "parent_menu_name",
                name: "parent_menu_name"
            },
            {
                data: "name",
                name: "name"
            },
            {
                data: "url",
                name: "url"
            },
            {
                data: "action",
                name: "action",
                orderable: false,
                searchable: false
            }
        ]
    });
});



// Company table
$(document).ready(function () {
    $("#company-table").DataTable({
        processing: true,
        serverSide: true,
        pageLength: 50,
        ajax: route("company.index"),
        rowId: "id",
        columns: [{
                data: "action",
                name: "action",
                orderable: false,
                searchable: false
            },
            {
                data: "DT_RowIndex",
                name: "DT_RowIndex",
                orderable: false,
                searchable: false
            },
            {
                data: "name",
                name: "name"
            },
            {
                data: "contact_person_name",
                name: "contact_person_name"
            },
            {
                data: "phone",
                name: "phone"
            },
            {
                data: "address",
                name: "address"
            }
        ]
    });
});


// branch table
$(document).ready(function () {
    $("#branch-table").DataTable({
        processing: true,
        serverSide: true,
        pageLength: 50,
        ajax: route("branch.index"),
        rowId: "id",
        columns: [{
                data: "action",
                name: "action",
                orderable: false,
                searchable: false
            },
            {
                data: "DT_RowIndex",
                name: "DT_RowIndex",
                orderable: false,
                searchable: false
            },
            {
                data: "branch_name",
                name: "branch_name"
            },
            {
                data: "contact_person_name",
                name: "contact_person_name"
            },
            {
                data: "contact_person_phone",
                name: "contact_person_phone"
            }
        ]
    });
});

// project table
$(document).ready(function () {
    $("#project-table").DataTable({
        processing: true,
        serverSide: true,
        pageLength: 50,
        ajax: route("project.index"),
        rowId: "id",
        columns: [
            {
                data: "dashboard_status_ui",
                name: "dashboard_status_ui",
                orderable: false,
                searchable: false
            },{
                data: "action",
                name: "action",
                orderable: false,
                searchable: false
            },
            {
                data: "DT_RowIndex",
                name: "DT_RowIndex",
                orderable: false,
                searchable: false
            },
            {
                data: "company_name",
                name: "company_name"
            },
            {
                data: "branch_name",
                name: "branch_name"
            },
            {
                data: "project_name",
                name: "project_name"
            },
            {
                data: "units",
                name: "units"
            },
            {
                data: "towers",
                name: "towers"
            }
        ]
    });
});


// vendor table
$(document).ready(function () {
    $("#vendor-table").DataTable({
        processing: true,
        serverSide: true,
        pageLength: 50,
        ajax: route("vendor.index"),
        rowId: "id",
        columns: [{
                data: "action",
                name: "action",
                orderable: false,
                searchable: false
            },
            {
                data: "DT_RowIndex",
                name: "DT_RowIndex",
                orderable: false,
                searchable: false
            },
            {
                data: "vendor_type",
                name: "vendor_type"
            },
            {
                data: "name",
                name: "name"
            },
            {
                data: "contact_person_name",
                name: "contact_person_name"
            },
            {
                data: "contact_person_phone",
                name: "contact_person_phone"
            },
            {
                data: "contact_person_email",
                name: "contact_person_email"
            },
            {
                data: "address",
                name: "address"
            }
        ]
    });
});



// unit table
$(document).ready(function () {
    $("#unit-table").DataTable({
        processing: true,
        serverSide: true,
        pageLength: 50,
        ajax: route("unit.index"),
        rowId: "id",
        columns: [{
                data: "action",
                name: "action",
                orderable: false,
                searchable: false
            },
            {
                data: "DT_RowIndex",
                name: "DT_RowIndex",
                orderable: false,
                searchable: false
            },
            {
                data: "code",
                name: "code"
            },
            {
                data: "name",
                name: "name"
            },
        ]
    });
});

// materialgroup table
$(document).ready(function () {
    $("#materialgroup-table").DataTable({
        processing: true,
        serverSide: true,
        pageLength: 50,
        ajax: route("materialgroup.index"),
        rowId: "id",
        columns: [{
                data: "action",
                name: "action",
                orderable: false,
                searchable: false
            },
            {
                data: "DT_RowIndex",
                name: "DT_RowIndex",
                orderable: false,
                searchable: false
            },
            {
                data: "name",
                name: "name"
            }
        ]
    });
});


// material table
$(document).ready(function () {
    $("#material-table").DataTable({
        processing: true,
        serverSide: true,
        pageLength: 50,
        ajax: route("material.index"),
        rowId: "id",
        columns: [{
                data: "action",
                name: "action",
                orderable: false,
                searchable: false
            },
            {
                data: "DT_RowIndex",
                name: "DT_RowIndex",
                orderable: false,
                searchable: false
            },
            {
                data: "code",
                name: "code"
            },
            {
                data: "name",
                name: "name"
            },
            {
                data: "uom",
                name: "uom"
            },
            {
                data: "remarks",
                name: "remarks"
            }
        ]
    });
});




// materialreceive-table table
$(document).ready(function () {
    $("#materialreceive-table").DataTable({
        processing: true,
        serverSide: true,
        pageLength: 50,
        ajax: route("materialreceive.index"),
        rowId: "id",
        columns: [{
                data: "action",
                name: "action",
                orderable: false,
                searchable: false
            },
            {
                data: "DT_RowIndex",
                name: "DT_RowIndex",
                orderable: false,
                searchable: false
            },
            {
                data: "system_serial",
                name: "system_serial"
            },
            {
                data: "vouchar_date_formatted",
                name: "vouchar_date_formatted"
            },
            {
                data: "project_name",
                name: "project_name"
            },
            {
                data: "materials",
                name: "materials"
            },
            {
                data: "status",
                name: "status"
            }
        ]
    });
});


// // gallery table
// $(document).ready(function () {
//     $("#gallery-table").DataTable({
//         processing: true,
//         serverSide: true,
//         pageLength: 50,
//         ajax: route("gallery.index"),
//         rowId: "id",
//         columns: [{
//                 data: "DT_RowIndex",
//                 name: "DT_RowIndex",
//                 orderable: false,
//                 searchable: false
//             },
//             {
//                 data: "title",
//                 name: "title"
//             },
//             {
//                 data: "action",
//                 name: "action",
//                 orderable: false,
//                 searchable: false
//             }
//         ]
//     });
// });


// budgethead table
$(document).ready(function () {
    $("#budgethead-table").DataTable({
        processing: true,
        serverSide: true,
        pageLength: 50,
        ajax: route("budgethead.index"),
        rowId: "id",
        columns: [{
                data: "action",
                name: "action",
                orderable: false,
                searchable: false
            },
            {
                data: "DT_RowIndex",
                name: "DT_RowIndex",
                orderable: false,
                searchable: false
            },
            {
                data: "type",
                name: "type"
            },
            {
                data: "name",
                name: "name"
            }
        ]
    });
});


// cashrequisition table
$(document).ready(function () {
    $("#cashrequisition-table").DataTable({
        processing: true,
        serverSide: true,
        pageLength: 50,
        ajax: route("cashrequisition.index"),
        rowId: "id",
        columns: [{
                data: "action",
                name: "action",
                orderable: false,
                searchable: false
            },
            {
                data: "DT_RowIndex",
                name: "DT_RowIndex",
                orderable: false,
                searchable: false
            },
            {
                data: "date_formatted",
                name: "date_formatted"
            },
            {
                data: "project_name",
                name: "project_name"
            },
            {
                data: "unit_name",
                name: "unit_name"
            },
            {
                data: "tower_name",
                name: "tower_name"
            },
            {
                data: "item_list",
                name: "item_list"
            },
            {
                data: "status",
                name: "status"
            }
        ]
    });
});


// dailyexpense table
$(document).ready(function () {
    $("#dailyexpense-table").DataTable({
        processing: true,
        serverSide: true,
        pageLength: 50,
        ajax: route("dailyexpense.index"),
        rowId: "id",
        columns: [{
                data: "action",
                name: "action",
                orderable: false,
                searchable: false
            },
            {
                data: "DT_RowIndex",
                name: "DT_RowIndex",
                orderable: false,
                searchable: false
            },
            {
                data: "date_formatted",
                name: "date_formatted"
            },
            {
                data: "project_name",
                name: "project_name"
            },
            {
                data: "unit_name",
                name: "unit_name"
            },
            {
                data: "tower_name",
                name: "tower_name"
            },
            {
                data: "expense_list",
                name: "expense_list"
            }
        ]
    });
});

// material requisition table
$(document).ready(function () {
    $("#materialrequisition-table").DataTable({
        processing: true,
        serverSide: true,
        pageLength: 50,
        ajax: route("materialrequisition.index"),
        rowId: "id",
        columns: [{
                data: "action",
                name: "action",
                orderable: false,
                searchable: false
            },
            {
                data: "DT_RowIndex",
                name: "DT_RowIndex",
                orderable: false,
                searchable: false
            },
            {
                data: "date_formatted",
                name: "date_formatted"
            },
            {
                data: "tower_name",
                name: "tower_name"
            },
            {
                data: "status",
                name: "status"
            }
        ]
    });
});


// material requisition approve step one table
$(document).ready(function () {
    $("#materialrequisition-approve-step-one-table").DataTable({
        processing: true,
        serverSide: true,
        pageLength: 50,
        ajax: route("approveRequisitionStepOneList"),
        rowId: "id",
        columns: [{
                data: "action",
                name: "action",
                orderable: false,
                searchable: false
            },
            {
                data: "DT_RowIndex",
                name: "DT_RowIndex",
                orderable: false,
                searchable: false
            },
            {
                data: "date_formatted",
                name: "date_formatted"
            },
            {
                data: "project_name",
                name: "project_name"
            },
            {
                data: "unit_name",
                name: "unit_name"
            },
            {
                data: "tower_name",
                name: "tower_name"
            },
            {
                data: "status",
                name: "status"
            }
        ]
    });
});


// material requisition approve step two table
$(document).ready(function () {
    $("#materialrequisition-approve-step-two-table").DataTable({
        processing: true,
        serverSide: true,
        pageLength: 50,
        ajax: route("approveRequisitionStepTwoList"),
        rowId: "id",
        columns: [{
                data: "action",
                name: "action",
                orderable: false,
                searchable: false
            },
            {
                data: "DT_RowIndex",
                name: "DT_RowIndex",
                orderable: false,
                searchable: false
            },
            {
                data: "date_formatted",
                name: "date_formatted"
            },
            {
                data: "project_name",
                name: "project_name"
            },
            {
                data: "unit_name",
                name: "unit_name"
            },
            {
                data: "tower_name",
                name: "tower_name"
            }
        ]
    });
});


// supplier payment table
$(document).ready(function () {
    $("#supplier-payment-table").DataTable({
        processing: true,
        serverSide: true,
        pageLength: 50,
        ajax: route("supplier.payment"),
        rowId: "id",
        columns: [{
                data: "action",
                name: "action",
                orderable: false,
                searchable: false
            },
            {
                data: "DT_RowIndex",
                name: "DT_RowIndex",
                orderable: false,
                searchable: false
            },
            {
                data: "budgethead",
                name: "budgethead"
            },
            {
                data: "approval_amount",
                name: "approval_amount"
            },
            {
                data: "status",
                name: "status"
            }
        ]
    });
});


// supplierpayment table
$(document).ready(function () {
    $("#supplierpayment-material-table").DataTable({
        processing: true,
        serverSide: true,
        pageLength: 50,
        ajax: route("materialvendorpayment.index"),
        rowId: "id",
        columns: [{
                data: "action",
                name: "action",
                orderable: false,
                searchable: false
            },
            {
                data: "DT_RowIndex",
                name: "DT_RowIndex",
                orderable: false,
                searchable: false
            },
            {
                data: "vendor_name",
                name: "vendor_name"
            },
            {
                data: "project_name",
                name: "project_name"
            },
            {
                data: "tower_name",
                name: "tower_name"
            },
            {
                data: "payment_no",
                name: "payment_no"
            },
            {
                data: "payment_date",
                name: "payment_date"
            },
            {
                data: "payment_amount",
                name: "payment_amount"
            }
        ]
    });
});


// cashrequisition approve table
$(document).ready(function () {
    $("#cashrequisition-approve-table").DataTable({
        processing: true,
        serverSide: true,
        pageLength: 50,
        ajax: route("cashrequisition.index.view"),
        rowId: "id",
        columns: [{
                data: "action",
                name: "action",
                orderable: false,
                searchable: false
            },
            {
                data: "DT_RowIndex",
                name: "DT_RowIndex",
                orderable: false,
                searchable: false
            },
            {
                data: "date_formatted",
                name: "date_formatted"
            },
            {
                data: "this_serial",
                name: "this_serial"
            },
            {
                data: "project.project_name",
                name: "project.project_name"
            },
            {
                data: "unit_name",
                name: "unit_name"
            },
            {
                data: "tower",
                name: "tower"
            },
            {
                data: "vendor_name",
                name: "vendor_name"
            },
            {
                data: "requisition_amount",
                name: "requisition_amount"
            },
            {
                data: "status",
                name: "status"
            }
        ]
    });
});

// cashrequisition payment table
$(document).ready(function () {
    $("#cashrequisition-payment-table").DataTable({
        processing: true,
        serverSide: true,
        pageLength: 50,
        ajax: route("supplier.payment"),
        rowId: "id",
        columns: [{
                data: "action",
                name: "action",
                orderable: false,
                searchable: false
            },
            {
                data: "DT_RowIndex",
                name: "DT_RowIndex",
                orderable: false,
                searchable: false
            },
            {
                data: "formatted_date",
                name: "formatted_date"
            },
            {
                data: "project_name",
                name: "project_name"
            },
            {
                data: "tower_name",
                name: "tower_name"
            },
            {
                data: "remarks",
                name: "remarks"
            },
            {
                data: "approved_amount",
                name: "approved_amount"
            },
            {
                data: "paid_amount",
                name: "paid_amount"
            },
        ]
    });
});


// logistics-charge table
$(document).ready(function () {
    $("#logistics-charge-table").DataTable({
        processing: true,
        serverSide: true,
        pageLength: 50,
        ajax: route("logisticCharge.index"),
        rowId: "id",
        columns: [{
                data: "action",
                name: "action",
                orderable: false,
                searchable: false
            },
            {
                data: "DT_RowIndex",
                name: "DT_RowIndex",
                orderable: false,
                searchable: false
            },
            {
                data: "project.project_name",
                name: "project.project_name"
            },
            {
                data: "general_transportation_charge",
                name: "general_transportation_charge"
            }
        ]
    });
});


// transportation bill prepare table
$(document).ready(function () {
    $("#tbp-table").DataTable({
        processing: true,
        serverSide: true,
        pageLength: 50,
        ajax: route("tbp.index"),
        rowId: "id",
        columns: [{
                data: "action",
                name: "action",
                orderable: false,
                searchable: false
            },
            {
                data: "DT_RowIndex",
                name: "DT_RowIndex",
                orderable: false,
                searchable: false
            },
            {
                data: "formatted_date",
                name: "formatted_date"
            },
            {
                data: "system_serial",
                name: "system_serial"
            },
            {
                data: "cost_head",
                name: "cost_head"
            },
            {
                data: "project.project_name",
                name: "project.project_name"
            },
            {
                data: "tower_list",
                name: "tower_list"
            },
            {
                data: "bill_amount",
                name: "bill_amount"
            },
            {
                data: "vendor.name",
                name: "vendor.name"
            },
        ]
    });
});


// transportation bill payment table
$(document).ready(function () {
    $("#tbp-payment-table").DataTable({
        processing: true,
        serverSide: true,
        pageLength: 50,
        ajax: route("tbp.pay.index"),
        rowId: "id",
        columns: [{
                data: "action",
                name: "action",
                orderable: false,
                searchable: false
            },
            {
                data: "DT_RowIndex",
                name: "DT_RowIndex",
                orderable: false,
                searchable: false
            },
            {
                data: "formatted_date",
                name: "formatted_date"
            },
            {
                data: "system_serial",
                name: "system_serial"
            },
            {
                data: "cost_head",
                name: "cost_head"
            },
            {
                data: "project.project_name",
                name: "project.project_name"
            },
            {
                data: "vendor.name",
                name: "vendor.name"
            },
            {
                data: "requisition_amount",
                name: "requisition_amount"
            },
            {
                data: "approved_amount",
                name: "approved_amount"
            }
        ]
    });
});

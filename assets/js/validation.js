//---------------------------------MEMBER SEARCH------------------------------------------

$(document).ready(function () {

    function loadData(query) {
        $.ajax({
            url: "controllers/jquery_process.php",
            type: "POST",
            datatype: "json",
            data: { "query": query },
            success: function (response) {
                //console.log(response);
                var myObj = JSON.parse(response);
                if(myObj != "No response found")
                {
                    $("#memberids").empty();
                    $("#name").val(myObj[0].memsurname + " " + myObj[0].memname);
                    //$(memberid).val(myObj[0].memid);
                    for (var i = 0; i < myObj.length; i++) {
                        $("#memberids").append("<option value='" + myObj[i].memid + "'>" + myObj[i].memsurname + " " + myObj[i].memname + "</option>");
                    }
                }
                else {
                    $("#memberids").empty();
                    $("#firstname").empty();
                    $("#lastname").empty();
                }
            },
        });
    }

    $("#membersearch").on('input', function () {
        $("#memberids").empty();
        $("#firstname").empty();
        $("#lastname").empty();
        var search = $("#membersearch").val();
        if (search.length >= 4) {
            loadData(search);
        }
    });

    //---------------------------------BRING EVENT DETAILS----------------------------------------
    /*$("#event_id").on('change',function(){
        
        //console.log("Event Selected");
        $.ajax({
            url: "controllers/jquery_process.php",
            type: "POST",
            datatype: "json",
            data: { "event_id": $("#event_id").val(),
                    "bring_batches": 1,
        },
            success: function (response) {
                var myObj = JSON.parse(response);
                if(myObj == "No records found")
                $("#participant_batch_id").prop('disabled', true);
                else
                {$("#participant_batch_id").prop('disabled', false);}
                $("#participant_batch_id").empty();
                $("#participant_batch_id").append("<option></option>");
                for (var i = 0; i < myObj.length; i++) {
                    $("#participant_batch_id").append("<option value='" + myObj[i].id + "'>" + myObj[i].batch_name + "</option>");
                }
            },
        });
    });*/

    $(document).on('change', "#event_id", function () {
        //console.log("event details");
        var form_mode = $("#form_mode").val();
        if (form_mode == "update") {
            $.ajax({
                url: "controllers/jquery_process.php",
                type: "POST",
                datatype: "json",
                data: {
                    "event_id": $("#event_id").val(),
                    "bring_event_details": 1,
                },
                success: function (response) {
                    //alert("success");
                    //console.log(response);
                    var myObj = JSON.parse(response);
                    $("#event_date").val(myObj[0].event_date);
                    $("#event_status").val(myObj[0].event_status);
                    $("#event_location").val(myObj[0].event_location);
                    $("#event_description").val(myObj[0].event_description);
                    $("#event_notes").val(myObj[0].event_notes);
                    $("#event_note").empty();
                    $("#event_note").append(myObj[0].event_notes);
                    $("#event_description").empty();
                    $("#event_description").append(myObj[0].event_description);
                    $("#event_date").empty();
                    $("#event_date").append(myObj[0].event_date);
                },
            });
        }
    });

    //---------------------------------ADD BATCH--------------------------------------------------
    count = 0;
    $('#addbatch').click(function (event) {
        console.log("adding batch");
        event.preventDefault();
        if (count >= 5) {
            alert("Maximum number of batches exceeded");
            return;
        }
        count++;
        console.log(count);
        $("#batches").append(
            '<div id="batch' + count + '">\
                    <div class = "form-group row">\
                        <div class = "col-sm-6">\
                            <label class = "control-label">Batch name</label>\
                            <input type = "text" name = "batchname'+ count + '" class = "form-control" id = "batchname' + count + '" required>\
                        </div>\
                        <div class = "col-sm-3">\
                            <label class = "control-label">Batch time</label>\
                            <input type = "time" name = "batchtime'+ count + '" class = "form-control" id = "batchtime' + count + '" required>\
                        </div>\
                        <div class = "col-sm-3">\
                        <br>\
                        <button onclick="$(\'#batch'+ count + '\').remove();return false;" class = "btn btn-danger">-</button>\
                        </div>\
                    </div>\
                </div>'
        );
    });


    //---------------------------------EVENT REGISTRATION----------------------------------------    
    $("#event_registration_form").submit(function (event) {
        console.log("Registration form submitted");
        event.preventDefault();
        $.ajax({
            url: "controllers/jquery_process.php",
            type: "POST",
            data: {
                event_id: $("#event_id").val(),
                member_id: $("#membersearch").val(),
                reg: $('input[name="reg"]:checked').val(),
                event_registration_form: 1,
            },
            success: function (response) {
                console.log(response);
                alert(response);
                location.reload();
                //$("#result").append("<div class = 'alert alert-success'>Event registration successful</div>");
            },
            error: function (response) {
                alert("failed");
            },

        });
    });
    //---------------------------------EVENT CREATION------------------------------------------

    $("#event_form").submit(function (event) {
        console.log("Ready");
        event.preventDefault();
        var formdata = {
            event_id: $("#event_id").val(),
            event_date: $("#event_date").val(),
            event_status: $("#event_status").val(),
            event_location: $("#event_location").val(),
            event_description: $("#event_description").val(),
            event_notes: $("#event_notes").val(),
            event_form: 1,
            form_mode: $("#form_mode").val(),
        };

        result = $.ajax({
            type: "POST",
            url: "controllers/jquery_process.php",
            data: formdata,
        });

        result.done(function (response) {
            //location.reload();
            alert(response);
            //$("#result").append("<div class = 'alert alert-success'>Event created successfully</div>");
            location.reload();
        });

        result.fail(function (jqXHR, textStatus, errorThrown) {
            console.log("fail");
            location.reload();
        });
    });

    //---------------------------------EVENT UPDATION------------------------------------------

    $("#event_updation_form").submit(function (event) {
        console.log("Ready");
        event.preventDefault();
        var formdata = {
            event_id: $("#uevent_id").val(),
            event_code: $("#event_code").val(),
            event_description: $("#event_description").val(),
            event_date: $("#event_date").val(),
            event_active: $("#event_active").val(),
            event_mc: $("#membersearch").val(),
            event_updation_form: 1,
            batchname1: $("#batchname1").val(),
            batchtime1: $("#batchtime1").val(),
            batchname2: $("#batchname2").val(),
            batchtime2: $("#batchtime2").val(),
            batchname3: $("#batchname3").val(),
            batchtime3: $("#batchtime3").val(),
            batchname4: $("#batchname4").val(),
            batchtime4: $("#batchtime4").val(),
            batchname5: $("#batchname5").val(),
            batchtime5: $("#batchtime5").val(),
        };

        result = $.ajax({
            type: "POST",
            url: "controllers/jquery_process.php",
            data: formdata,
        });

        result.done(function (response) {
            //location.reload();
            alert(response);
            //$("#result").append("<div class = 'alert alert-success'>Event created successfully</div>");
            location.reload();
        });

        result.fail(function (jqXHR, textStatus, errorThrown) {
            console.log("fail");
            location.reload();
        });
    });

    //----- MEMBER CREATION -----

    $("#member_creation_form").submit(function (event) {
        console.log("Ready");
        event.preventDefault();
        var formdata = {
            last_name: $("#last_name").val(),
            first_name: $("#first_name").val(),
            phone_num: $("#phone_num").val(),
            email_id: $("#email_id").val(),
            yob: $("#yob").val(),
            gender: $('input[name="gender"]:checked').val(),
            gotram: $("#gotram").val(),
            location: $("#location").val(),
            referrer_id: $("#membersearch").val(),
            blood_group: $("#blood_group").val(),
            notes: $("#notes").val(),
            member_creation_form: 1,
        };

        result = $.ajax({
            type: "POST",
            url: "controllers/jquery_process.php",
            data: formdata,
        });

        result.done(function (response) {
            //location.reload();
            alert(response);
            //$("#result").append("<div class = 'alert alert-success'>Event created successfully</div>");
            location.reload();
        });

        result.fail(function (jqXHR, textStatus, errorThrown) {
            console.log("fail");
            location.reload();
        });
    });
    //------------------------------------------------MEMBER UPDATE-------------------------------------------------------

    $("#member_update_form").submit(function (event) {
        //console.log("Ready");
        event.preventDefault();
        var membercheck = $("#MEMBER_ID").val();
        var member = $("#memberid").val();
        //console.log(membercheck+" "+member);
        if(membercheck == member);
        else { alert("Please fetch details of member and then update"); return;}
        var formdata = {
            MEMBER_ID: $("#MEMBER_ID").val(),
            Phone_Num: $("#Phone_Num").val(),
            first_name: $("#first_name").val(),
            last_name: $("#last_name").val(),
            yob: $("#yob").val(),
            father_id: $("#father_id").val(),
            mother_id: $("#mother_id").val(),
            spouse_id: $("#spouse_id").val(),
            gotra: $("#gotra").val(),
            nakshatra: $("#nakshatra").val(),
            pada: $("#pada").val(),
            smartha_purohit: $("#smartha_purohit").val(),
            veda_pandit: $("#veda_pandit").val(),
            jp: $("#jp").val(),
            blood_group: $("#blood_group").val(),
            location: $("#location").val(),
            email: $("#email").val(),
            address1: $("#address1").val(),
            address2: $("#address2").val(),
            city: $("#city").val(),
            state: $("#state").val(),
            country: $("#country").val(),
            PIN_or_ZIP: $("#PIN_or_ZIP").val(),
            member_update_form: 1,
        };

        result = $.ajax({
            type: "POST",
            url: "controllers/jquery_process.php",
            data: formdata,
        });

        result.done(function (response) {
            //location.reload();
            alert(response);
            //$("#result").append("<div class = 'alert alert-success'>Event created successfully</div>");
        });

        result.fail(function (jqXHR, textStatus, errorThrown) {
            console.log("fail");
            location.reload();
        });
    });

    //-----------------------------------------------BRING MEMBER DETAILS---------------------------------------------

    $(document).ready(function (){
        //console.log("Member Update ready");
    var form = $("#form").val();
    if (form == "member_update") {
        bring_member_details();
    }
    });

    $("#bring_member_details").on('click', function(event) 
    { 
        event.preventDefault();
        bring_member_details();
    });

    function bring_member_details() {
        var id = $("#MEMBER_ID").val();
        if (id.length >= 4) {
            $.ajax({
                url: "controllers/jquery_process.php",
                type: "POST",
                datatype: "json",
                data: {
                    "MEMBER_ID": $("#MEMBER_ID").val(),
                    "bring_member_details": 1,
                },
                success: function (response) {
                    //console.log(response);
                    var myObj = JSON.parse(response);
                    

                    $("#memberid").val(myObj[0].MEMBER_ID);
                    $("#Phone_Num").val(myObj[0].Phone_Num);
                    $("#last_name").val(myObj[0].last_name);
                    $("#first_name").val(myObj[0].first_name);
                    $("#name").val(myObj[0].last_name+" "+myObj[0].first_name);
                    $("#yob").val(myObj[0].yob);
                    $("#father_id").val(myObj[0].father_id);
                    $("#mother_id").val(myObj[0].mother_id);
                    $("#spouse_id").val(myObj[0].spouse_id);
                    $("#gotra option[value=" + myObj[0].gotra + "]").prop('selected', 'true');
                    $("#nakshatra option[value=" + myObj[0].nakshatra + "]").prop('selected', 'true');
                    $("#pada option[value=" + myObj[0].pada + "]").prop('selected', 'true');


                    $("#blood_group option[value='" + myObj[0].blood_group + "']").prop('selected', 'true');
                    $("#location").val(myObj[0].location);
                    $("#email").empty();
                    $("#email").val(myObj[0].email);
                    $("#address1").val(myObj[0].address1);
                    $("#address2").val(myObj[0].address2);
                    $("#city").val(myObj[0].city);
                    $("#state").val(myObj[0].state);
                    $("#country").val(myObj[0].country);
                    $("#PIN_or_ZIP").val(myObj[0].PIN_or_ZIP);
                    $("#smartha_purohit option[value=" + myObj[0].Smarta_Purohit + "]").prop('selected', 'true');
                    $("#veda_pandit option[value=" + myObj[0].Veda_Pandit + "]").prop('selected', 'true');
                    $("#jp option[value=" + myObj[0].JP + "]").prop('selected', 'true');
                },
            });
        }
    }


    //-------------------------------------------------------------------------------------------------------------------

    $("#from").on('input', function () {
        $.ajax({
            url: "controllers/jquery_process.php",
            type: "POST",
            datatype: "json",
            data: { "id": $("#from").val() },
            success: function (response) {
                //console.log(response);
                var myObj = JSON.parse(response);
                //console.log(myObj);
                $("#memberids").empty();
                $("#mcname").empty();
                $("#mcname").append(myObj[0].memsurname + " " + myObj[0].memname);
                $("#firstname").val(myObj[0].memname);
                $("#lastname").val(myObj[0].memsurname);
                //$(memberid).val(myObj[0].memid);
                for (var i = 0; i < myObj.length; i++) {
                    $("#memberids").append("<option value='" + myObj[i].memid + "'>" + myObj[i].memsurname + " " + myObj[i].memname + "</option>");
                }
            },
        });
    });

    //---------------------------------JP REGN------------------------------------------

    $("#jp_register_form").submit(function (event) {
        console.log("Ready");
        event.preventDefault();
        var formdata = {
            MEMBER_ID: $("#membersearch").val(),
            jpregister: $('input[name="jpregister"]:checked').val(),
            jp_register_form: 1,
        };

        result = $.ajax({
            type: "POST",
            url: "controllers/jquery_process.php",
            data: formdata,
        });

        result.done(function (response) {
            //location.reload();
            alert(response);
            //$("#result").append("<div class = 'alert alert-success'>Event created successfully</div>");
            location.reload();
        });

        result.fail(function (jqXHR, textStatus, errorThrown) {
            console.log("fail");
            location.reload();
        });
    });
    //-------------------------------------------REQUEST VAN-----------------------------------
    $("#vanid").on('input', function () {
        var van = $("#vanid").val();
        var length = van.length;
        if (length >= 4) {
            console.log(length);
            $("#CHVAN").empty();
            $("#GNVAN").empty();
            $("#CHVAN").append(van.padStart(8, '0'));
            $("#GNVAN").append(van.padStart(8, '0'));
        }
    });

    $("#generalvan").change(function () {
        if (this.checked) {
            $("#general_van_details").show();
        }
        else {
            $("#general_van_details").hide();
        }
    });

    //---------------------------------CHANGE PASSWORD------------------------------------------

    $("#change_password_form").submit(function (event) {
        console.log("Ready");

        event.preventDefault();
        var formdata = {
            MEMBER_ID: $("#MEMBER_ID").val(),
            old_password: $("#old_password").val(),
            new_password: $("#new_password").val(),
            new_password2: $("#new_password2").val(),
            change_password_form: 1,
        };

        result = $.ajax({
            type: "POST",
            url: "controllers/jquery_process.php",
            data: formdata,
        });

        result.done(function (response) {
            //location.reload();
            alert(response);
            //$("#result").append("<div class = 'alert alert-success'>Event created successfully</div>");
            location.reload();
        });

        result.fail(function (jqXHR, textStatus, errorThrown) {
            console.log("fail");
            location.reload();
        });
    });
    //------------------------------------------EXPENSE CREATION-----------------------------------------------

    $(".soft_copy_voucher, .voucher_signed").on('change', function () {
        if ($(".soft_copy_voucher").is(':checked')) {
            $("#soft_copy_voucher_checked").empty();
            $("#soft_copy_voucher_checked").append("<p class = 'text-success'>Uploaded</p>");
        }
        else $("#soft_copy_voucher_checked").empty();

        if ($(".voucher_signed").is(':checked')) {
            $("#voucher_signed_checked").empty();
            $("#voucher_signed_checked").append("<p class = 'text-success'>Yes</p>");
        }
        else $("#voucher_signed_checked").empty();
    });

    $("#expense_type").change(function () {
        var expense_type = $(this).val();
        if (expense_type == "KIND")
        {
             $("#payment_status option[value='paid']").prop('selected', 'true');
             if($("#utr_number").val() == "")
             {
                $("#utr_number").val("KIND");
                $("#payment_confirmation_id").val("KIND");
             }
        }
        else if(expense_type == "CASH")
        {
            $("#payment_status option[value='pending']").prop('selected', 'true');
            if($("#utr_number").val() == "")
            {
                $("#utr_number").val("CASH");
                $("#payment_confirmation_id").val("CASH");
            }
        }
        else $("#payment_status option[value='pending']").prop('selected', 'true');
    });

    $("#category").on('change', async () => {
        const res = await bring_subcat();
        var mySub = JSON.parse(res);
        // console.log(mySub);
        $("#sub_category").empty();
        for (var i = 0; i < mySub.length; i++) {
            $("#sub_category").append("<option value='" + mySub[i].Sub_Category_ID + "'>"
            + mySub[i].Sub_Category_ID + " " + mySub[i].Sub_Category_Desc + "</option>");
        }
    });

    function bring_subcat() {
        return $.ajax({
            url: "controllers/jquery_process.php",
            type: "POST",
            datatype: "json",
            data: {
                "category_id": $("#category").val(),
                'bring_subcategory': 1,
            }
            // ,success: function (response) {
            //     var mySub = JSON.parse(response);
            //     console.log(mySub);
            //     $("#sub_category").empty();
            //     for (var i = 0; i < mySub.length; i++) {
            //         $("#sub_category").append("<option value='" + mySub[i].Sub_Category_ID + "'>"
            //             + mySub[i].Sub_Category_ID + " " + mySub[i].Sub_Category_Desc + "</option>");
            //     }
            // },
        });
        // console.log('Getting subcat end');
    }

    $("#payment_date").change(function () {
        var payment_date = $("#payment_date").val();
        var transaction_date = $("#transaction_date").val();
        if (payment_date < transaction_date) {
            $("#date_warning").empty();
            $("#date_warning").append("⚠️Payment date selected before transaction date");
        }
        else $("#date_warning").empty();

    });
    $("#event").change(function () {
        $("#transaction_date").val($(this).find(':selected').data('date'));
        if ($("#form_mode").val() == "create") {
            $("#voucher_num").val($(this).find(':selected').data('voucher'));
        }
    });
    
    $("#payee").on('change', bring_payee_details);
    function bring_payee_details() {
        $.ajax({
            url: "controllers/jquery_process.php",
            type: "POST",
            datatype: "json",
            data: {
                "payee_id": $("#payee").val(),
                'bank_reg': 1,
            },
            success: function (response) {
                //console.log(response);
                var myObj = JSON.parse(response);
                if (myObj[0].Payee_Acnt_Num == "NONE")
                    $("#brc").prop('disabled', true);
                else { $("#brc").prop('disabled', false); }
                $("#payee_name").empty();
                $("#payee_name").append(myObj[0].Payee_Name);
                var payee = $("#payee").val();
                $("#nick_name").val("P"+payee.padStart(5, '0') +" "+ myObj[0].Payee_Name);
                $("#brc").empty();

                if($("#payee_accnt_form").length) {
                    $("#payee_accnt_form")[0].reset();
                    $("#mode").val("create");
                }


                //Add rows
                if($("table#payee_account_table").length) {
                    var table = document.getElementById("payee_account_table");
                    var tbody = table.getElementsByTagName('tbody')[0];
                    tbody.innerHTML = '';

                    var table = document.getElementById("payee_account_table").getElementsByTagName('tbody')[0];

                    for (var i = 0; i < myObj.length; i++) {
                    
                        var row = table.insertRow(table.rows.length); // Insert a row at the end of the table

                        var cell1 = row.insertCell(0); // Insert a cell in the new row at index 0
                        cell1.innerHTML = myObj[i].Payee_Acnt_Num; // Set the content of cell 1

                        var cell2 = row.insertCell(1); // Insert a cell in the new row at index 1
                        cell2.innerHTML = myObj[i].Bank_Name; // Set the content of cell 2
                        
                        var cell3 = row.insertCell(2); 
                        cell3.innerHTML = myObj[i].IFSC_CODE; // Set the content of cell 3
                        
                        var cell3 = row.insertCell(3); 
                        cell3.innerHTML = myObj[i].Bank_Registration_Code; // Set the content of cell 3

                        var cell3 = row.insertCell(4);  // Insert a cell in the new row at index 2
                        cell3.innerHTML = myObj[i].Account_Status;

                        var cell3 = row.insertCell(5);  // Insert a cell in the new row at index 2
                        cell3.innerHTML = "<button id='"+ myObj[i].sno +"' class='payeeaccountedit btn btn-primary'>Edit</button>";
                    }
                }

                //end add rows
                
                //$("#brc").append("<option>Choose one</option>");
                for (var i = 0; i < myObj.length; i++) {
                    $("#brc").append("<option value='" + myObj[i].Bank_Registration_Code + "'>"
                        + "IFSC " + myObj[i].IFSC_CODE + " Acc " + myObj[i].Payee_Acnt_Num + " " + myObj[i].Name_In_Account + "</option>");
                }
            },
        });
    }

    $("#expense_form").submit(function (event) {
        event.preventDefault();
        var scv, vs, pd;
        if (!$("#payment_date").val()) pd = '2099-12-31';
        else pd = $("#payment_date").val();
        if ($('#soft_copy_voucher').is(':checked')) scv = 'Y';
        else scv = 'N';
        if ($("#voucher_signed").is(':checked')) vs = 'Y';
        else vs = 'N';
        let expense_type = $("#expense_type").val();
        var formdata = {
            event: $("#event").val(),
            transaction_date: $("#transaction_date").val(),
            voucher_num: $("#voucher_num").val(),
            payee: $("#payee").val(),
            amount: $("#amount").val(),
            expense_type: $("#expense_type").val(),
            category: $("#category").val(),
            sub_category: $("#sub_category").val(),
            expense_details: $("#expense_details").val(),
            bill_status: $("#bill_status").val(),
            soft_copy_bill: $("#soft_copy_bill").val(),
            soft_copy_voucher: scv,
            voucher_signed: vs,
            bill_number: $("#bill_number").val(),
            brc: $("#brc").val(),
            payment_intimation_url: ($("#payment_intimation_url").val() === undefined ? "" : $("#payment_intimation_url").val()),
            payment_date: (expense_type == "KIND" ? $("#transaction_date").val() : pd),
            payment_status: (expense_type == "KIND" ? "paid" : $("#payment_status").val()),
            payment_confirmation_id: (expense_type == "KIND" ? "KIND" : $("#payment_confirmation_id").val()),
            utr_number: (expense_type == "KIND" ? "KIND" : $("#utr_number").val()),
            notes: $("#notes").val(),
            expense_form: 1,
            form_mode: $("#form_mode").val(),
        };

        result = $.ajax({
            type: "POST",
            url: "controllers/jquery_process.php",
            data: formdata,
        });

        result.done(function (response) {
            //location.reload();
            alert(response);
            //$("#result").append("<div class = 'alert alert-success'>Event created successfully</div>");
        });

        result.fail(function (jqXHR, textStatus, errorThrown) {
            console.log("fail");

        });

    });

    $("#expense_edit").on('click', function (event) {
        if (!$("#event").val() || !$("#voucher_num").val()) {
            alert("Please fill out event and voucher number fields");
            return;
        }
        event.preventDefault();
        $.ajax({
            url: "controllers/jquery_process.php",
            type: "POST",
            datatype: "json",
            data: {
                "event": $("#event").val(),
                "voucher_num": $("#voucher_num").val(),
                "voucher_details": 1,
            },
            success: async function (response) {
                //alert("success");
                //console.log(response);
                var myObj = JSON.parse(response);
                if (myObj == "No records found") {
                    alert("Invalid voucher details");
                    return;
                }
                $("#payee").val(myObj[0].payee);
                bring_payee_details();
                $("#amount").val(myObj[0].amount);
                $("#expense_type").append("<option value='" + myObj[0].expense_type + "' selected>" + myObj[0].expense_type + "</option>");
                $("#category option[value=" + myObj[0].category_id + "]").prop('selected', 'true');
                console.log(myObj[0].subcategory_id);
                const res = await bring_subcat();
                // console.log(res);
                
                var mySub = JSON.parse(res);
                console.log(mySub);
                $("#sub_category").empty();
                for (var i = 0; i < mySub.length; i++) {
                    $("#sub_category").append("<option value='" + mySub[i].Sub_Category_ID + "'>"
                        + mySub[i].Sub_Category_ID + " " + mySub[i].Sub_Category_Desc + "</option>");
                }

                $("#sub_category option[value=" + myObj[0].subcategory_id + "]").prop('selected', 'true');
                $("#bill_status option[value=" + myObj[0].bill_status + "]").prop('selected', 'true');
                $("#bill_number").val(myObj[0].bill_number);
                if (myObj[0].soft_copy_voucher == 'Y') $("#soft_copy_voucher").attr("checked", true); else $("#soft_copy_voucher").attr("checked", false);
                $("#soft_copy_bill").val(myObj[0].soft_copy_bill);
                if (myObj[0].voucher_signed == 'Y') $("#voucher_signed").attr("checked", true); else $("#voucher_signed").attr("checked", false);
                // $("#brc").append("<option value='" + myObj[0].brc + "' selected>" + myObj[0].brc + "</option>")
                $("#payment_intimation_url").val(myObj[0].payment_intimation_url);
                $("#expense_details").val(myObj[0].expense_details);
                $("#payment_date").val(myObj[0].payment_date);
                //$("#payment_status").append("<option value='" + myObj[0].payment_status + "' selected>" + myObj[0].payment_status + "</option>");
                $("#payment_status option[value=" + myObj[0].payment_status + "]").prop('selected', 'true');
                $("#payment_confirmation_id").val(myObj[0].payment_confirmation_id);
                $("#utr_number").val(myObj[0].utr_number);
                $("#notes").val(myObj[0].notes);
                if(myObj[0].payment_status == "paid" || myObj[0].payment_status == "in_process" || myObj[0].payment_status == "void")
                $(':input[type="submit"]').prop('disabled', true);
                else $(':input[type="submit"]').prop('disabled', false);
            },
        });

    });

    //---------------------------------------------------------------------------------------------------------
    //--------------------------------------------EXPENSE UPDATION---------------------------------------------


    //---------------------------------------------------------------------------------------------------------
    //------------------------------------------------LOGIN----------------------------------------------------

    $("#login_form").submit(function (event) {
        $("#message").empty();
        event.preventDefault();
        var formdata = {
            MEMBER_ID: $("#MEMBER_ID").val(),
            password: $("#password").val(),
            login_form: 1,
        };

        result = $.ajax({
            type: "POST",
            url: "controllers/jquery_process.php",
            datatype: "json",
            data: formdata,
        });

        result.done(function (response) {
            var myObj = JSON.parse(response);
            if (myObj == "Invalid Username or Password!")
                $("#message").append("<p class='alert alert-danger'>" + myObj + "</p>");
            else
                location.assign("home");
        });

        result.fail(function (jqXHR, textStatus, errorThrown) {
            console.log("fail");
        });
    });
    //---------------------------------------------------------------------------------------------------------
    $("#vanid").on('input', function () {
        var van = $("#vanid").val();
        if (van.length >= 4) {
            $("#num").val(van);
        }
    });

    $("#select_event_id").on('change', function () {

        //console.log("Event Selected");
        $.ajax({
            url: "controllers/jquery_process.php",
            type: "POST",
            datatype: "json",
            data: {
                "event_id": $("#select_event_id").val(),
                "bring_voucher_details": 1,
            },
            success: function (response) {
                var myObj = JSON.parse(response);
                if (myObj == "No records found")
                    $("#participant_batch_id").prop('disabled', true);
                else { $("#participant_batch_id").prop('disabled', false); }
                $("#participant_batch_id").empty();
                $("#participant_batch_id").append("<option></option>");
                for (var i = 0; i < myObj.length; i++) {
                    $("#participant_batch_id").append("<option value='" + myObj[i].id + "'>" + myObj[i].batch_name + "</option>");
                }
            },
        });
    });

    /*----------------------------------EVENT REPORT-------------------------------*/
    $("#registered").on('change', registeredoptions);
    $("#team").on('change', registeredoptions);

    function registeredoptions() {
        console.log($("#registered").val());
        var team = $("#team").val();
        var registered = $("#registered").val();
        if(registered == "N" && team == " ")
        {
            $("#attended").empty();
            $("#attended").append("<option value='Y'>Attended - 1</option>");
            //$("#attended").append("<option value='N' selected>Not Attended - 0</option>");
        }
            else
            {
                $("#attended").empty();
                $("#attended").append("<option value='Y'>Attended - 1</option>");
                $("#attended").append("<option value='N' selected>Not Attended - 0</option>");
            }

    }
    
    $("#event_report_form").submit(function (event) {
        $("#message").empty();
        var event_date = $("#report_event_id").find(':selected').data('date');
        event.preventDefault();
        var formdata = {
            event_id: $("#report_event_id").val(),
            event_date: event_date,
            team: $("#team").val(),
            registered: $("#registered").val(),
            attended: $("#attended").val(),
            gender: $("#gender").val(),
            age_min: $("#age_min").val(),
            age_max: $("#age_max").val(),
            event_report_form: 1,
        };

        result = $.ajax({
            type: "POST",
            url: "controllers/jquery_process.php",
            datatype: "json",
            data: formdata,
        });

        result.done(function (response) {
            //console.log(response);
            //console.log(myObj);
            $("#result").empty();
            if (response == "No records found")
                $("#result").html("No records found.");
            else {
                $("#result").html(response);
            }
        });

        result.fail(function (jqXHR, textStatus, errorThrown) {
            console.log("fail");
        });
    });

    /*-------------------------------- --EVENT REPORT END---------------------------*/
    /*-----------------------------------STATEMENT EDIT START---------------------------*/
    $("#statement_edit_form").submit(function (event) {
        event.preventDefault();
        const srno = [];
        const van = [];
        const notes = [];
        const trdate = [];
        for (i = 0; i < $("#count").val(); i++) {
            srno[i] = $("#srno" + i).val();
            van[i] = $("#id" + i).val();
            notes[i] = $("#notes" + i).val();
            trdate[i] = $("#trdate" + i).val();
        }

        var formdata = {
            srno: srno,
            van: van,
            notes: notes,
            trdate: trdate,
            statement_edit_form: 1,
        };

        result = $.ajax({
            type: "POST",
            url: "controllers/jquery_process.php",
            datatype: "json",
            data: formdata,
        });

        result.done(function (response) {
            alert(response);
        });

        result.fail(function (jqXHR, textStatus, errorThrown) {
            console.log("fail");
        });
    });



    $("#process").click(function (event) {
        location.assign("contributionprocessing");
    });

    /*-----------------------------------STATEMENT EDIT END------------------------------*/
    /*-----------------------------------CONTRIBUTION PROCESSING START-------------------*/

    $("#contribution_processing_form").submit(function (event) {
        event.preventDefault();
        answer = confirm("Are you sure you want to save the following data? (PLEASE CHECK DATA BEFORE SAVING).");
        if (answer) {
            const event = [];
            const SrNo = [];
            for (i = 0; i < $("#count").val(); i++) {
                event[i] = $("#event" + i).val();
                SrNo[i] = $("#SrNo" + i).val();
            }

            var formdata = {
                event: event,
                SrNo: SrNo,
                contribution_processing_form: 1,
            };

            result = $.ajax({
                type: "POST",
                url: "controllers/jquery_process.php",
                datatype: "json",
                data: formdata,
            });

            result.done(function (response) {
                alert(response);
            });

            result.fail(function (jqXHR, textStatus, errorThrown) {
                console.log("fail");
            });
        }
        else
            return;
    });

    /*-----------------------------------CONTRIBUTION PROCESSING END---------------------*/
    /*-----------------------------------CSV GENERATION START----------------------------*/

    $("#csv_receipt_generation_form").submit(function (event) {
        event.preventDefault();
        var formdata = {
            from_date: $("#from_date").val(),
            to_date: $("#to_date").val(),
            csv_receipt_generation_form: 1,
        };

        result = $.ajax({
            type: "POST",
            url: "controllers/jquery_process.php",
            datatype: "json",
            data: formdata,
        });

        result.done(function (response) {
            $("#result").html(response);
        });

        result.fail(function (jqXHR, textStatus, errorThrown) {
            console.log("fail");
        });
    });
    /*-----------------------------------CSV GENERATION END-------------------------------*/
    /*-----------------------------------EMAIL SEND START---------------------------------*/

    $("#email_nbv_header").submit(function (event) {
        event.preventDefault();
        console.log("email_nbv_header");
        var formdata = {
            header_id: $("#header_id").val(),
            transaction_code: $("#transaction_code").val(),
            email_nbv_header: 1,
        };

        result = $.ajax({
            type: "POST",
            url: "controllers/jquery_process.php",
            datatype: "json",
            data: formdata,
        });

        result.done(function (response) {
            $("#result").html(response);
        });

        result.fail(function (jqXHR, textStatus, errorThrown) {
            console.log("fail");
        });
    });

    /*-----------------------------------EMAIL SEND END-----------------------------------*/


    $("#bug_edit_form").submit(function (event) {
        event.preventDefault();
        console.log("bug_edit_form");

        const id = [];
        const category = [];
        const description = [];
        const status = [];
        const header_uid = [];
        const resolution = [];
        const resolved_by = [];
        const sequence = [];

        for (i = 0; i < $("#count").val(); i++) {
            id[i] = $("#id" + i).val();
            category[i] = $("#category" + i).val();
            description[i] = $("#description" + i).val();
            status[i] = $("#status" + i).val();
            header_uid[i] = $("#header_uid" + i).val();
            resolution[i] = $("#resolution" + i).val();
            resolved_by[i] = $("#resolved_by" + i).val();
            sequence[i] = $("#sequence" + i).val();
        }

        var formdata = {
            id: id,
            category: category,
            description: description,
            status: status,
            header_uid: header_uid,
            resolution: resolution,
            resolved_by: resolved_by,
            sequence: sequence,
            bug_edit_form: 1,
        };

        result = $.ajax({
            type: "POST",
            url: "controllers/jquery_process.php",
            datatype: "json",
            data: formdata,
        });

        result.done(function (response) {
            alert(response);
            location.reload();
        });

        result.fail(function (jqXHR, textStatus, errorThrown) {
            console.log("fail");
        });
    });

    $("#ticket_no_form").submit(function (event) {
        event.preventDefault();
        console.log("ticket_no_form");
        var formdata = {
            ticket: $("#ticket").val(),
            ticket_no_form: 1,
        };

        result = $.ajax({
            type: "POST",
            url: "controllers/jquery_process.php",
            datatype: "json",
            data: formdata,
        });

        result.done(function (response) {
            alert(response);
            location.reload();
        });

        result.fail(function (jqXHR, textStatus, errorThrown) {
            console.log("fail");
        });
    });

    $("#permissions_form").submit(function (event) {
        event.preventDefault();
        console.log("permissions form");
        var sum = 0;
        $('input[name="permission"]:checked').each(function () {
            sum += parseInt(this.value);
        });
        var formdata = {
            MEMBER_ID: $("#membersearch").val(),
            permission: sum,
            permissions_form: 1,
        };

        result = $.ajax({
            type: "POST",
            url: "controllers/jquery_process.php",
            datatype: "json",
            data: formdata,
        });

        result.done(function (response) {
            alert(response);
            //location.reload();
        });

        result.fail(function (jqXHR, textStatus, errorThrown) {
            console.log("fail");
        });
    });

    $("#bring_permissions").on('click', function (event) {
        event.preventDefault();
        console.log("bringing permissions");
        $.ajax({
            url: "controllers/jquery_process.php",
            type: "POST",
            datatype: "json",
            data: {
                "MEMBER_ID": $("#membersearch").val(),
                "bring_permissions": 1,
            },
            success: function (response) {
                var myObj = JSON.parse(response);
                console.log(myObj);
                if (myObj == "No permissions set for this ID.\nPlease set permissions for this ID and click on update."
                    || myObj == "Invalid member") {
                    for (i = 0; i < 62; i++) //64 bits counts up to 63 using last bit for sign(+,-). So check till 62nd bit
                        $("#permission" + i).prop("checked", false);
                    alert(myObj);
                }
                else {
                    var permissions = parseInt(myObj);
                    for (i = 0; i < 62; i++) //64 bits counts up to 63 using last bit for sign(+,-). So check till 62nd bit
                    {
                        if (permissions & (2 ** i))
                            $("#permission" + i).prop("checked", true);
                        else
                            $("#permission" + i).prop("checked", false);
                    }
                }
            },
        });
    });
    
    // default permissions for T100
    $("#permission20").change(function () {
        if (this.checked) {
            $("#permission5").prop("checked", true);
            $("#permission6").prop("checked", true);
            $("#permission10").prop("checked", true);
            $("#permission13").prop("checked", true);
            $("#permission17").prop("checked", true);
        }
        else {
            $("#permission5").prop("checked", false);
            $("#permission6").prop("checked", false);
            $("#permission10").prop("checked", false);
            $("#permission13").prop("checked", false);
            $("#permission17").prop("checked", false);
        }
    });

    /** ----------------------------------------------EVENT ATTENDANCE--------------------------------------------- */

    $("#event_attendance_form").on('click', function (event) {
        event.preventDefault();
        if($("#bring_member_details").val() == "Verify") return;
        var formdata = {
            MEMBER_ID: $("#MEMBER_ID").val(),
            event_id: $("#attendance_event_id").val(),
            event_attendance_form: 1,
        };

        result = $.ajax({
            type: "POST",
            url: "controllers/jquery_process.php",
            datatype: "json",
            data: formdata,
        });

        result.done(function (response) {
            alert(response);
            $("#event_attendance_form").trigger("reset");
        });

        result.fail(function (jqXHR, textStatus, errorThrown) {
            console.log("fail");
        });
    });

    //------------------------------------------MEMBER REPORT FORM---------------------------------------------------

    $("#member_report_form").submit(function (event) {
        event.preventDefault();
        var formdata = {
            member_id: $("#membersearch").val(),
            report: $('input[name="report"]:checked').val(),
            member_report_form: 1,
        };

        result = $.ajax({
            type: "POST",
            url: "controllers/jquery_process.php",
            datatype: "json",
            data: formdata,
        });

        result.done(function (response) {
            $("#result").empty();
            if (response == "No records found")
                $("#result").html("No records found.");
            else {
                $("#result").html(response);
            }
        });

        result.fail(function (jqXHR, textStatus, errorThrown) {
            console.log("fail");
        });
    });

    //---------------------------------------------------------------------------------------------------------------

    //------------------------------------------EVENT EXPENDITURE REPORT FORM---------------------------------------

    $("#event_exp_report_form").submit(function (event) {
        event.preventDefault();
        var formdata = {
            event_id: $("#exp_event").val(),
            report: $('input[name="report"]:checked').val(),
            event_exp_report_form: 1,
        };

        result = $.ajax({
            type: "POST",
            url: "controllers/jquery_process.php",
            datatype: "json",
            data: formdata,
        });

        result.done(function (response) {
            $("#result").empty();
            if (response == "No records found")
                $("#result").html("No records found.");
            else {
                $("#result").html(response);
            }
        });

        result.fail(function (jqXHR, textStatus, errorThrown) {
            console.log("fail");
        });
    });
    //---------------------------------------------------------------------------------------------------------------
    //------------------------------------------PASSWORD RESET FORM---------------------------------------

    $("#password_reset_form").submit(function (event) {
        event.preventDefault();
        var name = $("#name").val();
        var answer = confirm("Do you wish to reset password for "+$("#membersearch").val()+" "+name+"?");
        if(answer);
        else return;

        $("#submit").prop('disabled', true);

        var formdata = {
            member_id: $("#membersearch").val(),
            password_reset_form: 1,
        };

        result = $.ajax({
            type: "POST",
            url: "controllers/jquery_process.php",
            datatype: "json",
            data: formdata,
        });

        result.done(function (response) {
            $("#result").html(response);
        });

        result.fail(function (jqXHR, textStatus, errorThrown) {
            console.log("fail");
        });
    });
    //---------------------------------------------------------------------------------------------------------------

    $("#payee_form").submit(function (event) {
        //console.log("Ready");
        event.preventDefault();
        var membercheck = $("#MEMBER_ID").val();
        var member = $("#memberid").val();
        if(membercheck)
        {
            if(membercheck == member);
            else { alert("Please fetch details of member and then update"); return;}
        }
        var formdata = {
            MEMBER_ID: $("#MEMBER_ID").val(),
            email: $("#email").val(),
            Phone_Num: $("#Phone_Num").val(),
            name: $("#name").val(),
            link: $("#link").val(),
            govtid_type: $("#govtid_type").val(),
            govtid: $("#govtid").val(),
            address1: $("#address1").val(),
            address2: $("#address2").val(),
            city: $("#city").val(),
            state: $("#state").val(),
            country: $("#country").val(),
            mode: $("#mode").val(),
            payee_form: 1,
        };

        result = $.ajax({
            type: "POST",
            url: "controllers/jquery_process.php",
            data: formdata,
        });

        result.done(function (response) {
            location.reload();
            alert(response);
            $("#mode").val("create");
            //$("#result").append("<div class = 'alert alert-success'>Event created successfully</div>");
        });

        result.fail(function (jqXHR, textStatus, errorThrown) {
            console.log("fail");
            location.reload();
        });
    });

    $("#payee_accnt_form").submit(function (event) {
        event.preventDefault();

        var formdata = {
            payee: $("#payee").val(),
            accnt_num: $("#accnt_num").val(),
            name_in_accnt: $("#name_in_accnt").val(),
            nick_name: $("#nick_name").val(),
            bank_name: $("#bank_name").val(),
            bank_branch: $("#bank_branch").val(),
            ifsc: $("#ifsc").val(),
            link: $("#link").val(),
            barc: $("#barc").val(),
            account_status: $("#account_status").val(),
            mode: $("#mode").val(),
            payee_accnt_form: 1,
        };

        result = $.ajax({
            type: "POST",
            url: "controllers/jquery_process.php",
            data: formdata,
        });

        result.done(function (response) {
            //location.reload();
            alert(response);
            //$("#result").append("<div class = 'alert alert-success'>Event created successfully</div>");
        });

        result.fail(function (jqXHR, textStatus, errorThrown) {
            console.log("fail");
            location.reload();
        });
    });

    $("#editmembercontribution").on('click', function(event){
        event.preventDefault();
        //console.log("Edit clicked")
        var number = $('input[name="membersno"]:checked').val();
        if(!number) { alert("Select a transaction to edit"); return; }
        var memberid = $("#memberid"+number).val();
        var event_id = $("#event_id"+number).val();
        var amount = $("#amount"+number).val();
        var note = $("#note"+number).val();
        $("#sno").val(number);
        $("#member").val(memberid);
        $("#event_id").val(event_id);
        $("#amount").val(amount);
        $("#note").val(note);
    });

    $("#calc_total").on('click', function(event){
        // event.preventDefault();
        console.log('calc_total');

        let start = $("#start").val();
        let end = $("#end").val();
        let sum = 0;

        if(start < 0 || end < 0) {alert("Start and ending serial number must be greater than 0"); return;}

        //console.log("Edit clicked")

        for(let i=start; i<=end; i++) {
            let amount = $("#seqno"+i).val();
            sum += +amount;
        }
        console.log('sum',sum);
        $("#sum").empty();
        $("#sum").append(sum);
    });

    $("#calc_denom").on('click', function(event){
       let denocount = $("#denocount").val();
       let total_amount = 0;
       let event_id = $("#curr_event_id").val();

       let qty_arr = [];
        for(let i = 0; i < denocount ; i++) {
            let deno = +$(`#deno${i}`).val();
            let qty = +$(`#count${i}`).val();
            qty_arr.push(qty);
            $(`#amount${i}`).val(deno*qty);
            total_amount += +(deno*qty);
        }
        $("#denototal").empty();
        $("#denototal").append("Total: " + total_amount);

        if(+$('#amount_total').val() == total_amount)$("#denototal").append(" matched."); 
        else if(+$('#amount_total').val() > total_amount) $("#denototal").append(" cash box shows lesser amount");
        else if(+$('#amount_total').val() < total_amount) $("#denototal").append(" cash box shows higher amount");

        var formdata = {
            qty_arr: qty_arr,
            event_id: event_id,
            save_denomination: 1,
        };

        result = $.ajax({
            type: "POST",
            url: "controllers/jquery_process.php",
            data: formdata,
        });

        result.done(function (response) {
            // location.reload();
            // alert(response);
        });

        result.fail(function (jqXHR, textStatus, errorThrown) {
            console.log("fail");
            location.reload();
        });

    });


    $("#deletemembercontribution").on('click', function (event) {
        event.preventDefault();

        var number = $('input[name="membersno"]:checked').val();
        if(!number) { alert("Select a transaction to delete"); return; }
        answer = confirm("Are you sure you want to delete contribution number : " + number + "?");
        if (answer) {
            var formdata = {
                sno: number,
                deletemembercontribution : 1,
            };

            result = $.ajax({
                type: "POST",
                url: "controllers/jquery_process.php",
                data: formdata,
            });

            result.done(function (response) {
                location.reload();
                alert(response);
            });

            result.fail(function (jqXHR, textStatus, errorThrown) {
                console.log("fail");
                location.reload();
            });
        }
        else return;
    });

    $("#cash_collection_form").submit(function (event) {
        event.preventDefault();
        $("#cashsubmit").prop('disabled', true);

        var formdata = {
            sno: $("#sno").val(),
            memberid: $("#member").val(),
            event_id: $("#event_id").val(),
            amount: $("#amount").val(),
            note: $("#note").val(),
            cash_collection_form: 1,
        };

        result = $.ajax({
            type: "POST",
            url: "controllers/jquery_process.php",
            data: formdata,
        });

        result.done(function (response) {
            $("#cash_collection_form").trigger("reset");
            alert(response);
            location.reload();
        });

        result.fail(function (jqXHR, textStatus, errorThrown) {
            console.log("fail");
            location.reload();
        });
    });

    $("#cash_record_generate").on('click', function () {
        var formdata = {
            cash_record_generate : 1,
        };

        result = $.ajax({
            type: "POST",
            url: "controllers/jquery_process.php",
            data: formdata,
        });

        result.done(function (response) {
            location.reload();
            alert(response);
        });

        result.fail(function (jqXHR, textStatus, errorThrown) {
            console.log("fail");
            location.reload();
        });
    });

    $("#cash_record_generate").prop('disabled', true);

    $("#preview").on('click', function () {
        console.log('Preview clicked');
        var formdata = {
            preview : 1,
        };

        result = $.ajax({
            type: "POST",
            url: "controllers/jquery_process.php",
            data: formdata,
        });

        result.done(function (response) {
            // location.reload();
            $('#result').empty();
            $('#result').append(response);
            $("#cash_record_generate").prop('disabled', false);
        });

        result.fail(function (jqXHR, textStatus, errorThrown) {
            console.log("fail");
            location.reload();
        });
    });

    $("#link_utr_form").submit(function (event) {
        event.preventDefault();
        var snos = [];
        var i = 0;
        $('input[name="membersno"]:checked').each(function() {
            //console.log(this.value);
            snos[i] = this.value;
            i++;
         });

        
        var formdata = {
            snos: snos,
            utr: $("#utr").val(),
            link_utr_form: 1,
        };

        result = $.ajax({
            type: "POST",
            url: "controllers/jquery_process.php",
            data: formdata,
        });

        result.done(function (response) {
            location.reload();
            alert(response);
        });

        result.fail(function (jqXHR, textStatus, errorThrown) {
            console.log("fail");
            location.reload();
        });
    });

    $("#utrsave").on('click', function(event) {
        event.preventDefault();
        var utr = $('input[name="utr"]:checked').val();
        if(!utr) { alert("Select a record to edit"); return; }
        var newutr = $("#utr"+utr).val();
        if(newutr != utr)
        {
            var formdata = {
                utr: utr,
                newutr: newutr,
                utrsave: 1,
            };
    
            result = $.ajax({
                type: "POST",
                url: "controllers/jquery_process.php",
                data: formdata,
            });
    
            result.done(function (response) {
                location.reload();
                alert(response);
            });
    
            result.fail(function (jqXHR, textStatus, errorThrown) {
                console.log("fail");
                location.reload();
            });
        }
        
    });

    $("#utrdelete").on('click', function(event) {
        event.preventDefault();
        var utr = $('input[name="utr"]:checked').val();
        if(!utr) { alert("Select a record to delete"); return; }

            var formdata = {
                utr: utr,
                utrdelete: 1,
            };
    
            result = $.ajax({
                type: "POST",
                url: "controllers/jquery_process.php",
                data: formdata,
            });
    
            result.done(function (response) {
                location.reload();
                alert(response);
            });
    
            result.fail(function (jqXHR, textStatus, errorThrown) {
                console.log("fail");
                location.reload();
            });
        
    });

    $("#generatereceipt").on('click', function(event) {
        event.preventDefault();
        var utr = $('input[name="utr"]:checked').val();
        if(!utr) { alert("Select a record to reconcile"); return; }

            var formdata = {
                utr: utr,
                generatereceipt: 1,
            };
    
            result = $.ajax({
                type: "POST",
                url: "controllers/jquery_process.php",
                data: formdata,
            });
    
            result.done(function (response) {
                location.reload();
                alert(response);
            });
    
            result.fail(function (jqXHR, textStatus, errorThrown) {
                console.log("fail");
                location.reload();
            });
        
    });

    $("#bring_expense_details").submit(function (event) {
        $("#message").empty();
        event.preventDefault();
        var formdata = {
            event_id: $("#event_id").val(),
            bring_expense_details: 1,
        };

        result = $.ajax({
            type: "POST",
            url: "controllers/jquery_process.php",
            datatype: "json",
            data: formdata,
        });

        result.done(function (response) {
            $("#result").empty();
            if (response == "No records found")
                $("#result").html("No records found.");
            else {
                $("#result").html(response);
            }
        });

        result.fail(function (jqXHR, textStatus, errorThrown) {
            console.log("fail");
        });
    });

    $("#in_process").on('click', function (event) {
        event.preventDefault();
        $.ajax({
            url: "controllers/jquery_process.php",
            type: "POST",
            datatype: "json",
            data: {
                "in_process": 1,
            },
            success: function (response) {
                alert(response);
                location.reload();
            },
        });

    });

    $("#reverse_in_process").on('click', function (event) {
        event.preventDefault();
        $.ajax({
            url: "controllers/jquery_process.php",
            type: "POST",
            datatype: "json",
            data: {
                "reverse_in_process": 1,
            },
            success: function (response) {
                alert(response);
                location.reload();
            },
        });

    });
    

    $("#fin_sum_form").on('submit', function (event) {
        event.preventDefault();
        let A = Number($("#openingBalance").val()); //A
        let a = Number($("#corpusFund").val()); //a
        let B = Number($("#contributions").val()); //B
        let kind_expenses = Number($("#kind_expenses").val());
        let kind_contribution = Number($("#kind_contribution").val());
        let C = kind_expenses-kind_contribution; //C
        let E = Number($("#sib_interest").val());
        let b = Number($("#bank_charges").val()); //b
        let c = Number($("#expenses_paid").val()); //c
        let pending_payments = Number($("#pending_payments").val());
        let reserves = Number($("#reserves").val());
        // let D = Number($("#contribution_not_uploaded").val()); //D
        let bank_balance = Number($("#bank_balance").val());

        let D = $("#contribution_not_uploaded").val();
        D = D.replace(" ",",");
        let myArray = D.split(",");
        let sum = 0;
        for(let i = 0; i <myArray.length; i++) sum+= Number(myArray[i]);


        // Expected Balance = A+B+C+D-a-b-c
        // Display (BankBalance-Expected Balance)

        let expected_balance = A+B+sum+E-a-b-c;
        let display = bank_balance-expected_balance;
        display = display.toFixed(2);
        $("#e_bank_balance").val(expected_balance.toFixed(2));
        $("#display").val(display);
        $("#future_exp").val(bank_balance-(reserves+pending_payments));
    });

    $("#search_button").on('click', function (event) {
        // console.log('Search clicked');
        var searchfield = $("#search").val();
        if(searchfield.length < 4) {
            alert('Search should have minimum of 4 characters.');
            return;
        }
        $("#result").empty();
        $.ajax({
            url: "controllers/jquery_process.php",
            type: "POST",
            datatype: "json",
            data: {
                "searchfield": $("#search").val(),
            },
            success: function (response) {
                $("#result").append(response);
            },
        });
    });

    $(".payee_edit").on('click', function (event) {
        event.preventDefault();
        console.log('edit cclicked');
        var payeeId = $(this).attr('id')

        $.ajax({
            url: "controllers/jquery_process.php",
            type: "POST",
            datatype: "json",
            data: {
                "payeeId": payeeId,
                "get_payee" : 1,
            },
            success: function (response) {
                // $("#result").append(response);
                let res = JSON.parse(response);
                $("#name").val(res.Name);
                $("#govtid_type").val(res.Govt_ID);
                $("#govtid").val(res.Govt_ID_Num);
                $("#Phone_Num").val(res.Phone_Num);
                $("#email").val(res.Email_ID);
                $("#address1").val(res.Address1);
                $("#address2").val(res.Address2);
                $("#city").val(res.City);
                $("#state").val(res.State);
                $("#country").val(res.Country);
                $("#link").val(res.Aadhar_Img_URL);
                $("#mode").val(res.Payee_ID);
            },
        });


    })

    $("#payee_account_table tbody").on("click", ".payeeaccountedit", function(event) {
        event.preventDefault();
        var sno = $(this).attr('id');
        console.log("Sending AJAX request with sno: " + sno);

        $.ajax({
            url: "controllers/jquery_process.php",
            type: "POST",
            datatype: "json",
            data: {
                "sno": sno,
                "get_payee_account" : 1,
            },
            success: function (response) {
                // $("#result").append(response);
                console.log(response);
                let res = JSON.parse(response);
                $("#name_in_accnt").val(res.Name_In_Account);
                $("#accnt_num").val(res.Payee_Acnt_Num);
                $("#bank_name").val(res.Bank_Name);
                $("#bank_branch").val(res.Branch);
                $("#ifsc").val(res.IFSC_CODE);
                $("#link").val(res.Passbook_Img_URL);
                $("#barc").val(res.Bank_Registration_Code);
                $("#account_status").val(res.Account_Status);
                $("#barc").prop('disabled', false);
                $("#account_status").prop('disabled', false);
                $("#mode").val(res.Sequence4BankRegCode);
            },
        });


    })

    $("#career_form").on('submit', function (event) {
        event.preventDefault();
            var formdata = {
                company: $("#company").val(),
                phno: $("#phno").val(),
                email: $("#email").val(),
                header: $("#header").val(),
                description: $("#description").val(),
                notes: $("#notes").val(),
                career_form: 1,
            };

            console.log("form", formdata);
    
            result = $.ajax({
                type: "POST",
                url: "controllers/jquery_process.php",
                data: formdata,
            });
    
            result.done(function (response) {
                location.reload();
                alert(response);
            });
    
            result.fail(function (jqXHR, textStatus, errorThrown) {
                console.log("fail");
                // location.reload();
            });
    });

    $("#add_post").on('click', function(event) {
        event.preventDefault();
        $('#form_section').show();
        $('#career_feed').hide();
        $('#add_post').hide();
        $('#backtofeed').show();
    });

    $("#backtofeed").on('click', function(event) {
        event.preventDefault();
        $('#form_section').hide();
        $('#career_feed').show();
        $('#add_post').show();
        $('#backtofeed').hide();
    });
});
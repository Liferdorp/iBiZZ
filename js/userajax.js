function userfunctions(data, action) {
    $.ajaxSetup({
        cache: false,url: "functions/userajax.php",type: "POST",datatype: "json",contentType: "application/json; charset=UTF-8",
        error: function (e) {if (e.message != "undefined" && e.message != null) {alert(e.message);}}
    });

    var InputArray = {};
    InputArray["action"] = action;

    //////////////////////////// Create Custom Order ///////////////////////////////

    if (action == "aanmaken") {

        var empty = false;

        if($("#name").val() == "" || $("#gender").val() == "" || $("#handicap").val() == ""){
            empty = true;
        }
        if(!empty){
            var name = $("#name").val();
            var gender = $("#gender").val();
            var handicap = $("#handicap").val().replace(",",".");
            InputArray["name"] = name;
            InputArray["gender"] = gender;
            InputArray["handicap"] = handicap;
            $.ajax({
                data: JSON.stringify(InputArray),
                success: function (data) {
                        $("#name").val("");
                        $("#gender").val("m");
                        $("#handicap").val("");
                        alert("Gebruiker toegevoegd!")
                        userfunctions('','renderUsers');
                }
            });
        }

    }else if(action == "renderUsers"){
        $.ajax({
            data: JSON.stringify(InputArray),
            success: function (data) {
                $("#userContentFrame").html(data);
            }
        });
    }else if(action == "verwijderen"){
        var confirm = window.confirm("Weet je zeker dat je deze gebruiker wilt verwijderen?");
        if(confirm){
            var id = data;
            InputArray["id"] = id;
            $.ajax({
                data: JSON.stringify(InputArray),
                success: function (data) {
                    alert("Gebruiker is verwijderd");
                    userfunctions('','renderUsers');
                }
            });
        }
    }else if(action == "aanpassen"){
        id = data;
        var empty = false;

        if($("#name_"+data).val() == "" || $("#gender_"+data).val() == "" || $("#handicap_"+data).val() == ""){
            empty = true;
        }
        if(!empty){
            var name = $("#name_"+data).val();
            var gender = $("#gender_"+data).val();
            var handicap = $("#handicap_"+data).val().replace(",",".");
            InputArray["name"] = name;
            InputArray["gender"] = gender;
            InputArray["handicap"] = handicap;
            InputArray["id"] = id;
            $.ajax({
                data: JSON.stringify(InputArray),
                success: function (data) {
                    alert("Gebruiker aangepast!")
                    userfunctions('','renderUsers');
                }
            });
        }
    }

}



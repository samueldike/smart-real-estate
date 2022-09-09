function loading(btn) {
    Btn = document.getElementById(btn);
    $('#'+btn).html("please wait <img src='assets/img/loading.gif' style='width:64px'>");
    Btn.disabled = true;
}
function loading2(btn) {
    Btn = document.getElementById(btn);
    $('#'+btn).html("<img src='assets/img/loading3.gif' style='width:24px'>");
    Btn.disabled = true;
}
function populatingDB2(id){
    $('#'+id).html("<span style='color:#c1eafe'>...populating Database</span> <img src='../assets/img/loading.gif'>");
}
function stopPopulating(btn){
    $('#'+btn).html("<span style='color:#5cb85c;background-color:white;padding:5px'>Success!!!</span>").fadeIn('slow').delay('3000').fadeOut('slow');
}

function stopLoading(btn, btnValue) {
    Btn = document.getElementById(btn);

    Btn.innerHTML = btnValue;
    Btn.disabled = false;
}
function showMessage(message,container_id,type){
    $('#'+container_id).html("<div class='alert alert-"+type+"'>"+message+" <a href='#'' class='close' data-dismiss='alert' aria-label='close'>&times;</a></div>").fadeIn('slow').delay('5000').fadeOut('slow')
}
function generalAlert_error(message){
    $('#general-alert').html("<div id='general-alert-alert-error'>"+message+"</div>").fadeIn('slow').delay('5000').fadeOut('slow')
}
function RegisterUser(){
    loading('regBtn');
    reg_name = $('#reg_name').val();
    reg_email = $('#reg_email').val();
    reg_password = $('#reg_password_1').val();
    reg_password_2 = $('#reg_password_2').val();

    if (reg_password != reg_password_2) {
        showMessage("Password Mismatch.","regMssg","warning");
        stopLoading('regBtn', 'Register');
    }else{
        dataString = 'name=' + reg_name + '&email=' + reg_email + '&password=' + reg_password;
        $.ajax({
            type: "POST",
            url: "ajax-pages/RegisterUser.php",
            data: dataString,
            cache: false,
            success: function (res) {
                if (res == "Success") {
                    //Clear Signup Fields
                    reg_name = '';
                    reg_email = '';
                    reg_password = '';
                    reg_password_2 = '';

                    showMessage("Registeration Successful. Login to Continue.","loginMssg","success");
                    /*login_email = $('#login_email').css('autofocus':'yes');*/
                    stopLoading('regBtn', 'Register');

                } else {
                    showMessage(res,"regMssg","warning");
                    stopLoading('regBtn', 'Register');
                }

            }

        }); 
    }
    
}
function login() {

    loading('loginBtn');
    email = $('#login_email').val();
    password = $('#login_password').val();


    dataString = 'email=' + email + '&password=' + password;

    $.ajax({
        type: "POST",
        url: "ajax-pages/LoginUser.php",
        data: dataString,
        cache: false,
        success: function (res) {
            if (res == "Success") {

                $.ajax({
                    type: "POST",
                    url: "check-profile-level.php",
                    cache: false,
                    success: function (res2) {
                            if (res2 == "submit-property.php") {
                                $("#navigationModal").modal('show');
                                stopLoading('loginBtn', 'Login Successful');
                            }else if(res2 == "build-profile.php"){
                                window.location = res2;
                            }else{
                                window.location = "submit-property.php";
                            }

                    }

                })
            } else {
                showMessage(res,"loginMssg","warning");
                stopLoading('loginBtn', 'Log in');
            }   

        }

    });

};
function city_auto_suggest(){
    var city_keyword = $("#city").val();
    var suggest_area = $("#city_auto_suggest");
    dataString = 'city_keyword=' + city_keyword;

    $.ajax({
        type: "POST",
        url: "ajax-pages/cityAutoSuggest.php",
        data: dataString,
        cache: false,
        success: function (res) {
            suggest_area.html(res);
        }

    });
}
function smart_city_auto_suggest(){
    var city_keyword = $("#smart_city").val();
    var suggest_area = $("#smart_city_auto_suggest");
    dataString = 'city_keyword=' + city_keyword;

    $.ajax({
        type: "POST",
        url: "ajax-pages/smart_cityAutoSuggest.php",
        data: dataString,
        cache: false,
        success: function (res) {
            suggest_area.html(res);
        }

    });
}
function insert_suggestion(div){
    city_suggest_text =  $("."+div).html();
    $("#city").val(city_suggest_text);
    $("."+div).html('');
}
function smart_insert_suggestion(div){
    smart_city_suggest_text =  $("."+div).html();
    $("#smart_city").val(smart_city_suggest_text);
    $("."+div).html('');
}

function validate_new_property(){
    //loading("finishBtn");
    propertyname = $('#propertyname').val();
    propertyprice = $('#propertyprice').val();
    phone = $('#phone').val();
    description = $('#description').val();
    type = $('#type').val();
    state = $('#state').val();
    city = $('#city').val();
    address = $('#address').val();
    quality = $('#quality').val();
    built_in = $('#built_in').val();
    bedrooms = $('#bedrooms').val();
    car_garages = $('#car_garages').val();
    bathrooms = $('#bathrooms').val();
    toilets = $('#toilets').val();
    story_building = $('#story_building').val();
    tnc = $('#tnc').val();

    e = 0;
    if (propertyname == '') {
    	e = e+1;
    	e1 = "<li>Property Name is required in Step 1</li>";
    }else{
    	e1 = '';
    }

    if (propertyprice == '') {
    	e = e+1;
    	e2 = "<li>Property Price is required in Step 1</li>";	
    }else{
    	e2 = '';
    }

    if (phone == '') {
    	e = e+1;
    	e3 = "<li>Seller Phone Number is required in Step 1</li>";
    }else{
    	e3 = '';
    }

    if (description == '') {
    	e = e+1;
    	e4 = "<li>Property Description is required i Step 2</li>";
    }else{
    	e4 = '';
    }

    if (type == '') {
    	e = e+1;
    	e5 = "<li>Property Type is required in Step 2</li>";
    }else{
    	e5 = '';
    }

    if (state == '') {
    	e = e+1;
    	e6 = "<li>Property State is required in Step 2</li>";
    }else{
    	e6 = '';
    }

    if (city == '') {
    	e = e+1;
    	e7 = "<li>Property City is required in Step 2</li>";
    }else{
    	e7 = '';
    }

    if (address == '') {
    	e = e+1;
    	e8 = "<li>Property Address is required in Step 2</li>";
    }else{
    	e8 = '';
    }

    if (quality == '') {
    	e = e+1;
    	e9 = "<li>Property Quality is required in Step 2</li>";
    }else{
    	e9 = '';
    }

    if (built_in == '') {
    	e = e+1;
    	e10 = "<li>The property was built is required in Step 2</li>";
    }else{
    	e10 = '';
    }

    if (bedrooms == '') {
    	e = e+1;
    	e11 = "<li>Number of property bedroom is required in Step 2</li>";
    }else{
    	e11 = '';
    }

    if (car_garages == '') {
    	e = e+1;
    	e12 = "<li>Number of property Car Garage is required in Step 2</li>";
    }else{
    	e12 = '';
    }

    if (bathrooms == '') {
    	e = e+1;
    	e13 = "<li>Number of property Bathroom is required in Step 2</li>";
    }else{
    	e13 = '';
    }

    if (toilets == '') {
    	e = e+1;
    	e14 = "<li>Number of property toilet is required in Step 2</li>";
    }else{
    	e14 = '';
    }

    if (story_building == '') {
    	e = e+1;
    	e15 = "<li>Number of property story Building is required in Step 2, if none select Not Story building</li>";
    }else{
    	e15 = '';
    }

    if (tnc == "") {
    	e = e+1;
    	e16 = "<li>You must accept the Terms and Conditions to proceed.</li>";
    }else{
    	e16 = '';
    }

    if (e == 0) {
    	$("#property_upload_form").submit();
    }else{
    	error_message = "<h4 style='margin-left:20px;color:rgb(173, 28, 28)'><span class='fa fa-warning'></span>Check the following Errors:</h4> <ul style='color:#F00'>"+e1+e2+e3+e4+e5+e6+e7+e8+e9+e10+e11+e12+e13+e14+e15+e16+"</ul>";
    	$("#error_messages").html(error_message);
    	 $.scrollTo('#error_messages', 1500, {
                                easing: 'easeOutCubic'
        });
    }

}

function load_lga(){
    state_id = $("#state").val();
     dataString = 'state_id=' + state_id;

                    $.ajax({
                        type: "POST",
                        url: "ajax-pages/load-lga.php",
                        data: dataString,
                        cache: false,
                        success: function (res) {
                            if (res != "Failure") {
                                document.getElementById('lga').innerHTML = res;
                            }
                        }
                    });
    
}
function video_preview(){
    $('#vid_prev').html("<img src='assets/img/loading.gif' style='width:64px'>");
    vid = $("#property_video").val();
    $('#vid_prev').html("<video  controls src='"+vid+"'></video>");
    }
function homeSearch(){
    loading2('searchBtn');
    state = $("#state").val();
    city = $("#city").val();
    price_range = $(".price_range").val();

    p = price_range.split(",");
    p1 = p[0];
    p2 = p[1];

    c = city.replace(" ","+");

    if (price_range == '') {
        query_string = "s="+state+"&c="+c+"&f=&t=";
    }else{
        query_string = "s="+state+"&c="+c+"&f="+p1+"&t="+p2;
    }

    window.location = "search.php?"+query_string;
}
function smart_search(){
    loading2('smart_searchBtn');
    state = $("#smart_state").val();
    city = $("#smart_city").val();
    price_range = $(".smart_price_range").val();

    p = price_range.split(",");
    p1 = p[0];
    p2 = p[1];

    c = city.replace(" ","+");

    if (price_range == '') {
        query_string = "s="+state+"&c="+c+"&f=&t=";
    }else{
        query_string = "s="+state+"&c="+c+"&f="+p1+"&t="+p2;
    }

    window.location = "search.php?"+query_string;
}
function isPreferencesSet(the_page){
    dataString = 'y=1';
    $.ajax({
        type: "POST",
        url: "ajax-pages/isPreferencesSet.php",
        data: dataString,
        cache: false,
        success: function (res) {
        if (res == "No") {
           $('#setPreferenceModal').modal('show');
        }else if(res == "Yes"){
            if (the_page == 'the_page') {

            }else{
                window.location = "share-rent.php";
            }
            
        }else if(res == "Not Logged In"){
             window.location = "signup-signin.php";
        }
    }
    });

}
function showRequestToShareRent(eId){
    dataString = 'id='+eId;
    $.ajax({
        type: "POST",
        url: "ajax-pages/RequestToShareRentModal.php",
        data: dataString,
        cache: false,
        success: function (res) {
        if(res != "Failure"){
            $("#approveRequestToShareRentModalBody").html(res);
            $('#approveRequestToShareRentModal').modal('show');  
        }
    }
    });
}
function approveRequest(id){
    loading("approveBtn");
    dataString = 'id='+id;
    $.ajax({
        type: "POST",
        url: "ajax-pages/approveRequest.php",
        data: dataString,
        cache: false,
        success: function (res) {
        if(res == "Success"){
            $("#approveRequestToShareRentModalBody").html('');
            $('#approveRequestToShareRentModal').modal('hide'); 
            window.location = "share-rent.php";
        }
    }
    });
}
function disapprove(user_id,type,btn){
    loading(btn);
    dataString = 'user_id='+user_id+'&type='+type;
    $.ajax({
        type: "POST",
        url: "ajax-pages/disapprove.php",
        data: dataString,
        cache: false,
        success: function (res) {
        if(res == "Success"){
            $("#approveRequestToShareRentModalBody").html('');
            $('#approveRequestToShareRentModal').modal('hide'); 
            window.location = "share-rent.php";
        }else{
            alert(res);
        }
    }
    });
}
function promptPermdisapprove(user_id,type,btn){
    c = confirm("By cliking this botton, you can neither be matched to this user nor the user be matched to you in the future. Are you sure you want to permanently disapprove this user?");
    if (c == true) {
        disapprove(user_id,type,btn);
    };
}
function changeMyPrefs(){
    $('#changePreferenceModal').modal('show');
}
function cancelShareRent(username){
        c = confirm("Ooops! "+username+", giving us your preferences will give you the best match to your desired co-tenant. Are you sure you want to exit?");
        if (c == true) {
            window.location = "properties.php";
        };
}
function prompt_delete_property(property_id){
        c = confirm("Are you sure you want to delete this property?");
        if (c == true) {
            dataString = 'property_id='+property_id;
            $.ajax({
                type: "POST",
                url: "ajax-pages/deleteProperty.php",
                data: dataString,
                cache: false,
                success: function (res) {
                if(res == "Success"){
                    $("#"+property_id).fadeOut('3000');
                }else{
                    alert(res);
                }
            }
            });
        };
}
function changePassword(){
    loading('changePasswordBtn');
    old_password = $('#old_password').val();
    new_password = $('#new_password').val();
    new_password2 = $('#new_password2').val();

    if (old_password == '') {
        $('#change-password-alert').html("<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>&times;</button>Old password cannot be empty.</div>");
        stopLoading('changePasswordBtn', 'Submit');
    }else if(new_password == ''){
        $('#change-password-alert').html("<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>&times;</button>New password cannot be empty.</div>");
        stopLoading('changePasswordBtn', 'Submit');
    }else if(new_password != new_password2){
        $('#change-password-alert').html("<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>&times;</button>Password Mismatch.</div>");
        stopLoading('changePasswordBtn', 'Submit');
    }else {
        //////CHECK IF ADMIN PASSWORD IS AUTHENTIC
        dataString = 'password=' +old_password;

        $.ajax({
            type: "POST",
            url: "ajax-pages/authenticateAdmin.php",
            data: dataString,
            cache: false,
            success: function (res) {
                if (res == "Success") {
                    /*CHANGE PASSWORD*/
                    dataString = 'password=' + new_password;

                    $.ajax({
                        type: "POST",
                        url: "ajax-pages/change-password.php",
                        data: dataString,
                        cache: false,
                        success: function (res) {
                            if (res == "Success") {
                                $('#old_password').val('');
                                $('#new_password').val('');
                                $('#new_password2').val('');
                                stopLoading('changePasswordBtn', 'Submit');
                                $('#changePasswordModal').modal('hide');
                                alert("Password Successfully changed");
                               
                            } else {
                                $('#change-password-alert').html("<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>&times;</button>" + res + "</div>");
                                stopLoading('changePasswordBtn', 'Submit');
                            }

                        }

                    });
                } else {
                    $('#change-password-alert').html("<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>&times;</button>Old password is incorrect.</div>");
                    stopLoading('changePasswordBtn', 'Submit');
                }
            }

        });
    }
}
function changeUserPassword(){
    loading('changePasswordBtn');
    old_password = $('#old_password').val();
    new_password1 = $('#new_password1').val();
    new_password2 = $('#new_password2').val();

    if (old_password == '') {
        $('#change-password-alert').html("<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>&times;</button>Old password cannot be empty.</div>").fadeIn('slow').delay('3000').fadeOut('slow');
        stopLoading('changePasswordBtn', 'Submit');
    }else if(new_password1 == ''){
        $('#change-password-alert').html("<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>&times;</button>New password cannot be empty.</div>").fadeIn('slow').delay('3000').fadeOut('slow');
        stopLoading('changePasswordBtn', 'Submit');
    }else if(new_password1 != new_password2){
        $('#change-password-alert').html("<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>&times;</button>Password Mismatch.</div>").fadeIn('slow').delay('3000').fadeOut('slow');
        stopLoading('changePasswordBtn', 'Submit');
    }else {
        //////CHECK IF ADMIN PASSWORD IS AUTHENTIC
        dataString = 'old_password=' +old_password+'&new_password='+new_password1;

                    $.ajax({
                        type: "POST",
                        url: "ajax-pages/change-user-password.php",
                        data: dataString,
                        cache: false,
                        success: function (res) {
                            if (res == "Success") {
                                $('#old_password').val('');
                                $('#new_password1').val('');
                                $('#new_password2').val('');
                                stopLoading('changePasswordBtn', 'Submit');
                                $('#change-password-alert').html("<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>&times;</button>Password Successfully changed</div>").fadeIn('slow').delay('5000').fadeOut('slow');
                               
                            } else {
                                $('#change-password-alert').html("<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'>&times;</button>" + res + "</div>").fadeIn('slow').delay('3000').fadeOut('slow');
                                stopLoading('changePasswordBtn', 'Submit');
                            }

                        }

                    });
    }

    
}

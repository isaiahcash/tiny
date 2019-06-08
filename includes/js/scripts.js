$("#submit_button").click(function(){
    console.log("clicked");
    var full_url = $("#full_url").val();

    $.post('ajax.php', {full_url: full_url},
        function(data){
            console.log(data);
            data = JSON.parse(data);
            show_alert(data['flag'], data['message']);
        }
    );
});


function show_alert(flag, message)
{
    var rand = Math.floor(Math.random() * 1000) + 1;
    var class_flag = "";
    if(flag) class_flag = "success";
    else class_flag = "danger";
    $("#output").append("<div class='alert alert-" + class_flag + " ' role='alert' id='alert-" + rand + "'><button type='button' class='close' data-dismiss='alert'><span>&times;</span></button>" + message + "</div>");
}


function copy_text(rand) {
    /* Get the text field */
    var url_field = $("#copy_url-" + rand);

    console.log(url_field.val());
    /* Select the text field */
    url_field.select();

    /* Copy the text inside the text field */
    document.execCommand("copy");

}
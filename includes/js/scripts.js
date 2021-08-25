urls = $("#urls").DataTable({
    "ajax" : {
        "url": "ajax_urls.php",
        "type": "POST"
    },
    "columns": [
        {
            "data": "url_id"

        },
        {
            "data": "short_key"
        },
        {
            "data": "tiny_url"
        },
        {
            "data": "full_url"

        },
        {"data": "date_created"}
    ],
    "stateSave": true,
    "sScrollX": "100%",
    "responsive": true
});

hits = $("#hits").DataTable({
    "order" : [[3, 'desc']],
    "ajax" : {
        "url": "ajax_hits.php",
        "type": "POST"
    },
    "columns": [
        {
            "data": "short_key"
        },
        {
            "data": "full_url"
        },
        {
            "data": "client_info"
        },
        {
            "data": "hit_timestamp"
        }
    ],
    "stateSave": true,
    "sScrollX": "100%",
    "responsive": true
});




$('form').on('submit', function (e) {

    e.preventDefault();

    $.ajax({
        type: 'post',
        url: 'ajax_create.php',
        data: $('form').serialize(),
        success: function (data) {

            console.log(data);
            data = JSON.parse(data);
            show_alert(data['flag'], data['message']);

            grecaptcha.reset();

            urls.ajax.reload(null, false);
        }
    });

});
//
//
// $("#submit_button").click(function(){
//     console.log("clicked");
//     var full_url = $("#full_url").val();
//
//     $.post('ajax_create.php', {full_url: full_url},
//         function(data){
//             console.log(data);
//             data = JSON.parse(data);
//             show_alert(data['flag'], data['message']);
//
//             urls.ajax.reload(null, false);
//         }
//     );
// });


function show_alert(flag, message)
{
    var rand = Math.floor(Math.random() * 1000) + 1;
    var class_flag = "";
    if(flag) class_flag = "success";
    else class_flag = "danger";
    $("#output").append("<div class='alert alert-" + class_flag + " ' role='alert' id='alert-" + rand + "'><button type='button' class='close' data-dismiss='alert'><span>&times;</span></button>" + message + "</div>");
}


function copyText(rand) {
    /* Get the text field */
    var url_field = $("#copy_url-" + rand);

    console.log(url_field.val());
    /* Select the text field */
    url_field.select();

    /* Copy the text inside the text field */
    document.execCommand("copy");

}


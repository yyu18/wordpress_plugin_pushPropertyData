const url = 'https://'+window.location.hostname+'/wp-content/plugins/plugin-propertyDataPush/api/configSettingAPI.php'
function delete_endpoint(element){
    $('#add_new_endpoint').prop('disabled', true)
    $('#delete_endpoint').prop('disabled', true)
    $('#save_endpoint').prop('disabled', true)

    $.ajax({
        type: 'delete',
        url: url,
        data:  {
        'data':$(element).attr("data-id")
        },
        success: function (data) {
            alert(data)
        },
        error : function (jqXhr, textStatus, errorMessage) { 
            console.log('Error: ' + errorMessage);
        }
    })
}

function update_data_config(event,element){
    $('#add_new_endpoint').prop('disabled', true)
    $('#delete_endpoint').prop('disabled', true)
    $('#save_endpoint').prop('disabled', true)
    event.preventDefault()
    $(element).parents('form.form-basic')
    var data = $(element).parents('form.form-basic').serialize()
    console.log(data)
    $.ajax({
        type: 'put',
        url: url,
        data:  data,
        success: function (data) {
            alert(JSON.stringify(data))
            },
        error : function (jqXhr, textStatus, errorMessage) { 
            console.log('Error: ' + errorMessage);
        }
    })
}
$(function () {
    $('#add_new_endpoint').on('click',function(e){
        $('#add_new_endpoint').prop('disabled', true)
        $('#delete_endpoint').prop('disabled', true)
        $('#save_endpoint').prop('disabled', true)
        e.preventDefault()
        $.ajax({
            type: 'post',
            url: url,
            data:  {
                'data':$('#add_new_endpoint').val()
            },
            success: function (data) {
                alert(data)
                },
            error : function (jqXhr, textStatus, errorMessage) { 
                console.log('Error: ' + errorMessage);
            }
        })
    })

    // $('#configForm').on('submit', function (e) {
    //     $('#add_new_endpoint').prop('disabled', true)
    //     $('#delete_endpoint').prop('disabled', true)
    //     $('#save_endpoint').prop('disabled', true)
    //     e.preventDefault()
    //     console.log($("#configForm").serialize())
    //     console.log($('#delete_endpoint').val())
    //     $.ajax({
    //         type: 'put',
    //         url: url,
    //         data:  $("#configForm").serialize(),
    //         success: function (data) {
    //             alert(data)
    //         },
    //         error : function (jqXhr, textStatus, errorMessage) { 
    //             console.log('Error: ' + errorMessage);
    //         }
    //     })
    // })
})
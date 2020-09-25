$(function () {
const url = 'http://'+window.location.hostname+'/wp-content/plugins/plugin-propertyDataPush/api/configSetting.php'
    $('#delete_endpoint').on('click',function(e){
        $('#add_new_endpoint').prop('disabled', true)
        $('#delete_endpoint').prop('disabled', true)
        $('#save_endpoint').prop('disabled', true)
        e.preventDefault()
        console.log($('#delete_endpoint').val())
        $.ajax({
            type: 'post',
            url: url,
            data:  {
                'deleteURL':$('#delete_endpoint').val()
            },
            success: function (data) {
                alert(data)
                },
            error : function (jqXhr, textStatus, errorMessage) { 
                console.log('Error: ' + errorMessage);
            }
        })
    })

    $('#add_new_endpoint').on('click',function(e){
        $('#add_new_endpoint').prop('disabled', true)
        $('#delete_endpoint').prop('disabled', true)
        $('#save_endpoint').prop('disabled', true)
        e.preventDefault()
        $.ajax({
            type: 'post',
            url: url,
            data:  {
                'createURL':$('#add_new_endpoint').val()
            },
            success: function (data) {
                alert(data)
                },
            error : function (jqXhr, textStatus, errorMessage) { 
                console.log('Error: ' + errorMessage);
            }
        })
    })

    $('#configForm').on('submit', function (e) {
        $('#add_new_endpoint').prop('disabled', true)
        $('#delete_endpoint').prop('disabled', true)
        $('#save_endpoint').prop('disabled', true)
        e.preventDefault()
        console.log($("#configForm").serialize())
        console.log($('#delete_endpoint').val())
        $.ajax({
            type: 'post',
            url: url,
            data:  $("#configForm").serialize(),
            success: function (data) {
                alert(data)
            },
            error : function (jqXhr, textStatus, errorMessage) { 
                console.log('Error: ' + errorMessage);
            }
        })
    })
})
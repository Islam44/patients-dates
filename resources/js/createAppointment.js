$(document).ready(function () {
    $("#specialtyList").change(function (e) {
        $('#painsList').html("")
        var specialty_id = $(this).val();
        if (specialty_id) {
            $.ajax({
                type: "GET",
                url: "/pains/specialty/" + specialty_id,
                success: function (pains) {
                    $.each(pains, function (key, value) {
                        $('#painsList').append(`<option value='${value.id}'>${value.description}</option>`);
                    });
                }
            })
        } else {
            $('#painsList').append('  <option value="">Select Specialty First</option>');
        }
    });
});

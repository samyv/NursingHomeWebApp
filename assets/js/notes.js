

$(document).ready(function () {
    $('.note').focus(showSave)

});

function showSave(event) {
    $(event.target).next().css("display", "block");
    $(event.target).next(".fa").remove();
    $(event.target).next(".savebtn").css("left", "3px");
    $(event.target).next(".savebtn").val("Save");
}

function saveNote(event) {
    $noteid = $(event.target).attr("id");
    $note = $(event.target).prev().val();

    if(typeof(idResident) != "undefined" && idResident !== null){
        console.log(idResident);
        $.ajax({
            url: window.origin+'/a18ux02/Caregiver/saveNote',
            method: 'post',
            dataType: 'json',
            data: {
                'note': $note,
                'idinput': $noteid,
                'idResident' : idResident,
            },
            success: function(idNote) {
                $(event.target).attr("id",idNote[0]['LAST_INSERT_ID()']);
                console.log($(event.target).siblings(".deleteNote"))
                $(event.target).siblings(".deleteNote").attr("id",idNote[0]['LAST_INSERT_ID()'])
            }
        });
    }else {
        $.ajax({
            url: window.origin+'/a18ux02/Caregiver/saveNote',
            method: 'post',
            dataType: 'json',
            data: {
                'note': $note,
                'idinput': $noteid,
            },
            success: function(idNote) {
                $(event.target).attr("id",idNote[0]['LAST_INSERT_ID()']);
                console.log($(event.target).siblings(".deleteNote"))
                $(event.target).siblings(".deleteNote").attr("id",idNote[0]['LAST_INSERT_ID()'])
            }
        });
    }






    $(event.target).before("<i class=\"fa fa-check\"></i>");
    $(event.target).prev().css({
        "position": "absolute",
        "bottom": "3px",
        "left": "3px",
        "background-color": "#003b46",
        "color": "white",
        "padding-left": "5px",
        "z-index": "9",
    });
    $(event.target).prev().css("height", $(event.target).css("height"));
    $(event.target).prev().css("padding-top", "11px");
    $(event.target).css("left", "19px")
    $(event.target).val("Saved");

}

function deleteNote(event) {
    $note = $(event.target).parent();
    $noteid = $(event.target).attr("id");
    Confirm( $noteid, $note);
};

function Confirm($noteid, $note) { /*change*/
    $('.dialog-ovelay').css("display","block");
    $('.doAction').click(function () {
        $(this).parents('.dialog-ovelay').fadeOut(500, function () {
            $(this).parents('.dialog-ovelay').css("display","none");
            $.ajax({
                url: window.origin+'/a18ux02/Caregiver/deleteNote',
                method: 'post',
                dataType: 'json',
                data: {
                    'idNote': $noteid
                },
                success() {

                }
            });
            $note.parent().remove();
        });
    });

    $('.cancelAction, .fa-close').click(function () {
        $('.dialog-ovelay').fadeOut(500, function () {
            $('.dialog-ovelay').css("display","none");
        });
    });
};


$(document).ready(function () {
    $('.deleteNote').click(deleteNote);
});


$(document).ready(function () {
    $('.savebtn').click(saveNote);
});


$(document).ready(function () {
    $('#newNotebtn').click(function () {
        $new =("<form name=\"submitNotes\" class=\"existing form\" action=\"\">\n" +
            "                <input type=\"number\" name=\"id\" id=\"idinput\" class=\"idinput form-group\" style=\"display:none;\" value=\"\">\n" +
            "                <a class=\"deleteNote\" name=\"close\"><i id=\"\" class=\"fa fa-trash-alt\"></i></a>\n" +
            "                <textarea id=\"notearea\"  class=\"note form-group\" wrap=\"hard\" maxlength=\"1000\" form=\"submitNotes\" name=\"note\"></textarea>\n" +
            "                <input id=\"\" class=\"savebtn btn form-group\" type=\"button\" value=\"Save\" style=\"display:none\">\n" +
            "            </form>");
        $('#newNote').parent().next().next().prepend($new);
        /*$('#newNote').before("<form name=\"submitNotes\" class=\"existing form\" action=\"\">\n" +
            "                <input type=\"number\" name=\"id\" id=\"idinput\" class=\"idinput form-group\" style=\"display:none;\" value=\"\">\n" +
            "                <a class=\"btn deleteNote\" name=\"close\"><i id=\"\" class=\"fa fa-trash-alt\"></i></a>\n" +
            "                <textarea id=\"notearea\"  class=\"note form-group\" wrap=\"hard\" maxlength=\"1000\" form=\"submitNotes\" name=\"note\"></textarea>\n" +
            "                <input id=\"\" class=\"savebtn btn form-group\" type=\"button\" value=\"Save\" style=\"display:none\">\n" +
            "            </form>");*/
        $('.note').focus(showSave);
        $('.deleteNote').click(deleteNote);
        $('.savebtn').click(saveNote);
    });

});

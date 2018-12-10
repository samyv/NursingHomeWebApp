

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
    $.ajax({
        url: window.origin+'/Caregiver/saveNote',
        method: 'post',
        dataType: 'json',
        data: {
            'note': $note,
            'idinput': $noteid
        },
        success: function() {
            $.ajax({
                url: window.origin+'/Caregiver/getIdLastNote/' + $note,
                success: function(idNote){
                    console.log(idNote);
                    $(event.target).attr("id",idNote);
                }
            });
        }
    });

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
    Confirm('Delete note?', 'Are you sure you want to delete this note?', 'Yes', 'Cancel', $noteid, $note);
};

function Confirm(title, msg, $true, $false, $noteid, $note) { /*change*/
    if($content==undefined) {
        var $content = "<div class='dialog-ovelay'>" +
            "<div class='dialog'><header>" +
            " <h3> " + title + " </h3> " +
            "<i class='fa fa-close'></i>" +
            "</header>" +
            "<div class='dialog-msg'>" +
            " <p> " + msg + " </p> " +
            "</div>" +
            "<footer>" +
            "<div class='controls'>" +
            " <button class='button button-danger doAction'>" + $true + "</button> " +
            " <button class='button button-default cancelAction'>" + $false + "</button> " +
            "</div>" +
            "</footer>" +
            "</div>" +
            "</div>";
    }
    $('body').prepend($content);
    $flag = false;
    $('.doAction').click(function () {
        $(this).parents('.dialog-ovelay').fadeOut(500, function () {
            $(this).remove();
            $.ajax({
                url: window.origin+'/Caregiver/deleteNote',
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
        $(this).parents('.dialog-ovelay').fadeOut(500, function () {
            $(this).remove();
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
            "                <a class=\"btn deleteNote\" name=\"close\"><i id=\"\" class=\"fa fa-trash-alt\"></i></a>\n" +
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

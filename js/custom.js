var reader_offset = 0;
var buffer_size = 5000;
var pending_content = '';

function readAndSendChunk() {
    var reader = new FileReader();
    var file = $('#csv_file')[0].files[0];
    reader.onloadend = function (evt) {

        if (evt.loaded == 0) return;
        reader_offset += evt.loaded;

        var last_line_end = evt.target.result.lastIndexOf('\n');
        var content = pending_content + evt.target.result.substring(0, last_line_end);
        pending_content = evt.target.result.substring(last_line_end + 1, evt.target.result.length);

        send(content);
    };
    var blob = file.slice(reader_offset, reader_offset + buffer_size);
    reader.readAsText(blob);
}

function send(data_chunk) {
    var name = $('#csv_file')[0].files[0].name;
    $.ajax({
        url: "read_csv.php",
        method: 'POST',
        data: { data: data_chunk, file_name: name },
    }).done(function (response) {
        readAndSendChunk();
        console.log(response);
    });
}

$(function () {
    $('#button').click(function () {
        reader_offset = 0;
        pending_content = '';
        readAndSendChunk();
    });
});
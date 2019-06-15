var reader_offset = 0;
var buffer_size = 5000;
var pending_content = '';

function CSVImportGetHeaders() {
    var file = document.getElementById('csv_file').files[0]
    var reader = new FileReader();
    reader.readAsArrayBuffer(file);
    reader.onloadend = function (evt) {
        var data = evt.target.result;
        var byteLength = data.byteLength;
        var ui8a = new Uint8Array(data, 0);
        var headerString = '';
        for (var i = 0; i < byteLength; i++) {
            var char = String.fromCharCode(ui8a[i]);
            if (char.match(/[^\r\n]+/g) !== null) {
                headerString += char;
            } else {
                break;
            }
        }
        var headers = headerString.split(',');
        $('#headers').val(headerString);
        readAndSendChunk();
    };
}

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
    var headers = $('#headers').val();
    $.ajax({
        url: "read_csv.php",
        method: 'POST',
        data: { data: data_chunk, file_name: name, headers: headers },
    }).done(function (response) {
        readAndSendChunk();
        console.log(response);
    });
}

$(function () {
    $('#button').click(function () {
        reader_offset = 0;
        pending_content = '';
        CSVImportGetHeaders();
    });
});
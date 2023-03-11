@extends('admin.layouts.default')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        @include('admin.includes.alert-message')

        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Update Gallary Library</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ url('admin/media/list') }}">
                                Uploaded media
                            </a>
                        </li>
                        <li class="breadcrumb-item active">Add</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- /.card-header -->
            <!-- form start -->
            <form id="updateForm" name="updateForm" autocomplete="off" enctype="multipart/form-data" method="post"
                action="{{ url('admin/media/create') }}">

                {{ csrf_field() }}
                <input type="hidden" value="{{ $userId }}" name="userId">

                <div class="row">
                    <div class="col-sm-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Add Gallary Content</h3>

                            </div>
                            <div class="container" >
                                <input type="file" name="file" id="file" multiple>

                                <!-- Drag and Drop container-->
                                <div class="upload-area"  id="uploadfile">
                                    <h1>Drag and Drop file here<br/>Or<br/>Click to select file</h1>
                                </div>
                            </div>
            </form>

            <table class="table">
                <thead>
                    <th scope="col">File Name</th>
                    <th scope="col">File Size</th>
                    <th scope="col">File Type</th>
                    <th scope="col">Update Status</th>
                </thead>
                <tbody>
                    <tr>
                    <td id="file-name"></td>
                    <td id="file-size"></td>
                    <td id="file-type"></td>
                    <td>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
                        </div>
                    </td>
                </tr>
                </tbody>

            </table>

        </div>
    </section>
</div>


<style>
   .container{
    width: 100%;
    margin: 0 auto;
}

.upload-area{
     background-color: #EEE;
    border: #999 5px dashed;
    width: 100%;
    height: 200px;
    padding: 8px;
    font-size: 10px;
    margin-top: 5px;
}

.upload-area:hover{
    cursor: pointer;
}

.upload-area h1{
    text-align: center;
    font-weight: normal;
    font-family: sans-serif;
    line-height: 50px;
    color: darkslategray;
}

#file{
    display: none;
}

/* Thumbnail */
.thumbnail{
    width: 80px;
    height: 80px;
    padding: 2px;
    border: 2px solid lightgray;
    border-radius: 3px;
    float: left;
    margin: 5px;
}

.size{
    font-size:10px;
}
</style>

<script>
    $(function() {

    let filesArray = [];

    // preventing page from redirecting
    $("html").on("dragover", function(e) {
        e.preventDefault();
        e.stopPropagation();
    });

    $("html").on("drop", function(e) { e.preventDefault(); e.stopPropagation(); });

    // Drop
    $('.upload-area').on('drop', function (e) {
        e.stopPropagation();
        e.preventDefault();

        var file = e.originalEvent.dataTransfer.files;
        var fd = new FormData();

        fd.append('file', file[0]);
        
        for(let number=0;number<file.length;number++)
        {
        let fileData = {
            "name": file[number].name,
            "size": file[number].size,
            "type": file[number].type
        };
        filesArray.push(fileData);
    }

        let stringHTMLname = "";
        let stringHTMLsize = "";
        let stringHTMLtype = "";
        for (var i = 0; i < filesArray.length; i++) {
            stringHTMLname +=  filesArray[i].name;
            stringHTMLtype +=  filesArray[i].type;
            let kb = filesArray[i].size / 1024;
            let mb = kb / 1024;
            stringHTMLsize += mb + " Mb";

        console.log(filesArray[i].name);
        console.log(filesArray[i].size);
        console.log(filesArray[i].type);

        // $("#file-name").html(filesArray[i].name);
        // $("#file-size").html(filesArray[i].size);
        // $("#file-type").html(filesArray[i].type);

        }

        // console.log(stringHTMLname);
        // console.log(stringHTMLsize);
        // console.log(stringHTMLtype);

        $("#file-name").html(stringHTMLname);
        $("#file-size").html(stringHTMLsize);
        $("#file-type").html(stringHTMLtype);


        // uploadData(fd);
    });

    // Open file selector on div click
    $("#uploadfile").click(function(){
        $("#file").click();

        
    });

    // file selected
    $("#file").change(function(){
        
        var fd = new FormData();

        var files = $('#file')[0].files[0];

        fd.append('file',files[0]);

        for(let number=0;number<file.length;number++)
        {
        let fileData = {
            "name": files[number].name,
            "size": files[number].size
        };
        filesArray.push(fileData);
    }

        console.log(files);
        console.log(filesArray);

        let stringHTML = "";
            stringHTML += "<p>File name: " + files.name+" ";
            let s = files.size / 1024;
            stringHTML += "File size: " + s + " KB</p>";

        $("#fileViewList").html(stringHTML);



        // uploadData(fd);
    });
});

// Sending AJAX request and upload file
function uploadData(formdata){

    $.ajax({
        url: 'upload.php',
        type: 'post',
        data: formdata,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response){
            addThumbnail(response);
        }
    });
}

// Added thumbnail
function addThumbnail(data){
    $("#uploadfile h1").remove();
    var len = $("#uploadfile div.thumbnail").length;

    var num = Number(len);
    num = num + 1;

    var name = data.name;
    var size = convertSize(data.size);
    var src = data.src;

    // Creating an thumbnail
    $("#uploadfile").append('<div id="thumbnail_'+num+'" class="thumbnail"></div>');
    $("#thumbnail_"+num).append('<img src="'+src+'" width="100%" height="78%">');
    $("#thumbnail_"+num).append('<span class="size">'+size+'<span>');

}

// Bytes conversion
function convertSize(size) {
    var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
    if (size == 0) return '0 Byte';
    var i = parseInt(Math.floor(Math.log(size) / Math.log(1024)));
    return Math.round(size / Math.pow(1024, i), 2) + ' ' + sizes[i];
}


</script>

@stop
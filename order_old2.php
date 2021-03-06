<?php require_once 'core/init.php'; ?>
<!DOCTYPE html>
  <html lang="en">
    <head>
      <?php include 'includes/include_head.php';?>
      <style media="screen">
          .container{
            margin-top: 50px;
          }
          .small-text{
            font-size: 10px;
          }
          .card-header,.btn-block{
           margin:0;
           padding:0;
          }
          #accordion{
            margin: 30px;
          }
          #accordion .card{
            border-style: none;
          }
          hr{
            margin-top: 30px;
            margin-bottom: 30px;
            height: 2px;
            background-color: rgba(0,0,0,.05);
          }
          .title{
            margin-top: 40px;
            margin-bottom: 45px;
            position: relative;
            right:-18px;
            color: rgba(255, 0, 0, 0.5);
          }
          .bt-marge{
            border-bottom: 1px solid rgba(0,0,0,0.5);
            padding: 0;
          }
          .table td,.table th{
            padding:0;
          }
          .controles .btn{
            width: 180px;
            margin: 10px;
          }
          .bnt-control{
            margin: 0 auto;
            width: 24%;
            padding: 0;
            height: 40px;
          }
          .caret-off::after {
             visibility:hidden;
		      }
          .dropdown-item:hover{
            background-color: rgba(255,255,255,0.5);
          }
          .highlight{
            border:2px solid rgba(126, 239, 104, 0.8);
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset, 0 0 8px rgba(126, 239, 104, 0.6);
            outline: 0 none;
          }
          .redlight{
            border:2px solid rgba(255, 0, 0, 0.8);
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset, 0 0 8px rgba(255, 0, 0, 0.6);
            outline: 0 none;
          }
          .puping-label{
            background-color: rgba(255,255,255,0.85);
            margin-right: 8px;
            padding:5px;
            position: relative;
            top:-55px;
            right: 15px;
          }
          .input-col{
            height: 38px;
          }
      </style>
      <script type="text/javascript">
        $(document).on("focus","#dateArriver",function(){
          $('#dateArriver').attr('type','date');
        });
        $(document).on("blur","#dateArriver",function(){
          this.type="text";
        });
        $(document).on("focus","#dateArriver2",function(){
          this.type="date";
        });
        function isset(obj){
          return (typeof obj !== "undefined" && obj)?true:false;
        }
        function addAlert(type,strongMsg,msg){
          $("#myNewAlert").remove();
          htm = `<div style="margin-top:50px;" class="alert alert-`+type+` alert-dismissible fade in text-center fixed-top" id="myNewAlert">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <strong>`+strongMsg+`!</strong> `+msg+`.
                </div>`;
          $("nav").after(htm);
          $("#myNewAlert").fadeTo(8000, 1000).slideUp(500, function(){
            $("#myNewAlert").slideUp(500);
          });
        }
        function ignoreNull(variable) {
          return (variable === null)?"":variable;
        }
        function reload(from,lenght){
          if(from == 0 && lenght == 0){
            from = $('#dataTable tr').length;
            lenght = Math.round($('#dataTable tr').length);
          }
          var json = JSON.stringify({'from':from,'lenght':lenght});
          $.ajax({
            url:"load.php",
            method:"POST",
            data:{json:json},
            success:function(data){
              var dUp1=`<div class="dropup">`;
              var dUp2=`<div class="dropdown-menu bg-primary   text-right"  style="margin-left:-90px;">`;
              var dUp3=`  <a class="dropdown-item " href="#" style="color:#fff"><i class="fa fa-folder-open-o" aria-hidden="true"></i> الاطلاع على الملف</a>
                          <a class="dropdown-item " href="#" style="color:#fff"><i class="fa fa-trash-o" aria-hidden="true"></i> حذف الملف</a>`;
              var dUp4=`  <a class="dropdown-item " href="#"  style="color:#fff"><i class="fa fa-plus" aria-hidden="true"></i> اضافة او تغيير ملف</a>
                        </div>
                      </div>`;
              var json = JSON.parse(data);
              //var htm = $("#dataTable").html();;
              for (var i = 0; i < json.length; i++) {
                td='';
                td2='';

                if(json[i].fileID!= null){
                  td=`<td name="file">`+dUp1+`<a class="dropdown-toggle caret-off" data-toggle="dropdown" href='#' style='color:#E94B3C;'><i class="fa fa-file-pdf-o" aria-hidden="true" data-toggle="tooltip" title="الاطلاع على النسخة الضوئية!"></i></a>`+dUp2+dUp3+dUp4+`</td>`;
                }else{
                  td=`<td name="addFile">`+dUp1+`<a class="dropdown-toggle caret-off" data-toggle="dropdown" href='#' style='color:#777;'><i class="fa fa-file-pdf-o" aria-hidden="true" data-toggle="tooltip" title="اضافة النسخة الضوئية!"></i></a>`+dUp2+dUp4+`</td>`
                }
                if(json[i].dateRemaind != null){
                  td2=`<td name='remaind'><a href='#' style='color:#88B04B;'><i class="fa fa-bell" aria-hidden="true" data-toggle="tooltip" title="ضبط تنبيه!"></i></a></td>`;
                }else{
                  td2=`<td name='remaind'><a href='#' style='color:#88B04B;'><i class="fa fa-bell-o" aria-hidden="true" data-toggle="tooltip" title="ضبط تنبيه!"></i></a></td>`;
                }
                td3 = '';
                if(json[i].direction == 'صادر'){
                  td3=`<td><a href='#'><i class="fa fa-file-word-o" aria-hidden="true" data-toggle="tooltip" title="تحميل الارسالية!"></i></a></td>`;
                }else{
                  td3='<td></td>';
                }
                td4 = '';
                if(isset(json[i].dossierAssocier)){
                  td4=`<td name='associer'><a href='#' style="color:#EFC050;"><i class="fa fa-link" aria-hidden="true" data-toggle="tooltip" title="تحيين الارتباط بملف!"></i></a></td>`;
                }else {
                  td4=`<td name='associer'><a href='#' style="color:#777;"><i class="fa fa-link" aria-hidden="true" data-toggle="tooltip" title="تحيين الارتباط بملف!"></i></a></td>`;
                }
                row = `
                      <tr id="`+json[i].num_ordre+`">
                        <td name="editRow"><a href='#' style='color:#EFC050;'><i class='fa fa-pencil' aria-hidden='true' data-toggle="tooltip" title="تغيير!"></i></a></td>
                        <td name="multRow"><a href='#' style='color:#006E6D;'><i class="fa fa-files-o" aria-hidden="true" data-toggle="tooltip" title="نسخ!"></i></a></td>
                        <td>`+parseInt(ignoreNull(json[i].num_ordre.substring(json[i].num_ordre.length-10)))+`</td>
                        <td>`+ignoreNull(json[i].direction)+`</td>
                        <td>`+ignoreNull(json[i].dateArriver)+`</td>
                        <td>`+ignoreNull(json[i].expediteur)+`</td>
                        <td>`+ignoreNull(json[i].destinataire)+`</td>
                        <td>`+ignoreNull(json[i].type)+`</td>
                        <td>`+ignoreNull(json[i].objet)+`</td>`+
                        td4+
                        td+
                        td3+
                        td2+`
                        <td><a href='#' style='color:#6B5B95;'><i class="fa fa-user-plus" aria-hidden="true" data-toggle="tooltip" title="احالة على!"></i></a></td>
                      </tr>
                `;
                if($('#dataTable').lenght){
                  $('#dataTable tr:last').after(row).fadeIn("slow");
                }else {
                  $('#dataTable').append(row).fadeIn("slow");
                }
              }
            }
          });
        }
        $(document).ready(function(){
              $("#myInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#dataTable tr").filter(function() {
                  $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
              });
              $.ajax({
                url:"atraf.php",
                method:"POST",
                success:function(data){
                  var json = JSON.parse(data);
                  var htm = "";
                  for (var i = 0; i < json.length; i++) {
                    htm+= '<option value="'+json[i].taraf+'">';
                  }
                  $("#lisDataAtraf").html(htm);
                }
              });
              $.ajax({
                url:"naw3.php",
                method:"POST",
                success:function(data){
                  var json = JSON.parse(data);
                  var htm = "";
                  for (var i = 0; i < json.length; i++) {
                    htm+= '<option value="'+json[i].naw3+'">';
                  }
                  $("#lisDataNaw3").html(htm);
                }
              });
              $.ajax({
                url:"mawdo3.php",
                method:"POST",
                success:function(data){
                  var json = JSON.parse(data);
                  var htm = "";
                  for (var i = 0; i < json.length; i++) {
                    htm+= '<option value="'+json[i].mawdo3+'">';
                  }
                  $("#lisDataMawdo3").html(htm);
                }
              });
              $.ajax({
                url:"tadkir.php",
                method:"POST",
                success:function(data){
                  if(isset(data)){
                    json = JSON.parse(data);
                    $("#nb_tadkir").html(json.length);
                    for (var i = 0; i < json.length; i++) {
                      row = `
                            <tr id="`+json[i].num_ordre+`">
                              <td>`+parseInt(ignoreNull(json[i].num_ordre.substring(json[i].num_ordre.length-10)))+`</td>
                              <td>`+ignoreNull(json[i].direction)+`</td>
                              <td>`+ignoreNull(json[i].dateArriver)+`</td>
                              <td>`+ignoreNull(json[i].expediteur)+`</td>
                              <td>`+ignoreNull(json[i].destinataire)+`</td>
                              <td>`+ignoreNull(json[i].type)+`</td>
                              <td>`+ignoreNull(json[i].objet)+`</td>
                              <td>`+ignoreNull(json[i].dossierAssocier)+`</td>
                              <td>`+ignoreNull(json[i].dateRemaind)+`</td>
                              <td>`+ignoreNull(json[i].textRemaind)+`</td>
                            </tr>
                      `;
                      if($('#dataTable2').lenght){
                        $('#dataTable2 tr:last').after(row).fadeIn("slow");
                      }else {
                        $('#dataTable2').append(row).fadeIn("slow");
                      }

                    }
                  }
                }
              });
               var d = new Date();
              $.ajax({
                 url:"getYears.php",
                 method:"POST",
                 success:function(data){
                   if(isset(data)){
                     json = JSON.parse(data);
                     for (var i = 0; i < json.length; i++) {
                       $('#optionRegYear').html($('#optionRegYear').html()+`<a class="dropdown-item" href="#">`+json[i].year+`</a>`);
                     }
                   }
                 }
              });
              reload(0,10);
              var dateStr = '<?php
                date_default_timezone_set('Africa/Casablanca'); // CDT

                  $info = getdate();
                  $date = $info['mday'];
                  $date = ($date<10)?'0'.$date:$date;
                  $month = $info['mon'];
                  $month = ($month<10)?'0'.$month:$month;
                  $year = $info['year'];
                  $hour = $info['hours'];
                  $hour = ($hour<10)?'0'.$hour:$hour;
                  $min = $info['minutes'];
                  $min = ($min<10)?'0'.$min:$min;
                  $sec = $info['seconds'];
                  $sec = ($sec<10)?'0'.$sec:$sec;
                  $current_date = $year.'-'.$month.'-'.$date.'T'.$hour.':'.$min.':'.$sec;
                  echo $current_date;
               ?>';
              $('#idDateTime').val(dateStr);
              $("#dateArriver").attr("type","date");
              var d = new Date(dateStr);//"2019-05-05T10:52:09.823Z");
              document.querySelector("#dateArriver").valueAsDate = d;
              $("#dateArriver").attr("type","text");
              $('.puping-label').hide();
        });
        $(document).on('click', '#annulation', function(e){
          $("#expediteur").val('');
          $("#destinataire").val('');
          $("#type").val('');
          $("#object").val('');
          $("#dossierAssocier").val('');
          $("#dateArriver").val('');
        });
        function getok(){
          var file = document.getElementById('customFile');
          var lab = document.getElementById('filelab');
          var fullPath = file.value;
          if (fullPath) {
              var startIndex = (fullPath.indexOf('\\') >= 0 ? fullPath.lastIndexOf('\\') : fullPath.lastIndexOf('/'));
              var filename = fullPath.substring(startIndex);
              if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
                  filename = filename.substring(1);
              }
              lab.innerHTML = filename;
          }
        }
        function setremaind(){
          var hidden1 = document.getElementById('remaindDate');
          var hidden2 = document.getElementById('remaindText');
          hidden1.value = document.getElementById('Rdate').value;
          hidden2.value = document.getElementById('Rtext').value;
          document.getElementById('dismiss_modal').click();
        }
        function isChecked(x){
            $("#sendorinbox2").attr('checked', $(x).children().hasClass('off'));
            dst = $('#destinataire').val();
            exp = $('#expediteur').val();
            $('#destinataire').val(exp);
            $('#expediteur').val(dst);
            if($(x).children().hasClass('off')){
              $("#dateArriver").attr('placeholder','تاريخ اصدار الوثيقة');
            }else{
              $("#dateArriver").attr('placeholder','تاريخ الارسال');
            }
        }

        $(document).on('blur','#dossierAssocier',function(){
          $(this).removeClass('highlight');
          $(this).removeClass('redlight');
          json={'NumeroDossier':$(this).val(),'IdJuridiction':293};
          $.ajax({
            url : "inf.php",
            method : "POST",
            data : {json : json},
            success:function(data){
              if(isset(data)){
                json = JSON.parse(data).d;
                if(!(json.CarteDossier == '' || json.CarteDossier == 'undefined' || json.CarteDossier == 'null' || json.CarteDossier == null)){
                  if(json.CarteDossier.NumeroCompletDossier!=''){
                    $('#dossierAssocier').addClass('highlight');
                    //alert(json.CarteDossier.NumeroCompletDossier);
                  }
                }else{
                  $('#dossierAssocier').addClass('redlight');

                }
              }
            }
          });
        });
        $(document).on('blur','#dossierAssocier20',function(){
          $(this).removeClass('highlight');
          $(this).removeClass('redlight');
          json={'NumeroDossier':$(this).val(),'IdJuridiction':293};
          $.ajax({
            url : "inf.php",
            method : "POST",
            data : {json : json},
            success:function(data){
              if(isset(data)){
                json = JSON.parse(data).d;
                if(!(json.CarteDossier == '' || json.CarteDossier == 'undefined' || json.CarteDossier == 'null' || json.CarteDossier == null)){
                  if(json.CarteDossier.NumeroCompletDossier!=''){
                    $('#dossierAssocier20').addClass('highlight');
                    //alert(json.CarteDossier.NumeroCompletDossier);
                  }
                }else{
                  $('#dossierAssocier20').addClass('redlight');

                }
              }
            }
          });
        });
        $(document).on('change','#customFile',function(){
          var file = document.getElementById('customFile');
          var hidden = $('#fileTmpName').val();
          var lab = document.getElementById('filelab');
          var fullPath = file.value;
          if (fullPath) {
            $('#progersUpload').show();
            $('#fileUpload').hide();
            var startIndex = (fullPath.indexOf('\\') >= 0 ? fullPath.lastIndexOf('\\') : fullPath.lastIndexOf('/'));
            var filename = fullPath.substring(startIndex);
            if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
                filename = filename.substring(1);
            }
            //lab.innerHTML = filename;
            $('#fileUploadName').html(filename);
            sizefile = $('#customFile')[0].files[0].size;
            sizefile = sizefile / (1024*1024);
            $('#size').html(sizefile.toFixed(2) + " Mo");

            var property = file.files[0];
            var form_data = new FormData();
            form_data.append('hidden',hidden);
            var file_name = property.name;
            var ext = file_name.split('.').pop().toLowerCase();
            var allowExt = ['pdf','doc','docx','bmp','gif','jpeg','jpg','png','tif','tiff','xls','xlsx','mdb'];
            if($.inArray(ext,allowExt) == -1){
              alert('المرجوا التأكد من صيغة الملف..!');
              $('#fileTmpName').val("");
              $('#fileUpload').show();
              $('#progersUpload').hide();
              $('#filelab').removeClass("bg-success text-white");
              $('#displayFileName').html(" نسخة الماسح الضوئي");
            }else{
              form_data.append('file',property);
              $.ajax({
                xhr: function(){
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = (evt.loaded / evt.total) * 100;
                            percentComplete = percentComplete.toFixed(2)+'%';
                            $('#progressbar').width(percentComplete);
                            $('#percentage').html(percentComplete);
                            $('#size').width(evt.total);
                        }
                   }, false);
                   return xhr;
                },
                url:"upfile.php",
                method:"POST",
                data : form_data,
                contentType : false,
                processData : false,
                beforeSend:function(){
                  $('#progressbar').width('0%')
                },
                success:function(data){
                  $('#fileUpload').show();
                  $('#progersUpload').hide();
                  $('#filelab').addClass("bg-success text-white");
                  $('#displayFileName').html(" " + file_name);
                  $('#fileTmpName').val(data);
                }
              });
            }
          }
        });
        $(document).on('change','#customFile1',function(){
          var file = document.getElementById('customFile1');
          var hidden = $('#fileTmpName1').val();
          var lab = document.getElementById('filelab1');
          var fullPath = file.value;
          if(fullPath){
            $('#progersUpload1').show();
            $('#fileUpload1').hide();
            var startIndex = (fullPath.indexOf('\\') >= 0 ? fullPath.lastIndexOf('\\') : fullPath.lastIndexOf('/'));
            var filename = fullPath.substring(startIndex);
            if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
                filename = filename.substring(1);
            }
            $('#fileUploadName1').html(filename);
            sizefile = $('#customFile1')[0].files[0].size;
            sizefile = sizefile / (1024*1024);
            $('#size1').html(sizefile.toFixed(2) + " Mo");

            var property = file.files[0];
            var form_data = new FormData();
            form_data.append('hidden',hidden);
            var file_name = property.name;
            var ext = file_name.split('.').pop().toLowerCase();
            var allowExt = ['pdf','doc','docx','bmp','gif','jpeg','jpg','png','tif','tiff','xls','xlsx','mdb'];
            if($.inArray(ext,allowExt) == -1){
              alert('المرجوا التأكد من صيغة الملف..!');
              $('#fileTmpName1').val("");
              $('#fileUpload1').show();
              $('#progersUpload1').hide();
              $('#filelab1').removeClass("bg-success text-white");
              $('#displayFileName1').html(" نسخة الماسح الضوئي");
            }else{
              form_data.append('file',property);
              $.ajax({
                xhr: function(){
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = (evt.loaded / evt.total) * 100;
                            percentComplete = percentComplete.toFixed(2)+'%';
                            $('#progressbar1').width(percentComplete);
                            $('#percentage1').html(percentComplete);
                            $('#size1').width(evt.total);
                        }
                   }, false);
                   return xhr;
                },
                url:"upfile.php",
                method:"POST",
                data : form_data,
                contentType : false,
                processData : false,
                beforeSend:function(){
                  $('#progressbar1').width('0%')
                },
                success:function(data){
                  $('#fileUpload1').show();
                  $('#progersUpload1').hide();
                  $('#filelab1').addClass("bg-success text-white");
                  $('#displayFileName1').html(" " + file_name);
                  $('#fileTmpName1').val(data);
                  $('#fileUploadName1').html("");
                  $('#size1').html("0.0 Mo");

                }
              });
            }
          }
        });
        $(document).on('click', '#submit', function(e){
          if(confirm("سيتم اضافة تسجيل جديد :")){
            var form_data={
                            "sendorinbox" : $('#sendorinbox').is(':checked'),
                            "expediteur" : $('#expediteur').val(),
                            "destinataire" : $('#destinataire').val(),
                            "type" : $('#type').val(),
                            "object" : $('#object').val(),
                            "dossierAssocier" : $('#dossierAssocier').val(),
                            "dateArriver" : $('#dateArriver').val(),
                            "fileTmpName" : $('#fileTmpName').val(),
                            "remaindDate" : $('#remaindDate').val(),
                            "remaindText" : $('#remaindText').val(),
                            "lastId" : $("#dataTable tr:first td:nth-child(3)").html()
                          };
            var demandeur = $('#demandeur').val();
            var dossierAssocier = $("#dossierAssocier").val();
            var remarque = $("#R1").val();
            json = JSON.stringify(form_data);
            $.ajax({
              url : "setRow.php",
              method : "POST",
              data : {json : json},
              success:function(data){
                var dUp1=`<div class="dropup">`;
                var dUp2=`<div class="dropdown-menu bg-primary text-right">`;
                var dUp3=`  <a class="dropdown-item " href="#" style="color:#fff"><i class="fa fa-folder-open-o" aria-hidden="true"></i> الاطلاع على الملف</a>
                            <a class="dropdown-item " href="#" style="color:#fff"><i class="fa fa-trash-o" aria-hidden="true"></i> حذف الملف</a>`;
                var dUp4=`  <a class="dropdown-item " href="#"  style="color:#fff"><i class="fa fa-plus" aria-hidden="true"></i> اضافة او تغيير ملف</a>
                          </div>
                        </div>`;
                json=JSON.parse(data);
                if(isset(json.json)){
                  row = "";
                  for (var i = 0; i < json.json.length; i++) {
                    if(json.json[i].fileID!= null){
                      td=`<td name="file">`+dUp1+`<a class="dropdown-toggle caret-off" data-toggle="dropdown" href='#' style='color:#E94B3C;'><i class="fa fa-file-pdf-o" aria-hidden="true" data-toggle="tooltip" title="الاطلاع على النسخة الضوئية!"></i></a>`+dUp2+dUp3+dUp4+`</td>`;
                    }else{
                      td=`<td name="addFile">`+dUp1+`<a class="dropdown-toggle caret-off" data-toggle="dropdown" href='#' style='color:#777;'><i class="fa fa-file-pdf-o" aria-hidden="true" data-toggle="tooltip" title="اضافة النسخة الضوئية!"></i></a>`+dUp2+dUp4+`</td>`
                    }
                    if(json.json[i].dateRemaind != null){
                      td2=`<td name='remaind'><a href='#' style='color:#88B04B;'><i class="fa fa-bell" aria-hidden="true" data-toggle="tooltip" title="ضبط تنبيه!"></i></a></td>`;
                    }else{
                      td2=`<td name='remaind'><a href='#' style='color:#88B04B;'><i class="fa fa-bell-o" aria-hidden="true" data-toggle="tooltip" title="ضبط تنبيه!"></i></a></td>`;
                    }
                    td3 = '';
                    if(json.json[i].direction == 'صادر'){
                      td3=`<td><a href='#'><i class="fa fa-file-word-o" aria-hidden="true" data-toggle="tooltip" title="تحميل الارسالية!"></i></a></td>`;
                    }else{
                      td3='<td></td>';
                    }
                    td4 = '';
                    if(isset(json.json[i].dossierAssocier)){
                      td4=`<td name='associer'><a href='#' style="color:#EFC050;"><i class="fa fa-link" aria-hidden="true" data-toggle="tooltip" title="تحيين الارتباط بملف!"></i></a></td>`;
                    }else {
                      td4=`<td name='associer'><a href='#' style="color:#777;"><i class="fa fa-link" aria-hidden="true" data-toggle="tooltip" title="تحيين الارتباط بملف!"></i></a></td>`;
                    }
                    row += `
                      <tr id="`+json.json[i].num_ordre+`">
                        <td name="editRow"><a href='#' style='color:#EFC050;'><i class='fa fa-pencil' aria-hidden='true' data-toggle="tooltip" title="تغيير!"></i></a></td>
                        <td name="multRow"><a href='#' style='color:#006E6D;'><i class="fa fa-files-o" aria-hidden="true" data-toggle="tooltip" title="نسخ!"></i></a></td>
                        <td>`+parseInt(ignoreNull(json.json[i].num_ordre.substring(json.json[i].num_ordre.length-10)))+`</td>
                        <td>`+ignoreNull(json.json[i].direction)+`</td>
                        <td>`+ignoreNull(json.json[i].dateArriver)+`</td>
                        <td>`+ignoreNull(json.json[i].expediteur)+`</td>
                        <td>`+ignoreNull(json.json[i].destinataire)+`</td>
                        <td>`+ignoreNull(json.json[i].type)+`</td>
                        <td>`+ignoreNull(json.json[i].objet)+`</td>`+
                        td4+
                        td+
                        td3+
                        td2+
                        `<td><a href='#' style='color:#6B5B95;'><i class="fa fa-user-plus" aria-hidden="true" data-toggle="tooltip" title="احالة على!"></i></a></td>
                      </tr>
                    `;
                  }
                  ($('#dataTable tr').length>0)?$('#dataTable tr:first').before(row):$('#dataTable').html(row);
                  $('#dataTable tr:first').addClass("table-success");
                  if(dossierAssocier){
                    var form_data2={
                                    "type" : $('#type').val(),
                                    "demandeur" : demandeur,
                                    "dossierAssocier" : dossierAssocier,
                                    "remarque" : remarque,
                                    "num_order" : json.json[0].num_ordre,
                                    "objet" : json.json[0].objet
                                  };
                    json = JSON.stringify(form_data2);
                    $.ajax({
                      url : "setDocNum.php",
                      method : "POST",
                      data : {json : json},
                      success:function(data){

                      }
                    });
                  }
                }else if(isset(json.validation)){
                  addAlert("warning","تنبيه",json.validation);
                }else if (isset(json.insert)) {
                  addAlert("danger","تحدير",json.insert);
                }else if (isset(json.error)) {
                  addAlert("danger","تحدير",json.error);
                }
                $('#fileTmpName').val("");
                $('#filelab').removeClass("bg-success");
                $('#filelab').removeClass("text-white");
                $('#remaindDate').val("");
                $('#remaindText').val("");
                $('#customFile').val("");
                $('#displayFileName').html(" نسخة الماسح الضوئي");
              }
            });
            $('#dossierAssocier').val('');
            $('#dossierAssocier').removeClass('highlight redlight');
            $('#demandeur').val('');
            $('#R1').val('');

          }
        });
        $(document).on('click','td[name="file"] div div a:first-child',function(e){
          e.preventDefault();
          if($("#pdfModal").css('display')== 'none'){
            $("#embedPdf").attr("src",'');
            var id=$(this).closest('tr').children('td:nth-child(3)').html();

            $.ajax({
              url : "getDoc.php",
              method : "POST",
              data : {json : id},
              success:function(data){
                response = JSON.parse(data);
                if(isset(response.path)){
                  $('#pdfModal').html("<embed type='application/pdf' width='100%' height='100%' alt='pdf' pluginspage='http://www.adobe.com/products/acrobat/readstep2.html' src='"
                  + response.path +"'></embed>");
                  $("#pdfModal").modal("toggle");
                }else{
                  addAlert('danger','تنبيه',response.error)
                }
              }
            });
          }else{
            $("#embedPdf").removeAttr("src");
          }


        });
        $(document).on('click','td[name="file"] div div a:nth-child(3),td[name="addFile"] div div a:first-child',function(e){
          e.preventDefault();
          $("#idForSetNewScan").val($(this).closest('tr').attr('id'));
          var newFile = $(this).parents().parents().children().attr("style") == "color:#777;";
          $("#ModalSetNewScan").modal("toggle");

        });
        $(document).on('click','td[name="file"] div div a:nth-child(2)',function(e){
          e.preventDefault();
          if(confirm("سيتم حذف الملف  :")){
            var id=$(this).closest('tr').attr('id');
            //delete file;
            // TODO: delet file and change icon's color as inactif
            $.ajax({
              url : "deleteFile.php",
              method : "POST",
              data : {json : id},
              success:function(data){
                json = JSON.parse(data);
                if(isset(json.statut) && json.statut){

                  $("#"+id+" td:nth-child(11)").attr("name","addFile");
                  var dUp = `<a class="dropdown-item " href="#" style="color:#fff"><i class="fa fa-plus" aria-hidden="true"></i> اضافة او تغيير ملف</a>`;
                  $("#"+id+" td:nth-child(11) div div").html(dUp);
                  $("#"+id+" td:nth-child(11) div:first-child a[class='dropdown-toggle caret-off']").attr("style","color:#777;");
                  addAlert('warning','','لقد ثم حذف الملف بنجاح ..!');
                }
              }
            });


          }
        });
        $(document).on('click','td[name="remaind"]',function(e){
          e.preventDefault();
          var id=$(this).closest('tr').children('td:nth-child(3)').html();
          $("#idForRemaindEdit").val(id);
          $("#Rdate2").val('');
          $("#Rtext2").val('');
          if(!$(this).children().children().hasClass("fa-bell-o")){
            json = JSON.stringify({"op":"get","id":id})
            $.ajax({
              url : "remaind.php",
              method : "POST",
              data : {json : json},
              success:function(data){
                rmd=JSON.parse(data);
                $("#Rdate2").val(rmd.dateRemaind);
                $("#Rtext2").val(rmd.textRemaind);
              }
            });
          }
          $("#ModalSetRemaind2").modal("toggle");
        });
        $(document).on('click','#dataTable2 tr',function(e){
          e.preventDefault();
          var id=$(this).closest('tr').children('td:first-child').html();
          $("#idForRemaindEdit").val(id);
          $("#Rdate2").val('');
          $("#Rtext2").val('');
          json = JSON.stringify({"op":"get","id":id})
          $.ajax({
            url : "remaind.php",
            method : "POST",
            data : {json : json},
            success:function(data){
              rmd=JSON.parse(data);
              $("#Rdate2").val(rmd.dateRemaind);
              $("#Rtext2").val(rmd.textRemaind);
            }
          });
          $("#ModalSetRemaind2").modal("toggle");
        });
        $(document).on('click',"#editRemaind",function(){
          var id=$("#idForRemaindEdit").val();
          json = JSON.stringify({"op":"set","id":id,"dRemaind":$('#Rdate2').val(),'tRemaind':$('#Rtext2').val()});
          $.ajax({
            url : "remaind.php",
            method : "POST",
            data : {json : json},
            success:function(data){
              if(data!="not ok"){
                $("#Rdate2").val("");
                $("#Rtext2").val("");
                $("#idForRemaindEdit").val("");
                addAlert('success','لقد ثم التغيير بنجاح','');
                var td = $("td").filter(function(){return $(this).text() == id;}).closest("tr").children().filter(function(){return $(this).attr("name")=="remaind";}).children().children();
                td.removeAttr("class");
                td.addClass("fa "+data);
              }else{
                addAlert('danger','تحدير','لم تنجح عملية التحيين');
              }
            }
          });
          $("#ModalSetRemaind2").modal("toggle");
          $('#dataTable2').html("");
          $.ajax({
            url:"tadkir.php",
            method:"POST",
            success:function(data){
              if(isset(data)){
                json = JSON.parse(data);
                $("#nb_tadkir").html(json.length);
                for (var i = 0; i < json.length; i++) {
                  row = `
                        <tr id="`+json[i].num_ordre+`">
                          <td>`+parseInt(ignoreNull(json[i].num_ordre.substring(json[i].num_ordre.length-10)))+`</td>
                          <td>`+ignoreNull(json[i].direction)+`</td>
                          <td>`+ignoreNull(json[i].dateArriver)+`</td>
                          <td>`+ignoreNull(json[i].expediteur)+`</td>
                          <td>`+ignoreNull(json[i].destinataire)+`</td>
                          <td>`+ignoreNull(json[i].type)+`</td>
                          <td>`+ignoreNull(json[i].objet)+`</td>
                          <td>`+ignoreNull(json[i].dossierAssocier)+`</td>
                          <td>`+ignoreNull(json[i].dateRemaind)+`</td>
                          <td>`+ignoreNull(json[i].textRemaind)+`</td>
                        </tr>
                  `;
                  if($('#dataTable2').lenght){
                    $('#dataTable2 tr:last').after(row).fadeIn("slow");
                  }else {
                    $('#dataTable2').append(row).fadeIn("slow");
                  }

                }
              }
            }
          });

        });
        $(document).on('click','td[name="multRow"]',function(e){
          e.preventDefault();
          var id=$(this).closest('tr').children('td:nth-child(3)').html();
          $("#idForMultRow").val(id);
          $("#nbRow").val(id);
          $("#ModalSetRemaind3").modal("toggle");
        });
        $(document).on('click',"#goMultRow",function(){
          var id=$("#idForMultRow").val();
          var copy = $("#nbCopy").val()
          json = JSON.stringify({"id":id,"nbCopy":$("#nbCopy").val(),"fristRow":$('#dataTable tr:first td:eq(2)').html()});
          $.ajax({
            url : "mult.php",
            method : "POST",
            data : {json : json},
            success:function(data){
              var dUp1=`<div class="dropup">`;
              var dUp2=`<div class="dropdown-menu bg-primary   text-right">`;
              var dUp3=`  <a class="dropdown-item " href="#" style="color:#fff"><i class="fa fa-folder-open-o" aria-hidden="true"></i> الاطلاع على الملف</a>
                          <a class="dropdown-item " href="#" style="color:#fff"><i class="fa fa-trash-o" aria-hidden="true"></i> حذف الملف</a>`;
              var dUp4=`  <a class="dropdown-item " href="#"  style="color:#fff"><i class="fa fa-plus" aria-hidden="true"></i> اضافة او تغيير ملف</a>
                        </div>
                      </div>`;
              json=JSON.parse(data);
              if(isset(json)){
                  row = "";
                for (var i = 0; i < json.length; i++) {
                  if(json[i].fileID!= null){
                    td=`<td name="file">`+dUp1+`<a class="dropdown-toggle caret-off" data-toggle="dropdown" href='#' style='color:#E94B3C;'><i class="fa fa-file-pdf-o" aria-hidden="true" data-toggle="tooltip" title="الاطلاع على النسخة الضوئية!"></i></a>`+dUp2+dUp3+dUp4+`</td>`;
                  }else{
                    td=`<td name="addFile">`+dUp1+`<a class="dropdown-toggle caret-off" data-toggle="dropdown" href='#' style='color:#777;'><i class="fa fa-file-pdf-o" aria-hidden="true" data-toggle="tooltip" title="اضافة النسخة الضوئية!"></i></a>`+dUp2+dUp4+`</td>`
                  }
                  if(json[i].dateRemaind != null){
                    td2=`<td name='remaind'><a href='#' style='color:#88B04B;'><i class="fa fa-bell" aria-hidden="true" data-toggle="tooltip" title="ضبط تنبيه!"></i></a></td>`;
                  }else{
                    td2=`<td name='remaind'><a href='#' style='color:#88B04B;'><i class="fa fa-bell-o" aria-hidden="true" data-toggle="tooltip" title="ضبط تنبيه!"></i></a></td>`;
                  }
                  td3='';
                  if(json[i].direction == 'صادر'){
                    td3=`<td><a href='#'><i class="fa fa-file-word-o" aria-hidden="true" data-toggle="tooltip" title="تحميل الارسالية!"></i></a></td>`;
                  }else{
                    td3='<td></td>';
                  }
                  if(i+1 <= copy){
                    row += `<tr id="`+json[i].num_ordre+`" class="table-info">`;
                  }else {
                    row += `<tr id="`+json[i].num_ordre+`">`;
                  }
                  row += `

                      <td name="editRow"><a href='#' style='color:#EFC050;'><i class='fa fa-pencil' aria-hidden='true' data-toggle="tooltip" title="تغيير!"></i></a></td>
                      <td name="multRow"><a href='#' style='color:#006E6D;'><i class="fa fa-files-o" aria-hidden="true" data-toggle="tooltip" title="نسخ!"></i></a></td>
                      <td>`+parseInt(ignoreNull(json[i].num_ordre.substring(json[i].num_ordre.length-10)))+`</td>
                      <td>`+ignoreNull(json[i].direction)+`</td>
                      <td>`+ignoreNull(json[i].dateArriver)+`</td>
                      <td>`+ignoreNull(json[i].expediteur)+`</td>
                      <td>`+ignoreNull(json[i].destinataire)+`</td>
                      <td>`+ignoreNull(json[i].type)+`</td>
                      <td>`+ignoreNull(json[i].objet)+`</td>
                      <td>`+ignoreNull(json[i].dossierAssocier)+`</td>`+
                      td+
                      td3+
                      td2+
                      `<td><a href='#' style='color:#6B5B95;'><i class="fa fa-user-plus" aria-hidden="true" data-toggle="tooltip" title="احالة على!"></i></a></td>
                    </tr>
                  `;
                }
                ($('#dataTable tr').length>0)?$('#dataTable tr:first').before(row):$('#dataTable').html(row);
              }
            }
          });
          $("#ModalSetRemaind3").modal("toggle");
        });
        $(document).on('click','td[name="editRow"]',function(e){
          e.preventDefault();
          //var id=$(this).closest('tr').children('td:nth-child(3)').html();
          var id=$(this).closest('tr').attr('id');
          $("#idForEditRow2").val(id);
          $("#expediteur2").val("");
          $("#destinataire2").val("");
          $("#type2").val("");
          $("#object2").val("");
          $("#dossierAssocier2").val("");
          $("#dateArriver2").val("");
          json = JSON.stringify({"id":id});
          $.ajax({
            url : "getRow.php",
            method : "POST",
            data : {json : json},
            success:function(data){
              json=JSON.parse(data);
              if(json.direction == "وارد"){
                $("#sendorinbox2").bootstrapToggle('on');
              }else{
                $("#sendorinbox2").bootstrapToggle('off');
              }
              $("#expediteur2").val(json.expediteur);
              $("#destinataire2").val(json.destinataire);
              $("#type2").val(json.type);
              $("#objct2").val(json.objet);
              $("#dossierAssocier2").val(json.dossierAssocier);
              $("#dateArriver2").val(json.dateArriver);
            }
          });
          $("#ModalEditRow").modal("toggle");
        });
        $(document).on('click',"#goEditRow3",function(){
          var id=$("#idForEditRow2").val();
          json = JSON.stringify({"id":id,
                                  "direction":($('#sendorinbox2').is(':checked'))?"وارد":"صادر",
                                  "expediteur":$("#expediteur2").val(),
                                  "destinataire":$('#destinataire2').val(),
                                  "type":$("#type2").val(),
                                  "objet":$("#objct2").val(),
                                  "dateArriver":$("#dateArriver2").val()});
          $.ajax({
            url : "editRow.php",
            method : "POST",
            data : {json : json},
            success:function(data){
              if(data == "ok"){
                $('#myTable tr[id='+id+'] td:eq(3)').html(($('#sendorinbox2').is(':checked'))?"وارد":"صادر");
                $('#myTable tr[id='+id+'] td:eq(5)').html($("#expediteur2").val());
                $('#myTable tr[id='+id+'] td:eq(6)').html($("#destinataire2").val());
                $('#myTable tr[id='+id+'] td:eq(7)').html($("#type2").val());
                $('#myTable tr[id='+id+'] td:eq(8)').html($("#objct2").val());
                $('#myTable tr[id='+id+'] td:eq(4)').html($("#dateArriver2").val());
                if($('#sendorinbox2').is(':checked')){
                  $('#myTable tr[id='+id+'] td:eq(11)').html('');
                }else{
                  $('#myTable tr[id='+id+'] td:eq(11)').html(`<a href='#'><i class="fa fa-file-word-o" aria-hidden="true" data-toggle="tooltip" title="تحميل الارسالية!"></i></a>`);
                }
              }
            }
          });
          $("#ModalEditRow").modal("toggle");
        });
        $(document).on('click',"#upfile2",function(){
          file = JSON.parse($("#fileTmpName1").val());
          id= $("#idForSetNewScan").val();
          newFile =($('#'+id+' td:nth-child(11)').attr("name")=="addFile")?true:false;
          json=JSON.stringify({"id":id,"file":file,"newFile":newFile});
          $.ajax({
            url : "changeFile.php",
            method : "POST",
            data : {json : json},
            success:function(data){
              json = JSON.parse(data);
              if(isset(json.statut) && json.statut){
                //// TODO: change pdf icon's color as actif
                $("#"+id+" td:nth-child(11)").attr("name","file");
                var dUp=` <a class="dropdown-item " href="#" style="color:#fff"><i class="fa fa-folder-open-o" aria-hidden="true"></i> الاطلاع على الملف</a>
                          <a class="dropdown-item " href="#" style="color:#fff"><i class="fa fa-trash-o" aria-hidden="true"></i> حذف الملف</a>
                          <a class="dropdown-item " href="#" style="color:#fff"><i class="fa fa-plus" aria-hidden="true"></i> اضافة او تغيير ملف</a>`;
                $("#"+id+" td:nth-child(11) div div").html(dUp);
                $("#"+id+" td:nth-child(11) div:first-child a[class='dropdown-toggle caret-off']").attr("style","color:#E94B3C;");
                addAlert('success','','لقد ثم اضافة الملف بنجاح');
                //_____________ add row to setDocNum
                json2 = JSON.stringify({"type":json.data.type,"demandeur":"","dossierAssocier":json.data.dossierAssocier,"remarque":"","num_order":json.data.num_ordre,"objet":""});
                $.ajax({
                  url : "setDocNum.php",
                  method : "POST",
                  data : {json : json2},
                  success:function(data){
                    console.log('ok');
                  }
                });
              }
              $("#idForSetNewScan").val('');
              $('#fileTmpName1').val("");
              $('#fileUpload1').show();
              $('#progersUpload1').hide();
              $('#filelab1').removeClass("bg-success text-white");
              $('#displayFileName1').html(" نسخة الماسح الضوئي");
            }
          });
          $("#ModalSetNewScan").modal("toggle");
        });
        $(document).on('click','td:nth-child(12)',function(e){
          var json= JSON.stringify({"id":$(this).closest('tr').attr('id')});
          $("#idForDownload").val($(this).closest('tr').attr('id'));
          if($(this).html() != ''){
            $.ajax({
              url : "getContenetForUser.php",
              method : "POST",
              data : {json : json},
              success:function(data){
                if(isset(data)){
                  json=JSON.parse(data);
                  $("#nb_order").val(json.nb_order.split('{br}').join('\n'));
                  $("#text").val(json.text.split('{br}').join('\n'));
                  $("#nb_copy").val(json.nb_copy.split('{br}').join('\n'));
                  $("#remarque").val(json.remarque.split('{br}').join('\n'));
                  $("#idOriginForDownload").val(json.id_order);
                }
              }
            });
            $("#ModalEditDoc").modal("toggle");
            }
        });
        $(document).on('click','#downfile',function(e){
          var id = $("#idForDownload").val();
          json=JSON.stringify({
            "id":id,
            "nb_order":$("#nb_order").val().split('\n').join('{br}'),
            "text":$("#text").val().split('\n').join('{br}'),
            "nb_copy":$("#nb_copy").val().split('\n').join('{br}'),
            "remarque":$("#remarque").val().split('\n').join('{br}'),
            "id_origin":$("#idOriginForDownload").val()
          });
          $.ajax({
            url : "download.php",
            method : "POST",
            data : {json : json},
            success:function(data){
              if(isset(data)){
                json = JSON.parse(data);
                var link = document.createElement('a');
                link.href = json.file;
                link.download = json.filename;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
              }
            }
          });
          $("#ModalEditDoc").modal("toggle");
        });
        $(document).on('click','#optionRegYear a',function(e){
          var year = $(this).html();
          var json = JSON.stringify({'year':year});
          $.ajax({
            url:"getReg.php",
            method:"POST",
            data:{json : json},
            success:function(data){
                if(isset(data)){
                  json = JSON.parse(data);
                  var link = document.createElement('a');
                  link.href = json.file;
                  link.download = json.filename;
                  document.body.appendChild(link);
                  link.click();
                  document.body.removeChild(link);
                }
            }
          });
        });
        $(document).on('focus','.input-poping',function(e){
          $(this).next().html($(this).attr('placeholder'));
          $(this).next().show();
          $(this).attr('placeholder','');
        });
        $(document).on('blur','.input-poping',function(e){
          $(this).next().hide();
          $(this).attr('placeholder',$(this).next().html());
          $(this).next().html('');
        });
        $(document).on('click','#save10',function(e){
          $('#ModalSetAttachement').modal('toggle');
        });
        $(document).on('click','td[name="associer"]',function(e){
          e.preventDefault();
          //var id=$(this).closest('tr').children('td:nth-child(3)').html();
          var id=$(this).closest('tr').attr('id');
          $("#idForEditAssocier").val(id);
          $("#dossierAssocier20").removeClass('redlight highlight');
          $("#dossierAssocier20").val('');
          $("#demandeur20").val('');
          $("#r201").val('');
          $("#demandeur20").removeAttr("style");
          $("#dossierAssocier20").removeAttr("style");

          json=JSON.stringify({"id":id});
          $.ajax({
            url:"getAttachmentData.php",
            method:"POST",
            data:{json : json},
            success:function(data){
                if(isset(data)){
                  json = JSON.parse(data);
                  if(json.stat){
                    $("#dossierAssocier20").val(json.data.dossierAssocier);
                    $("#demandeur20").val(json.data.demandeur);
                    $("#r201").val(json.data.remarque);

                  }
                }
            }
          });
          $("#ModalSetAttachement2").modal('toggle');
        });
        $(document).on('click','#save11',function(e){
          e.preventDefault();
          test = false;
          if(isset($("#dossierAssocier20").val())){
            test=true;
            $("#dossierAssocier20").removeAttr("style");
          }else {
            test=false;
            $("#dossierAssocier20").attr("style","border-color:rgba(255,0,0,0.7);");
          }
          if(isset($("#demandeur20").val())){
            test=true;
            $("#demandeur20").removeAttr("style");
          }else {
            test=false;
            $("#demandeur20").attr("style","border-color:rgba(255,0,0,0.7);");
          }
          if(test){
            var id=$("#idForEditAssocier").val();
            json=JSON.stringify({"num_ordre":id,"dossierAssocier":$("#dossierAssocier20").val(),"demandeur":$("#demandeur20").val(),"remarque":$("#r201").val()});
            $.ajax({
              url:"updateAttachment.php",
              method:"POST",
              data:{json : json},
              success:function(data){
                  if(isset(data)){
                    json = JSON.parse(data);
                    if(json.stat && json.icon){
                      $("#"+id+" td[name='associer'] a").attr("style","color:#EFC050;");
                      addAlert("success","تم ربط التسجيل بنجاح مع الملف",$("#dossierAssocier20").val());
                    }
                  }
              }
            });
            $("#ModalSetAttachement2").modal('toggle');
          }
        });
        $(document).on('click','#delete11',function(e){
          e.preventDefault();
          var id=$("#idForEditAssocier").val();
          json=JSON.stringify({"num_ordre":id});

          $.ajax({
            url:"deleteAttachment.php",
            method:"POST",
            data:{json : json},
            success:function(data){
              if(isset(data)){
                json = JSON.parse(data);
                if(json.stat && json.icon==false){
                  $("#"+id+" td[name='associer'] a").attr("style","color:#777;");
                  addAlert("warning","تم حدف الارتباط بنجاح","");
                }
              }
            }
          });
          $("#ModalSetAttachement2").modal('toggle');
        });
      </script>
    </head>
    <body>
      <?php
        if (Session::exists("success")) {
          echo Session::flash("success");
        }
        $user = new User();
        if($user->isLoggedIn()){
          include 'includes/nav.php';?>


      <div class="container">
        <h3 class="text-right title"><i class="fa fa-caret-left" aria-hidden="true"></i> <i class="fa fa-book" aria-hidden="true"></i><u> تدبير سجل مكتب الضبط الالكتروني </u> "<?php echo $user->memeberOf("مكتب الضبط")["label"];?>"</h3>
        <ul class="nav nav-tabs">
          <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#sijil">تحديث السجل</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#tadkir">التذاكير<span id='nb_tadkir' class="badge badge-danger"></span></a>
          </li>
        </ul>
        <div class="tab-content">
          <div id="sijil" class="tab-pane active"><br>
            <div class="text-center controles">
              <button class="btn btn-success" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"><strong><i class="fa fa-pencil-square-o" aria-hidden="true"></i> اضافة تسجيل جديد</strong></button>
              <button style="display:none" class="btn btn-warning" data-toggle="collapse" data-target="#collapseTwo2" aria-expanded="false" aria-controls="collapseTwo"><strong><i class="fa fa-search" aria-hidden="true"></i> بحث</strong></button>
              <button style="display:none" class="btn btn-info" data-toggle="collapse" data-target="#collapseThree3" aria-expanded="false" aria-controls="collapseThree"><strong><i class="fa fa-binoculars" aria-hidden="true"></i> بحث متعدد الوسائط</strong></button>
              <div class="dropdown" style="display:inline;">
                <button class="btn btn-outline-secondary dropdown-toggle" data-toggle="dropdown" id="selectRegYear">
                  <strong>
                    <i class="fa fa-file-excel-o" aria-hidden="true"></i> تحميل السجل
                  </strong>
                </button>
                <div class="dropdown-menu" id="optionRegYear">

                </div>
              </div>
            </div>
            <div id="accordion">
              <div class="card">
                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                  <div class="card-body">
                    <div class="text-right">
                      <form action="" method="get">
                        <div class="form-group row">
                          <div id="forcheck" class="col-2" onclick="isChecked(this);">
                            <input type="checkbox" name="sendorinbox" class="toogle-switch" id="sendorinbox" data-width="100" data-toggle="toggle" data-on="وارد" data-off="صادر" data-onstyle="success" data-offstyle="warning">
                          </div>
                          <div class="col-5 input-col">
                            <input class="form-control input-poping" list="lisDataAtraf" type="text" name="expediteur" placeholder="اسم المرسل" id="expediteur" value="<?php
                                if($user->memeberOf("مكتب الضبط")["label"]!="سجل الكتابة الخاصة"){
                                  echo "رئيس مصلحة كتابة الضبط بالمحكمة الادارية بأكادير";
                                }else{
                                  echo "رئيس المحكمة الادارية بأكادير";
                                }
                              ?>">
                            <label for="" class="puping-label" ></label>
                          </div>
                          <div class="col-5 input-col">
                            <input class="form-control input-poping" list="lisDataAtraf" type="text" name="destinataire" placeholder="اسم المرسل اليه" id="destinataire">
                            <label for="" class="puping-label" ></label>
                          </div>
                        </div>
                        <div class="form-group row">
                          <div class="col-3 input-col">
                            <input class="form-control input-poping" list="lisDataNaw3" type="text" name="type" placeholder="نوعها" id="type">
                            <label for="" class="puping-label" ></label>
                          </div>
                          <div class="col-3 input-col">
                            <input class="form-control input-poping" list="lisDataMawdo3" type="text" name="object" placeholder="موضوعها" id="object">
                            <label for="" class="puping-label" ></label>
                          </div>
                          <div class="col-3 input-col">
                            <input placeholder="تاريخ الارسال" class="form-control input-poping" type="text" name="dateArriver" id="dateArriver">
                            <label for="" class="puping-label" ></label>
                          </div>
                          <div class=" bnt-control">
                              <div id="upload&Progressbar">
                                <div class="form-group" id="fileUpload">
                                      <div class="custom-file mb-3">
                                        <input type="file" class="custom-file-input" id="customFile" name="filename">
                                        <label class="custom-file-label text-center" for="customFile" id="filelab"><i style="font-size:12px;" class="fa fa-clone" aria-hidden="true" id="displayFileName"> نسخة الماسح الضوئي</i></label>
                                        <input type="hidden" value="" id="fileTmpName">
                                      </div>
                                </div>
                                <div class="form-group" style="display:none;" id="progersUpload">

                                      <div class="small-text">
                                        <span style="float:right;font:12px;font-weight: bold;" id="fileUploadName"></span><br/>
                                        <div class="row text-right">
                                          <div class="col-3"><span id="percentage"></span></div>
                                          <div class="col-5"></div>
                                          <div class="col-4"><span id="size"></span></div>
                                        </div>
                                        <div class="progress " style="height:2px">
                                          <div class="progress-bar" id="progressbar" style="width:0%;height:2px"></div>
                                        </div>
                                      </div>
                                  </div>

                              </div>
                          </div>
                        </div>
                        <div class="form-group row">
                          <button type="button" class="btn btn-warning bnt-control" data-toggle="modal" data-target="#ModalSetAttachement" /><i class="fa fa-link" aria-hidden="true"> ربط بملف</i></button>
                          <button type="button" class="btn btn-info bnt-control" data-toggle="modal" data-target="#ModalSetRemaind" /><i class="fa fa-bell-o" aria-hidden="true"> ضبط تذكير</i></button>
                          <input type="hidden" id="remaindDate" name="remaindDate" value="">
                          <input type="hidden" id="remaindText" name="remaindText" value="">
                          <button type="button" class="btn btn-success bnt-control" id="submit"><i class="fa fa-check" aria-hidden="true"> إضافة</i></button>
                          <button type="button" class="btn btn-danger bnt-control" data-toggle="collapse" data-target="#collapseOne" id="annulation"><i class="fa fa-undo" aria-hidden="true"> الغاء</i></button>
                        </div>
                      </from>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <hr />
            <div class="" id="rslt">
              <input id="myInput" type="text" placeholder="البحث..">
              <table class="table table-striped table-bordered table-hover text-right" id="myTable">
                <thead class="thead-dark">
                  <tr>
                    <th class="align-middle text-center" style="width: 2%;"></th>
                    <th class="align-middle text-center" style="width: 2%;"></th>
                    <th class="align-middle" style="width: 4%;">الرقم الترتيبي</th>
                    <th class="align-middle" style="width: 4%;">صادر / وارد</th>
                    <th class="align-middle" style="width: 10%;">تاريخ الورود / الاصدار</th>
                    <th class="align-middle" style="width: 23%;">المرسل</th>
                    <th class="align-middle" style="width: 23%;">المرسل اليه</th>
                    <th class="align-middle" style="width: 6%;">نوعها</th>
                    <th class="align-middle" style="width: 14%;">موضوعها</th>
                    <th class="align-middle" style="width: 2%;"></th>
                    <th class="align-middle" style="width: 2%;"></th>
                    <th class="align-middle" style="width: 2%;"></th>
                    <th class="align-middle" style="width: 2%;"></th>
                    <th class="align-middle" style="width: 2%;"></th>
                  </tr>
                </thead>
                <tbody id='dataTable'>

                </tbody>
                <tfooter>
                  <tr class="">
                    <td colspan="14" class="text-center bt-marge" ><button type="button" onclick="reload(0,0);" class="btn btn-block collapsed btn-default">
                      <strong><i class="fa fa-caret-down" aria-hidden="true"></i> تحميل المزيد <i class="fa fa-caret-down" aria-hidden="true"></i></strong>
                      </button>
                    </td>
                  </tr>
                  <tr class="">
                    <td colspan="14" class="text-center bt-marge" ><button type="button" onclick="reload(0,99999);" class="btn btn-block collapsed btn-default">
                      <strong><i class="fa fa-caret-down" aria-hidden="true"></i>تحميل الكل<i class="fa fa-caret-down" aria-hidden="true"></i></strong>
                      </button>
                    </td>
                  </tr>
                </tfooter>
              </table>
            </div>
          </div>
          <div id="tadkir" class="tab-pane fade"><br><br><br>
            <div class="" id="rslt">
              <table class="table table-striped table-bordered table-hover text-right" id="myTable2">
                <thead class="thead-dark">
                  <tr>
                    <th class="align-middle" style="width: 4%;">الرقم الترتيبي</th>
                    <th class="align-middle" style="width: 4%;">صادر / وارد</th>
                    <th class="align-middle" style="width: 10%;">تاريخ الورود / الاصدار</th>
                    <th class="align-middle" style="width: 17%;">المرسل</th>
                    <th class="align-middle" style="width: 17%;">المرسل اليه</th>
                    <th class="align-middle" style="width: 6%;">نوعها</th>
                    <th class="align-middle" style="width: 12%;">موضوعها</th>
                    <th class="align-middle" style="width: 10%;">الملف المرتبط</th>
                    <th class="align-middle" style="width: 10%;">تاريخ التذكير</th>
                    <th class="align-middle" style="width: 10%;">مضمون التذكير</th>
                  </tr>
                </thead>
                <tbody id='dataTable2'>

                </tbody>
                <tfooter>
                </tfooter>
              </table>
            </div>

          </div>
        </div>
      </div>
      <div id="outbody">
        <datalist id="lisDataAtraf">
          </datalist>
        <datalist id="lisDataNaw3">
          </datalist>
        <datalist id="lisDataMawdo3">
          </datalist>
        <div class="modal" id="pdfModal">

        </div>
        <div class="modal fade" id="ModalSetRemaind" tabindex="-1" role="dialog" >
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header row">
                <div class="text-right col-6">
                  <h5 class="modal-title">ضبط تذكير</h5>
                </div>
                <div class="col-5"></div>
                <div class="col-1">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
              </div>
              <div class="modal-body">
                <form>
                  <input placeholder="تاريخ التذكير" class="form-control" type="text" onfocus="(this.type='date')" onblur="(this.type='text')"  id="Rdate">
                  <textarea class="form-control" placeholder="ملاحظة"  id="Rtext"></textarea>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" style="margin-left:5px;" onclick="setremaind();">حفظ</button>
                <button type="button" class="btn btn-secondary" id="dismiss_modal" data-dismiss="modal">الغاء</button>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="ModalSetRemaind2" tabindex="-1" role="dialog" >
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header row">
                <div class="text-right col-6">
                  <h5 class="modal-title">ضبط تذكير</h5>
                </div>
                <div class="col-5"></div>
                <div class="col-1">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
              </div>
              <div class="modal-body">
                <form>
                  <input placeholder="تاريخ التذكير" class="form-control" type="text" onfocus="(this.type='date')" onblur="(this.type='text')"  id="Rdate2">
                  <textarea class="form-control" placeholder="ملاحظة"  id="Rtext2"></textarea>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" style="margin-left:5px;" id="editRemaind">حفظ</button>
                <button type="button" class="btn btn-secondary" id="dismiss_modal" data-dismiss="modal">الغاء</button>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="ModalSetRemaind3" tabindex="-1" role="dialog" >
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header row">
                <div class="text-right col-6">
                  <h5 class="modal-title">ضبط تذكير</h5>
                </div>
                <div class="col-5"></div>
                <div class="col-1">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
              </div>
              <div class="modal-body">
                <form>
                  <div class="input-group row" style="margin-bottom:10px;">
                    <label for="nbRow" class="col-4" >الرقم الترتيبي</label>
                    <input type="text" name="nbRow" id="nbRow" value="" class="col-4" disabled>
                  </div>
                  <div class="input-group row">
                    <label for="nbRow" class="col-4">عدد النسخ</label>
                    <input type="number" name="nbRow" id="nbCopy" class="col-4">
                  </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" style="margin-left:5px;" id="goMultRow">حفظ</button>
                <button type="button" class="btn btn-secondary" id="dismiss_modal" data-dismiss="modal">الغاء</button>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="ModalEditRow" tabindex="-1" role="dialog" >
          <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header row">
                <div class="text-right col-6">
                  <h5 class="modal-title">تغيير التسجيل</h5>
                </div>
                <div class="col-5"></div>
                <div class="col-1">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
              </div>
              <div class="modal-body ">
                <form>
                  <div class="form-group row">
                    <div id="forcheck2" class="col-2">
                      <input type="checkbox" name="sendorinbox2" class="toogle-switch" id="sendorinbox2" data-width="100" data-toggle="toggle" data-on="وارد" data-off="صادر" data-onstyle="success" data-offstyle="warning">
                    </div>
                    <div class="col-5">
                      <input class="form-control" list="lisDataAtraf" type="text" name="expediteur" placeholder="اسم المرسل" id="expediteur2" value="رئيس مصلحة كتابة الضبط بالمحكمة الادارية بأكادير">
                    </div>
                    <div class="col-5">
                      <input class="form-control" list="lisDataAtraf" type="text" name="destinataire" placeholder="اسم المرسل اليه" id="destinataire2">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-4">
                      <input class="form-control" list="lisDataNaw3" type="text" name="type" placeholder="نوعها" id="type2">
                    </div>
                    <div class="col-4">
                      <input class="form-control" list="lisDataMawdo3" type="text" name="object" placeholder="موضوعها" id="objct2">
                    </div>
                    <div class="col-3" style="display:none;visibility:hidden;" >
                      <input class="form-control" type="text" name="dossierAssocier" placeholder="مرتبطة بملف" id="dossierAssocier2" autocomplete="on">
                    </div>
                    <div class="col-4">
                      <input placeholder="تاريخ الوصول" class="form-control" type="text" name="dateArriver" id="dateArriver2">
                    </div>
                  </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" style="margin-left:5px;" id="goEditRow3">تغيير</button>
                <button type="button" class="btn btn-secondary" id="dismiss_modal2" data-dismiss="modal">الغاء</button>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="ModalSetNewScan" tabindex="-1" role="dialog" >
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header row">
                <div class="text-right col-6">
                  <h5 class="modal-title">تغيير النسخة الضوئية</h5>
                </div>
                <div class="col-5"></div>
                <div class="col-1">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
              </div>
              <div class="modal-body">
                <form>
                  <input type="hidden" id="idForSetNewScan" name="" value="">
                  <div class="row">
                    <div class="col-2">
                    </div>
                    <div class="col-8">
                      <div id="upload&Progressbar1">
                        <div class="form-group" id="fileUpload1">
                              <div class="custom-file">
                                <input type="file" class="custom-file-input" id="customFile1" name="filename">
                                <label class="custom-file-label text-center" for="customFile" id="filelab1"><i style="font-size:12px;" class="fa fa-clone" aria-hidden="true" id="displayFileName1"> نسخة الماسح الضوئي</i></label>
                                <input type="hidden" value="" id="fileTmpName1">
                              </div>
                        </div>
                        <div class="form-group" style="display:none;" id="progersUpload1">

                              <div class="small-text">
                                <span style="float:right;font:12px;font-weight: bold;" id="fileUploadName1"></span><br/>
                                <div class="row text-right">
                                  <div class="col-3"><span id="percentage1"></span></div>
                                  <div class="col-5"></div>
                                  <div class="col-4"><span id="size1"></span></div>
                                </div>
                                <div class="progress " style="height:2px">
                                  <div class="progress-bar" id="progressbar1" style="width:0%;height:2px"></div>
                                </div>
                              </div>
                          </div>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" style="margin-left:5px;" id="upfile2">تغيير</button>
                <button type="button" class="btn btn-secondary" id="dismiss_modal" data-dismiss="modal">الغاء</button>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="ModalEditDoc" tabindex="-1" role="dialog" >
          <div class="modal-dialog  modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header row">
                <div class="text-right col-6">
                  <h5 class="modal-title">تعبئة الارسالية</h5>
                </div>
                <div class="col-5"></div>
                <div class="col-1">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
              </div>
              <div class="modal-body">
                <form>
                  <div class="row">
                    <div class="col-1">

                    </div>
                    <div class="col-9">
                        <textarea id="nb_order" rows="18" style="width:10%;padding:0;margin:0;" placeholder="الرقم الترتيبي"></textarea>
                        <textarea id="text" rows="18" style="width:39%;padding:0;margin:0;" placeholder="مضمون الارسالية"></textarea>
                        <textarea id="nb_copy" rows="18" style="width:10%;padding:0;margin:0;" placeholder="عدد النسخ"></textarea>
                        <textarea id="remarque" rows="18" style="width:30%;padding:0;margin:0;" placeholder="ملاحظات"></textarea>
                    </div>
                  </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" style="margin-left:5px;" id="downfile">تحميل</button>
                <button type="button" class="btn btn-secondary" id="dismiss_modal" data-dismiss="modal">الغاء</button>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="ModalSetAttachement" tabindex="-1" role="dialog" >
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header row">
                <div class="text-right col-6">
                  <h5 class="modal-title">ربط مع ملف </h5>
                </div>
                <div class="col-5"></div>
                <div class="col-1">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
              </div>
              <div class="modal-body">
                <form style="width:80%;margin:0 auto;">
                  <div class="form-group">
                      <input class="form-control" type="text" name="dossierAssocier" placeholder="مرتبطة بملف" id="dossierAssocier" autocomplete="on">
                  </div>
                  <div class="form-group">
                      <input class="form-control" type="text" name="dossierAssocier" placeholder="الجهة المعنية بالاجراء" id="demandeur" autocomplete="on">
                  </div>
                  <div class="form-group">
                      <textarea class="form-control" type="text" name="dossierAssocier" id="R1" placeholder="ملاحظات"  autocomplete="on"></textarea>
                  </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" style="margin-left:5px;" id='save10'>اضافة</button>
                <button type="button" class="btn btn-secondary" id="dismiss_modal9" data-dismiss="modal">الغاء</button>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="ModalSetAttachement2" tabindex="-1" role="dialog" >
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header row">
                <div class="text-right col-6">
                  <h5 class="modal-title">ارتباط الملف</h5>
                </div>
                <div class="col-5"></div>
                <div class="col-1">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
              </div>
              <div class="modal-body">
                <form style="width:80%;margin:0 auto;">
                  <div class="form-group row">
                      <label for="dossierAssocier20" class="float-right text-right col-4">مرتبطة بملف</label>
                      <input class="form-control col-8" type="text" name="dossierAssocier" placeholder="مرتبطة بملف" id="dossierAssocier20" autocomplete="on">
                  </div>
                  <div class="form-group row">
                      <label for="demandeur20" class="float-right text-right col-4">الجهة المعنية بالاجراء</label>
                      <input class="form-control col-8" type="text" name="dossierAssocier" placeholder="الجهة المعنية بالاجراء" id="demandeur20" autocomplete="on">
                  </div>
                  <div class="form-group row">
                      <label for="r201" class="float-right text-right col-4">ملاحظات</label>
                      <textarea class="form-control col-8" type="text" name="dossierAssocier" id="r201" placeholder="ملاحظات"  autocomplete="on"></textarea>
                  </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" style="margin-left:5px;" id='delete11'>حدف الارتباط</button>
                <button type="button" class="btn btn-primary" style="margin-left:5px;" id='save11'>حقظ التعديلات</button>
                <button type="button" class="btn btn-secondary" id="dismiss_modal11" data-dismiss="modal">الغاء</button>
              </div>
            </div>
          </div>
        </div>

        <input type="hidden" id="idForEditAssocier" name="" value="">
        <input type="hidden" id="idForRemaindEdit" name="" value="">
        <input type="hidden" id="idForMultRow" name="" value="">
        <input type="hidden" id="idForEditRow" name="" value="">
        <input type="hidden" id="idForEditRow2" name="" value="">
        <input type="hidden" id="idForDelete" name="" value="">
        <input type="hidden" id="idForDownload" name="" value="">
        <input type="hidden" id="idOriginForDownload" name="" value="">
        <input type="hidden" id="idDateTime" name="" value="">
      </div>


      <?php
        /*if ($user->hasPermissions("admin")) {
          echo "<p>You are an Administrator</p>";
        }
        if ($user->hasPermissions("modirator")) {
          echo "<p>You are a Modirator</p>";
        }*/
      }else{
        Redirect::to("login.php");
      }
      ?>


    </body>

  </html>

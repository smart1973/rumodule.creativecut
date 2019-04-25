$(document).ready(function () {
  var uploadFile, checkFile = function (file) {
    var allowedExtensions = ['dxf'];
    try {
      var extension = file.name.substr(file.name.lastIndexOf('.') + 1).toLowerCase();
      try {
        for (var i = 0; i < allowedExtensions.length; i++) {
          if (allowedExtensions[i] == extension) throw 0;
        }
        throw 1;
      }
      catch (e) {if (e) throw e;}
      uploadFile = file;
      $('#selected-file-name')[0].className = 'file-type-' + extension;
      $('#selected-file-name span:first-child').text(file.name);
      $('#selected-file-name').css('display', 'block');
      $('.drag-and-drop').css('display', 'none');
      $('#file-name').val(file.name.substr(0, file.name.lastIndexOf('.')));
    }
    catch (e) {
      uploadFile = undefined;
      $('#selected-file-name')[0].className = '';
      $('#selected-file-name span:first-child').text('');
      $('#selected-file-name').css('display', 'none');
      $('.drag-and-drop').css('display', 'block');
      $('#file-name').val('');
      $('#graphic-module-file').val('');
      if (e === 1) creativecut_alert('ניתן להעלות אך ורק קבצי ' + allowedExtensions.join(', ') + ' בשלב זה');
    }
  }, saveFile = function (file, name) {
    var formData = new FormData(), xhr = new XMLHttpRequest();
    formData.append('graphic_module_file', file);
    formData.append('file_name', name);
    formData.append('public', $('#public').length && $('#public').prop('checked') ? 1 : 0);
    xhr.open('POST', '/save-file', true);
    $('#selected-file-name span:last-child').css('display', 'inline-block');
    xhr.upload.onprogress = function (e) {
      var percents = Math.round(e.loaded / e.total * 100);
      $('#upload-progress').css('width', percents + '%');
      $('#selected-file-name span:last-child').text(percents + '%');
      if (e.loaded == e.total) {
        $('#selected-file-name span:first-child').text('המתן בבקשה, הקובץ נטען');
        $('#selected-file-name span:last-child').text('');
        $('#selected-file-name span:last-child').css('display', 'none');
      }
    };
    xhr.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        try {
          var res = JSON.parse(this.responseText);
          if (res.status == 'success' && typeof res.id == 'number') {
            window.location.href = '/file/' + res.id;
          }
          else if (res.status == 'error' && res.type) {
            creativecut_alert(res.type);
          }
          else throw 1;
        }
        catch (e) {
          creativecut_alert('Erros');
        }
      }
    };
    xhr.send(formData);
  };

  $('#graphic-module-file').change(function () {checkFile(this.files[0]);});
  $('.drag-and-drop-wrapper')[0].ondragover = function() {
    return false;
  };
  $('.drag-and-drop-wrapper')[0].ondragleave = function() {
    return false;
  };
  $('.drag-and-drop-wrapper')[0].ondrop = function (e) {
    checkFile(e.dataTransfer.files[0]);
    e.preventDefault();
  };

  $('#upload-file').click(function () {
    if (!$('#file-name').val() || !uploadFile) {
      var message = [];
      //if (!uploadFile) message.push(' - יש לבחור קובץ');
      //if (!$('#file-name').val()) message.push(' - לא צריך את המשפט הזה!');
      if (!uploadFile || !$('#file-name').val()) message.push('יש לבחור קובץ');
      creativecut_alert(message.join("\n"));
    }
    else saveFile(uploadFile, $('#file-name').val());
  });
});
jQuery( function ( $ ) {
  var ajax;

  if (typeof ajax_object !== 'undefined') {
    ajax = ajax_object;
  }

  function alertError(msg='') {
    return swal("MapTheMissing Error", msg, "error");
  }

  function alertSuccess(msg ='') {
    return swal('MapTheMissing Success', msg, 'success');
  }

  function alertWarning(msg='') {
    return swal('MapTheMissing Warning', msg, 'warning');
  }

  function showSpinner()
  {
    $('#mapthemissing .inside').prepend('<div id="mapthemissing-spinner"><i class="mapthemissing-spin"></i><span>Running job (be patient, complex jobs can take some time)...</span></div>');
  }

  function hideSpinner()
  {
    $('#mapthemissing-spinner').remove();
  }

  function copyToClipboard(text) {
    let $temp = $("<input>");
    $("body").append($temp);
    $temp.val(text).select();
    document.execCommand("copy");
    $temp.remove();
  }
});

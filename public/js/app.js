$("#asset-form").submit( function(e) {
  loadAjax();
  e.returnValue = false;
});